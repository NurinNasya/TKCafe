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
    $voucherCode = stripslashes($voucherCode);
    $voucherCode = str_replace(["'", '"'], '', $voucherCode);

    $response = ['success' => false];

       // ✅ GET ORDER_ID FROM SESSION INSTEAD OF SESSION_ID
    $order_id = $_SESSION['current_order']['id'] ?? null;
    
    if (!$order_id) {
        echo json_encode(['success' => false, 'error' => 'No active order']);
        exit;
    }


    $check = "SELECT * FROM vouchers WHERE code = '$voucherCode' AND valid_until >= CURDATE()";
    $result = mysqli_query($conn, $check);

    if ($row = mysqli_fetch_assoc($result)) {
         // ✅ USE ORDER_ID INSTEAD OF SESSION_ID
        $items = getItems($conn, $order_id);  // ✅ FIXED!
        $subtotal = 0;
        foreach ($items as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

                $serviceCharge = $subtotal * 0.10; // ✅ Define service charge
        $grandTotal = $subtotal + $serviceCharge;


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
                'discount' => round($discount, 2),
                'subtotal' => round($subtotal, 2),
                'service_charge' => round($serviceCharge, 2),
                'grand_total' => round($grandTotal, 2)
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
