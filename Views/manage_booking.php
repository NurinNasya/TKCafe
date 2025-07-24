<?php
require_once '../Model/booking.php'; // Adjust path if needed
$statusFilter = isset($_GET['status']) ? $_GET['status'] : 'all';
$allBookings = getAllBookings($statusFilter);

/// Setup pagination
$itemsPerPage = 10;
$totalItems = count($allBookings);
$totalPages = ceil($totalItems / $itemsPerPage);

$currentPage = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$currentPage = min($totalPages, $currentPage);
$startIndex = ($currentPage - 1) * $itemsPerPage;

// Get bookings for this page
$bookings = array_slice($allBookings, $startIndex, $itemsPerPage);

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
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
        <!-- Add Booking Button -->
        <div style="text-align: right; margin-bottom: 15px;">
          <button id="openBookingFormBtn" class="btn btn-primary">+ Add Booking</button>
        </div>
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
         <?php $counter = $startIndex + 1; foreach ($bookings as $booking): ?>
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

           <form action="/TKCafe/Controller/bookingController.php" method="POST">
              <input type="hidden" name="action" value="addBooking">        
            <input type="hidden" name="booking_id" value="<?= $booking['id'] ?>">
            <input type="hidden" name="action" value="updateStatus">
           <select name="status" onchange="updateDropdownColor(this); this.form.submit()" class="status-dropdown <?= strtolower($booking['status']) ?>">
            <option value="Confirmed" <?= $booking['status'] == 'Confirmed' ? 'selected' : '' ?>>Confirmed</option>
            <option value="Cancelled" <?= $booking['status'] == 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
        </select>
              </form>
              </td>
              <td>
               <button type="button" 
                        class="btn edit-btn edit-booking-link"
                        data-id="<?= $booking['id'] ?>" 
                        data-name="<?= htmlspecialchars($booking['customer_name']) ?>" 
                        data-phone="<?= htmlspecialchars($booking['phone_number']) ?>" 
                        data-date="<?= $booking['booking_date'] ?>" 
                        data-time="<?= $booking['booking_time'] ?>" 
                        data-guests="<?= $booking['guests'] ?>" 
                        data-table="<?= $booking['table_number'] ?>">
                        Edit
                      </a>
                    </td>
                   </tr>
                  <?php endforeach; ?>
               </tbody>
           </table>

  <div class="pagination">
  <?php if ($currentPage > 1): ?>
    <a href="?status=<?= $statusFilter ?>&page=<?= $currentPage - 1 ?>" class="btn btn-sm">Prev</a>
  <?php endif; ?>

  <?php
  $maxDisplay = 5;
  $start = max(1, $currentPage - 2);
  $end = min($totalPages, $currentPage + 2);

  if ($start > 1) {
    echo '<a href="?status=' . $statusFilter . '&page=1" class="btn btn-sm">1</a>';
    if ($start > 2) echo '<span class="dots">...</span>';
  }

  for ($i = $start; $i <= $end; $i++) {
    $activeClass = ($i == $currentPage) ? 'btn-primary' : '';
    echo "<a href='?status=$statusFilter&page=$i' class='btn btn-sm $activeClass'>$i</a>";
  }

  if ($end < $totalPages) {
    if ($end < $totalPages - 1) echo '<span class="dots">...</span>';
    echo "<a href='?status=$statusFilter&page=$totalPages' class='btn btn-sm'>$totalPages</a>";
  }
  ?>

  <?php if ($currentPage < $totalPages): ?>
    <a href="?status=<?= $statusFilter ?>&page=<?= $currentPage + 1 ?>" class="btn btn-sm">Next</a>
  <?php endif; ?>
</div>

 <!-- Booking Form Modal -->
<div class="modal" id="bookingFormModal">
  <div class="modal-content">
    <span class="close-button" onclick="closeBookingForm()">&times;</span>
    <h2>Reserve a Table</h2>
    <form method="post" action="/TKCafe/Controller/bookingController.php" class="booking-form">
      <input type="hidden" name="action" value="addBooking">
      <div class="form-group">
        <label for="name">Full Name</label>
        <input type="text" id="name" name="name" placeholder="Enter your full name" required>
      </div>
      <div class="form-group">
        <label for="phone">Phone Number</label>
        <input type="text" id="phone" name="phone" placeholder="e.g., 012-3456789" required>
      </div>
      <div class="form-group">
        <label for="date">Booking Date</label>
        <input type="date" id="date" name="date" required>
      </div>
      <div class="form-group">
        <label for="time">Booking Time</label>
        <input type="time" id="time" name="time" required>
      </div>
      <div class="form-group">
        <label for="guests">Number of Guests</label>
        <input type="number" id="guests" name="guests" min="1" placeholder="e.g., 4" required>
      </div>
      <div class="form-group">
        <label for="table">Table Number (Optional)</label>
        <input type="text" id="table" name="table" placeholder="Leave blank for auto-assign">
      </div>
      <button type="submit" class="submit-btn">Book Now</button>
    </form>
  </div>
</div>

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
<script src="/TKCafe/public/js/booking.js"></script>
</body>
</html>
