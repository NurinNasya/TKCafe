<?php

function getConnection() {
    return new mysqli("localhost", "root", "", "tkcafe"); // Change DB name
}


function getAllTables() {
    $conn = getConnection();
    $sql = "SELECT * FROM tables ORDER BY id ASC";
    $result = $conn->query($sql);
    $tables = [];

    while ($row = $result->fetch_assoc()) {
        $tables[] = $row;
    }

    $conn->close();
    return $tables;
}

function addTable($name, $seats, $status) {
    $conn = getConnection();
    $stmt = $conn->prepare("INSERT INTO tables (table_name, seats, status) VALUES (?, ?, ?)");
    $stmt->bind_param("sis", $name, $seats, $status);
    $success = $stmt->execute();
    $stmt->close();
    $conn->close();
    return $success;
}


function getTableById($id) {
    $conn = getConnection();
    $stmt = $conn->prepare("SELECT * FROM tables WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $table = $result->fetch_assoc();
    $stmt->close();
    $conn->close();
    return $table;
}

function updateTable($id, $name, $seats, $status) {
    $conn = getConnection();
    $stmt = $conn->prepare("UPDATE tables SET table_name = ?, seats = ?, status = ? WHERE id = ?");
    $stmt->bind_param("sisi", $name, $seats, $status, $id);
    $success = $stmt->execute();
    $stmt->close();
    $conn->close();
    return $success;
}

function deleteTable($id) {
    $conn = getConnection();
    $stmt = $conn->prepare("DELETE FROM tables WHERE id = ?");
    $stmt->bind_param("i", $id);
    $success = $stmt->execute();
    $stmt->close();
    $conn->close();
    return $success;
}
