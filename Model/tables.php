<?php
require_once __DIR__ . '/../db.php';

function getAllTables($search = '') {
    $conn = getConnection();
    
    if (!empty($search)) {
        $stmt = $conn->prepare("SELECT * FROM tables WHERE table_name LIKE ? ORDER BY id ASC");
        $searchTerm = '%' . $search . '%';
        $stmt->bind_param("s", $searchTerm);
    } else {
        $stmt = $conn->prepare("SELECT * FROM tables ORDER BY id ASC");
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $tables = [];
    while ($row = $result->fetch_assoc()) {
        $tables[] = $row;
    }

    $stmt->close();
    $conn->close();
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
