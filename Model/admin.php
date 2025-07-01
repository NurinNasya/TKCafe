<?php
require_once 'db.php'; // shared connection function

function adminLogin($username, $password) {
    $conn = getConnection();
    $stmt = $conn->prepare("SELECT password FROM admins WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($hashedPassword);
        $stmt->fetch();
        return password_verify($password, $hashedPassword);
    }

    $stmt->close();
    $conn->close();
    return false;
}
