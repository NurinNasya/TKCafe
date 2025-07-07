<?php
//require_once '../Model/register.php';
//require_once '../Model/admin.php';
session_start();

// LOGIN with hardcoded values
if (isset($_POST['username'], $_POST['password']) && !isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Hardcoded credentials
    $validUsername = 'admin';
    $validPassword = 'tkcafe123';

    if ($username === $validUsername && $password === $validPassword) {
        $_SESSION['admin'] = $username;
        header("Location: /TKCafe/views/dashboard.php");
        exit;
    } else {
        $error = "Invalid username or password.";
        include '../views/login.php';
        exit;
    }
}

// LOGOUT
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    header("Location: /TKCafe/views/login.php");
    exit;
}
