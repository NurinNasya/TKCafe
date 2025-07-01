<?php

require_once '../Model/tables.php';

if (isset($_POST['add_table'])) {
    $tableName = $_POST['table_name'];
    $seats = $_POST['seats'];
    $status = $_POST['status'];

    $result = addTable($tableName, $seats, $status);

    if ($result) {
        header("Location: ../Views/manage_tables.php?success=1");
        exit;
    } else {
        header("Location: ../Views/manage_tables.php?error=1");
        exit;
    }
}

// Add below existing addTable logic
if (isset($_POST['update_table'])) {
    $id = $_POST['id'];
    $tableName = $_POST['table_name'];
    $seats = $_POST['seats'];
    $status = $_POST['status'];

    $result = updateTable($id, $tableName, $seats, $status);

    if ($result) {
        header("Location: ../Views/manage_tables.php?updated=1");
        exit;
    } else {
        header("Location: ../Views/manage_tables.php?error=1");
        exit;
    }
}

if (isset($_POST['delete_table'])) {
    $tableId = $_POST['delete_table_id'];

    $result = deleteTable($tableId);

    if ($result) {
        header("Location: ../Views/manage_tables.php?deleted=1");
        exit;
    } else {
        header("Location: ../Views/manage_tables.php?error=1");
        exit;
    }
}
