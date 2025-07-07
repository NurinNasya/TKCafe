<?php
require_once __DIR__ . '/../db.php';

function getAllTables() {
    $conn = getConnection();
    $sql = "SELECT * FROM tables ORDER BY id ASC";
    $result = mysqli_query($conn, $sql);
    $tables = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $tables[] = $row;
    }

    mysqli_close($conn);
    return $tables;
}

function addTable($name, $seats, $status) {
    $conn = getConnection();
    
    $name = mysqli_real_escape_string($conn, $name);
    $seats = intval($seats);
    $status = mysqli_real_escape_string($conn, $status);

    $query = "INSERT INTO tables (table_name, seats, status) VALUES ('$name', $seats, '$status')";

    if (mysqli_query($conn, $query)) {
        $insertId = mysqli_insert_id($conn);
        mysqli_close($conn);
        return $insertId;
    } else {
        mysqli_close($conn);
        return false;
    }
}

function getTableById($id) {
    $conn = getConnection();
    $id = intval($id);
    $query = "SELECT * FROM tables WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $table = mysqli_fetch_assoc($result);
    mysqli_close($conn);
    return $table;
}

function updateTable($id, $name, $seats, $status) {
    $conn = getConnection();

    $id = intval($id);
    $name = mysqli_real_escape_string($conn, $name);
    $seats = intval($seats);
    $status = mysqli_real_escape_string($conn, $status);

    $query = "
        UPDATE tables 
        SET table_name = '$name', seats = $seats, status = '$status' 
        WHERE id = $id
    ";

    $success = mysqli_query($conn, $query);
    mysqli_close($conn);
    return $success;
}

function deleteTable($id) {
    $conn = getConnection();
    $id = intval($id);
    $query = "DELETE FROM tables WHERE id = $id";
    $success = mysqli_query($conn, $query);
    mysqli_close($conn);
    return $success;
}
