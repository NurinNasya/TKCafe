<?php
require_once 'db.php'; // Make sure getConnection() is defined there

function adminLogin($username, $password) {
    $conn = getConnection();

    $username = mysqli_real_escape_string($conn, $username);

    $query = "SELECT password FROM admins WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        mysqli_close($conn);
        return password_verify($password, $row['password']);
    }

    mysqli_close($conn);
    return false;
}
