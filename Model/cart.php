<?php

function addItem($conn, $order_id, $menu_id, $quantity, $price, $customizations = null, $remarks = null) {
    $customizationsJson = $customizations ? json_encode($customizations) : null;
    $cleanedRemarks = $remarks ? trim($remarks) : null;

    $menu_id = intval($menu_id);
    $quantity = intval($quantity);
    $price = floatval($price);
    $order_id = intval($order_id); // <-- changed from session_id
    $customizationsJson = $customizationsJson ? "'" . mysqli_real_escape_string($conn, $customizationsJson) . "'" : "NULL";
    $cleanedRemarks = $cleanedRemarks ? "'" . mysqli_real_escape_string($conn, $cleanedRemarks) . "'" : "NULL";

    $query = "
        INSERT INTO order_item 
        (menu_id, quantity, price, order_id, customizations, remarks) 
        VALUES ($menu_id, $quantity, $price, $order_id, $customizationsJson, $cleanedRemarks)
    ";

    return mysqli_query($conn, $query);
}

function getItems($conn, $order_id) {
    $order_id = intval($order_id);
    $query = "
        SELECT * FROM order_item 
        WHERE order_id = $order_id
    ";
    $result = mysqli_query($conn, $query);

    $items = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $items[] = $row;
    }

    return $items;
}

function updateQuantity($conn, $id, $quantity, $order_id) {
    $id = intval($id);
    $quantity = intval($quantity);
    $order_id = intval($order_id);

    $query = "
        UPDATE order_item 
        SET quantity = $quantity 
        WHERE id = $id AND order_id = $order_id
    ";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn) > 0;
}

function removeItem($conn, $id, $order_id) {
    $id = intval($id);
    $order_id = intval($order_id);

    $query = "
        DELETE FROM order_item 
        WHERE id = $id AND order_id = $order_id
    ";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn) > 0;
}

function clearCart($conn, $order_id) {
    $order_id = intval($order_id);

    $query = "
        DELETE FROM order_item 
        WHERE order_id = $order_id
    ";

    return mysqli_query($conn, $query);
}
