<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book a Table</title>
   <link rel="stylesheet" href="/TKCafe/public/css/booking.css">
</head>
<body>
     <div class="background-wrapper">
    <div class="form-container">
        <h2>Reserve Your Table</h2>
       <form method="post" action="/TKCafe/Controller/bookingController.php" class="booking-form">
        <input type="hidden" name="action" value="addBooking">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" placeholder="Enter your full name" required>
            </div>

            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="text"  maxlength="11" id="phone" name="phone" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                 placeholder="e.g., 012-3456789" required>
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

            <button type="submit">Book Now</button>

                  `   </div>
                      <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
                  <div class="popup success-popup" id="successPopup">
                      <div class="popup-content">
                          <p> Your booking has been received! Please wait for confirmation. Our admin will contact you if the table is unavailable.</p>
                          <button onclick="document.getElementById('successPopup').style.display='none'">OK</button>
                      </div>
                  </div>
                  <?php endif; ?>`
        </form>
</body>
</html>
