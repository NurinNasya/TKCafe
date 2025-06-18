<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose Your Experience</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/TKCafe/public/css/dinein-takeaway.css" />
</head>
<body>
    <div class="container">
        <div class="selection-wrapper">
            <div class="header">
                <h1>How would you like to enjoy your meal?</h1>
                <p>Select your preferred dining option to continue</p>
            </div>
            
            <form id="orderForm" action="process_order.php" method="post">
                <div class="options-grid">
                    <label class="option-card dine-in">
                        <input type="radio" name="order_type" value="dine-in">
                        <img src="https://images.unsplash.com/photo-1555396273-367ea4eb4db5?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Dine-In" class="option-bg">
                        <div class="option-overlay">
                            <div class="checkmark"><i class="fas fa-check"></i></div>
                            <div class="option-icon"><i class="fas fa-utensils"></i></div>
                            <h2 class="option-title">Dine-In</h2>
                            <p class="option-desc">Experience our restaurant ambiance</p>
                        </div>
                    </label>
                    
                    <label class="option-card takeaway">
                        <input type="radio" name="order_type" value="takeaway">
                        <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Takeaway" class="option-bg">
                        <div class="option-overlay">
                            <div class="checkmark"><i class="fas fa-check"></i></div>
                            <div class="option-icon"><i class="fas fa-shopping-bag"></i></div>
                            <h2 class="option-title">Takeaway</h2>
                            <p class="option-desc">Enjoy your meal wherever you like</p>
                        </div>
                    </label>
                </div>
                
              <div class="footer">
                    <a href="menu.php" class="continue-btn" id="continueBtn">
                        Continue to Menu <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script src="/TKCafe/public/js/dinein-takeaway.js"></script>
</body>
</html>