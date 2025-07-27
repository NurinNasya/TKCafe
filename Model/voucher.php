<?php
require_once __DIR__ . '/../db.php';

function getAllVouchers() {
    $conn = getConnection();
    $sql = "SELECT * FROM vouchers ORDER BY id DESC";
    $result = mysqli_query($conn, $sql);
    $vouchers = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $vouchers[] = $row;
    }
    mysqli_close($conn);
    return $vouchers;
}

function getVoucherByCode($code) {
    $conn = getConnection();
    $code = mysqli_real_escape_string($conn, $code);
    $sql = "SELECT * FROM vouchers WHERE code = '$code' AND valid_until >= CURDATE()";
    $result = mysqli_query($conn, $sql);
    $voucher = mysqli_fetch_assoc($result);
    mysqli_close($conn);
    return $voucher;
}

function addVoucher($code, $description, $amount, $minSpend, $validUntil) {
    $conn = getConnection();
    $code = strtoupper(mysqli_real_escape_string($conn, $code));
    $description = mysqli_real_escape_string($conn, $description);
    $amount = floatval($amount);
    $minSpend = floatval($minSpend);
    $validUntil = mysqli_real_escape_string($conn, $validUntil);

    $sql = "INSERT INTO vouchers (code, description, discount_amount, min_spend, valid_until)
            VALUES ('$code', '$description', $amount, $minSpend, '$validUntil')";
    
    $success = mysqli_query($conn, $sql);
    mysqli_close($conn);
    return $success;
}

function deleteVoucher($id) {
    $conn = getConnection();
    $id = intval($id);
    $sql = "DELETE FROM vouchers WHERE id = $id";
    $success = mysqli_query($conn, $sql);
    mysqli_close($conn);
    return $success;
}

// ✅ Get a single voucher by its ID (used in edit_voucher.php)
function getVoucherById($id) {
    $conn = getConnection();
    $id = intval($id);
    $sql = "SELECT * FROM vouchers WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    $voucher = mysqli_fetch_assoc($result);
    mysqli_close($conn);
    return $voucher;
}

// ✅ Update an existing voucher (used in voucherController.php)
function updateVoucher($id, $code, $description, $amount, $minSpend, $validUntil) {
    $conn = getConnection();
    $id = intval($id);
    $code = strtoupper(mysqli_real_escape_string($conn, $code));
    $description = mysqli_real_escape_string($conn, $description);
    $amount = floatval($amount);
    $minSpend = floatval($minSpend);
    $validUntil = mysqli_real_escape_string($conn, $validUntil);

    $sql = "UPDATE vouchers 
            SET code = '$code', description = '$description', discount_amount = $amount, min_spend = $minSpend, valid_until = '$validUntil'
            WHERE id = $id";

    $success = mysqli_query($conn, $sql);
    mysqli_close($conn);
    return $success;
}


// voucher.php (Model)
function getVouchersByPage($limit, $offset) {
    $conn = getConnection();
    $stmt = $conn->prepare("SELECT * FROM vouchers LIMIT ? OFFSET ?");
    $stmt->bind_param("ii", $limit, $offset);
    $stmt->execute();
    $result = $stmt->get_result();
    $vouchers = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $vouchers;
}

function countVouchers() {
    $conn = getConnection();
    $result = $conn->query("SELECT COUNT(*) as total FROM vouchers");
    $row = $result->fetch_assoc();
    return $row['total'];
}
