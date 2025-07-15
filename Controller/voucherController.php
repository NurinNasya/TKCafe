<?php
require_once '../Model/voucher.php';

if (isset($_POST['add_voucher'])) {
    $code = $_POST['code'];
    $description = $_POST['description'];
    $discount = $_POST['discount'];
    $minSpend = $_POST['min_spend'];
    $validUntil = $_POST['valid_until'];

    $success = addVoucher($code, $description, $discount, $minSpend, $validUntil);
    header("Location: ../Views/manage_vouchers.php?" . ($success ? "success=1" : "error=1"));
    exit;
}

if (isset($_POST['delete_voucher'])) {
    $id = $_POST['voucher_id'];
    $success = deleteVoucher($id);
    header("Location: ../Views/manage_vouchers.php?" . ($success ? "deleted=1" : "error=1"));
    exit;
}


if (isset($_POST['update_voucher'])) {
    $id = $_POST['edit_id'];
    $code = $_POST['edit_code'];
    $description = $_POST['edit_description'];
    $discount = $_POST['edit_discount'];
    $minSpend = $_POST['edit_min_spend'];
    $validUntil = $_POST['edit_valid_until'];

    $success = updateVoucher($id, $code, $description, $discount, $minSpend, $validUntil);
    header("Location: ../Views/manage_vouchers.php?" . ($success ? "updated=1" : "error=1"));
    exit;
}
