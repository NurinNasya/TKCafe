<?php
ob_clean(); // Clear any accidental output
header('Content-Type: application/json');
session_start();
require_once '../Model/voucher.php';
require_once '../Model/cart.php';
require_once '../db.php';
$conn = getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $voucherCode = strtoupper(trim($_POST['voucher_code'] ?? ''));

    $response = ['success' => false];

    $check = "SELECT * FROM vouchers WHERE code = '$voucherCode' AND valid_until >= CURDATE()";
    $result = mysqli_query($conn, $check);

    if ($row = mysqli_fetch_assoc($result)) {
        // Get subtotal from session or force client to send it
        require_once '../Model/cart.php';
        $session_id = session_id();
        $items = getItems($conn, $session_id);
        $subtotal = 0;
        foreach ($items as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        if ($subtotal >= $row['min_spend']) {
            $discount = $row['discount_amount'];
            $grandTotal = ($subtotal * 1.10) - $discount;

            $_SESSION['voucher'] = [
                'code' => $voucherCode,
                'amount' => $discount
            ];

            $response = [
                'success' => true,
                'voucher_code' => $voucherCode,
                'discount' => $discount,
                'grand_total' => number_format($grandTotal, 2),
                'subtotal' => number_format($subtotal, 2),
                'service_charge' => number_format($subtotal * 0.10, 2)
            ];
        } else {
            $response['error'] = "Minimum spend: RM " . number_format($row['min_spend'], 2);
        }
    } else {
        $response['error'] = 'Invalid or expired voucher.';
    }

    echo json_encode($response);
    exit; // Ensure no extra output after JSON

}
