<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Your Cart</title>
  <link rel="stylesheet" href="/TKCafe/public/css/style.css" />
  <link rel="stylesheet" href="/TKCafe/public/css/cart.css" />
</head>
<body>

<div class="cart-container">
  <h2>Your Cart</h2>
  <div id="cart-items">Loading...</div>
  <p class="total" id="cart-total"></p>
</div>

<script src="/TKCafe/public/js/cart.js"></script>
</body>
</html>