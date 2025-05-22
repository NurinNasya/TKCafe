<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'cafe'; // Change this to your DB name

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
