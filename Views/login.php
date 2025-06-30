<?php 
// Your PHP logic here (if needed)
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Restaurant QR System</title>
    <link rel="stylesheet" href="/TKCafe/public/css/admin.css" />
</head>
<body>
    <div class="login-container">
        <h1>Admin Login</h1>
        
        <?php if (isset($error)): ?>
            <div class="error-message"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST" action="/admin/login" class="login-form">
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter admin username" required>
            </div>
            
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter password" required>
            </div>
            
            <button type="submit" class="login-btn">Login</button>
        </form>
        
        <div class="login-footer">
            <p>Forgot password? <a href="/admin/forgot-password">Reset here</a></p>
        </div>
    </div>
</body>
</html>