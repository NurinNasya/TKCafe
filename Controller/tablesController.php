<?php

require_once '../Model/tables.php';
require_once '../Libraries/phpqrcode/qrlib.php';

if (isset($_POST['add_table'])) {
    $tableName = $_POST['table_name'];
    $seats = $_POST['seats'];
    $status = $_POST['status'];

     $table_id = addTable($tableName, $seats, $status); // now returns ID

    if ($table_id) {

      $tableFileName = strtolower(str_replace(' ', '_', $tableName)); // table_1
        // ✅ Generate QR Code
        $qrDir = '../public/QR/';
        if (!file_exists($qrDir)) {
            mkdir($qrDir, 0777, true);
        }

        $fileName = $qrDir . 'table_' . $table_id . '.png';
        $tableUrl = "http://192.168.1.103/TKCafe/Views/dinein-takeaway.php?table_id=" . $table_id;



        QRcode::png($tableUrl, $fileName, QR_ECLEVEL_L, 5);

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
