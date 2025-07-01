<?php
//require_once '../Model/register.php';
require_once '../Model/admin.php';
session_start();

// REGISTER
// if (isset($_POST['register'])) {
//     $username = trim($_POST['username']);
//     $password = $_POST['password'];
//     $confirm = $_POST['confirm_password'];

//     if ($password !== $confirm) {
//         header("Location: /TKCafe/Views/register.php?error=password_mismatch");
//         exit;
//     }

//     if (registerAdmin($username, $password)) {
//         header("Location: /TKCafe/views/login.php");
//         exit;
//     } else {
//         header("Location: /TKCafe/Views/register.php?error=1");
//         exit;

//     }
// }

// LOGIN
if (isset($_POST['username'], $_POST['password']) && !isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (adminLogin($username, $password)) {
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
