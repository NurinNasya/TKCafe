<?php 
session_start();

// ✅ CLEAR ANY EXISTING ORDER DATA WHEN STARTING FRESH
unset($_SESSION['current_order']);
unset($_SESSION['current_order_id']);
unset($_SESSION['last_order']);
unset($_SESSION['voucher']);

// ✅ Get the table_id
$table_id = isset($_GET['table_id']) ? intval($_GET['table_id']) : null;

// ✅ Store table_id in session
if ($table_id) {
    $_SESSION['table_id'] = $table_id;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose Your Experience</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/TKCafe/public/css/dinein-takeaway.css">
     <link rel="stylesheet" href="/TKCafe/public/css/login.css">
</head>
<body>
    <body>
   <!-- 🔒 Login Button (top right corner) -->
<div style="position: absolute; top: 20px; right: 20px; z-index: 999;">
    <button id="openLoginModal" style="padding: 8px 16px; background-color:rgb(192, 142, 74); color: white; border: none; border-radius: 4px; cursor: pointer;">
        Login
    </button>
</div>

    <div class="container">
        <div class="selection-wrapper">
            <?php if (isset($_SESSION['dinein_takeaway_error'])): ?>
                <div class="alert alert-error">
                    <?= htmlspecialchars($_SESSION['dinein_takeaway_error']) ?>
                    <?php unset($_SESSION['dinein_takeaway_error']); ?>
                </div>
            <?php endif; ?>
            
            <div class="header">
                <h1>How would you like to enjoy your meal?</h1>
                <p>Select your preferred dining option to continue</p>
            </div>

       <!-- ✅ Include hidden field inside the form -->
           <form id="orderForm" action="/TKCafe/Controller/ordertypeController.php" method="post">
             <input type="hidden" name="table_id" value="<?= htmlspecialchars($table_id) ?>">
                <div class="options-grid">
                    <label class="option-card dine-in">
                        <input type="radio" name="order_type" value="dine-in" required>
                        <img src="https://images.unsplash.com/photo-1555396273-367ea4eb4db5?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Dine-In" class="option-bg">
                        <div class="option-overlay">
                            <div class="checkmark"><i class="fas fa-check"></i></div>
                            <div class="option-icon"><i class="fas fa-utensils"></i></div>
                            <h2 class="option-title">Dine-In</h2>
                            <p class="option-desc">Experience our restaurant ambiance</p>
                        </div>
                    </label>
                    
                    <label class="option-card takeaway">
                        <input type="radio" name="order_type" value="takeaway" required>
                        <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Takeaway" class="option-bg">
                        <div class="option-overlay">
                            <div class="checkmark"><i class="fas fa-check"></i></div>
                            <div class="option-icon"><i class="fas fa-shopping-bag"></i></div>
                            <h2 class="option-title">Takeaway</h2>
                            <p class="option-desc">Enjoy your meal wherever you like</p>
                        </div>
                    </label>
                </div>
                <!-- Hidden submit button for accessibility -->
                <button type="submit" style="display: none;"></button>
            </form>
        </div>
    </div>

                <!-- 🔒 Login Modal -->
            <div id="loginModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>

                <h2>Admin Login</h2>
                <form method="POST" action="/TKCafe/Controller/adminController.php">
                <div class="input-group">
                    <label>Username</label>
                    <input type="text" name="username" required>
                </div>
                <div class="input-group">
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>
                <button type="submit" class="login-btn">Login</button>
                </form>
            </div>
            </div>

     <script src="/TKCafe/public/js/login-admin.js"></script>
    <script src="/TKCafe/public/js/dinein-takeaway.js"></script>
</body>
</html>