<?php
require_once '../Model/booking.php'; // Adjust path if needed
$statusFilter = isset($_GET['status']) ? $_GET['status'] : 'all';
$bookings = getAllBookings($statusFilter);

?>
<!DOCTYPE html>
<html>
<head>
  <title>Manage Bookings</title>
  <link rel="stylesheet" href="/TKCafe/public/css/admin.css">
  <style>
    .status-dropdown {
      padding: 4px 6px;
      font-size: 0.9rem;
    }
  </style>
</head>
<body>
  <div class="admin-container">
    <?php require 'partials/sidebar.php'; ?>

    <main class="main-content">
      <header class="top-header">
        <h1>Manage Bookings</h1>
      </header>

      <!-- Filters -->
      <div class="booking-filters">
        <a href="manage_booking.php" class="<?= $statusFilter === 'all' ? 'active' : '' ?>">All</a>
        <a href="manage_booking.php?status=Confirmed" class="<?= $statusFilter === 'Confirmed' ? 'active' : '' ?>">Confirmed</a>
        <a href="manage_booking.php?status=Cancelled" class="<?= $statusFilter === 'Canceled' ? 'active' : '' ?>">Cancelled</a>
      </div>

      <!-- Booking Table -->
      <table class="booking-table">
        <thead>
          <tr>
            <th>No</th>
            <th>Customer</th>
            <th>Contact</th>
            <th>People</th>
            <th>Date</th>
            <th>Time</th>
            <th>Table</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php $counter = 1; foreach ($bookings as $booking): ?>
            <tr>
              <td><?= $counter++ ?></td>
              <td><?= htmlspecialchars($booking['customer_name']) ?></td>
              <td><?= htmlspecialchars($booking['phone_number'] ?? '-') ?></td>
              <td><?= htmlspecialchars($booking['guests'] ?? '-') ?></td>
              <td><?= htmlspecialchars($booking['booking_date']) ?></td>
              <td><?= htmlspecialchars($booking['booking_time']) ?></td>
             <td>
              <form method="POST" action="../Controller/bookingController.php" style="display:inline;">
                <input type="hidden" name="action" value="updateTable">
                <input type="hidden" name="booking_id" value="<?= $booking['id'] ?>">
                <select name="table" onchange="this.form.submit()" class="status-dropdown">
                    <option value="">--</option>
                    <?php for ($i = 1; $i <= 4; $i++): ?>
                        <option value="<?= $i ?>" <?= $booking['table_number'] == $i ? 'selected' : '' ?>><?= $i ?></option>
                    <?php endfor; ?>
                </select>
              </form>
            </td>
              <td>

            <form method="POST" action="../Controller/bookingController.php" style="display: inline;">
            <input type="hidden" name="booking_id" value="<?= $booking['id'] ?>">
            <input type="hidden" name="action" value="updateStatus">
           <select name="status" onchange="updateDropdownColor(this); this.form.submit()" class="status-dropdown <?= strtolower($booking['status']) ?>">
            <option value="Confirmed" <?= $booking['status'] == 'Confirmed' ? 'selected' : '' ?>>Confirmed</option>
            <option value="Cancelled" <?= $booking['status'] == 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
        </select>
              </form>
              </td>
              <td>
                <a href="#" class="edit-booking-link"
                        data-id="<?= $booking['id'] ?>" 
                        data-name="<?= htmlspecialchars($booking['customer_name']) ?>" 
                        data-phone="<?= htmlspecialchars($booking['phone_number']) ?>" 
                        data-date="<?= $booking['booking_date'] ?>" 
                        data-time="<?= $booking['booking_time'] ?>" 
                        data-guests="<?= $booking['guests'] ?>" 
                        data-table="<?= $booking['table_number'] ?>">
                        Edit
                      </a>
                          |
              <a href="../Controller/bookingController.php?id=<?= $booking['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                                </td>
                              </tr>
                            <?php endforeach; ?>
                          </tbody>
                        </table>
                      </main>
                       </div>
                        <div class="modal" id="editModal">
                        <div class="modal-content">
                        <span class="close-button">&times;</span>
                        <h2>Edit Booking</h2>
                        <form method="POST" action="../Controller/bookingController.php">
                          <input type="hidden" name="action" value="editBooking">
                          <input type="hidden" name="booking_id" id="edit-booking-id">

                          <label>Name:</label>
                          <input type="text" name="name" id="edit-name" required>

                          <label>Phone:</label>
                          <input type="text" name="phone" id="edit-phone" required>

                          <label>Date:</label>
                          <input type="date" name="date" id="edit-date" required>

                          <label>Time:</label>
                          <input type="time" name="time" id="edit-time" required>

                          <label>Guests:</label>
                          <input type="number" name="guests" id="edit-guests" required>

                          <label>Table:</label>
                          <select name="table" id="edit-table" required>
                            <option value="">--</option>
                            <?php for ($i = 1; $i <= 4; $i++): ?>
                              <option value="<?= $i ?>"><?= $i ?></option>
                            <?php endfor; ?>
                          </select>
                          <button type="submit" class="submit-btn">Update Booking</button>
                        </form>
                      </div>
                    </div>
                
                  
<script src="/TKCafe/public/js/booking.js"></script>
 

</body>
</html>
