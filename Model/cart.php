<?php

function addItem($conn, $menu_id, $quantity, $price, $session_id, $customizations = null, $remarks = null) {
    $customizationsJson = $customizations ? json_encode($customizations) : null;
    $cleanedRemarks = $remarks ? trim($remarks) : null;

    $menu_id = intval($menu_id);
    $quantity = intval($quantity);
    $price = floatval($price);
    $session_id = mysqli_real_escape_string($conn, $session_id);
    $customizationsJson = $customizationsJson ? "'" . mysqli_real_escape_string($conn, $customizationsJson) . "'" : "NULL";
    $cleanedRemarks = $cleanedRemarks ? "'" . mysqli_real_escape_string($conn, $cleanedRemarks) . "'" : "NULL";

    $query = "
        INSERT INTO order_item 
        (menu_id, quantity, price, session_id, customizations, remarks) 
        VALUES ($menu_id, $quantity, $price, '$session_id', $customizationsJson, $cleanedRemarks)
    ";

    return mysqli_query($conn, $query);
}

function getItems($conn, $session_id) {
    $session_id = mysqli_real_escape_string($conn, $session_id);
    $query = "
        SELECT * FROM order_item 
        WHERE session_id = '$session_id' AND order_id IS NULL
    ";
    $result = mysqli_query($conn, $query);

    $items = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $items[] = $row;
    }

    return $items;
}

function updateQuantity($conn, $id, $quantity, $session_id) {
    $id = intval($id);
    $quantity = intval($quantity);
    $session_id = mysqli_real_escape_string($conn, $session_id);

    $query = "
        UPDATE order_item 
        SET quantity = $quantity 
        WHERE id = $id AND session_id = '$session_id'
    ";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn) > 0;
}

function removeItem($conn, $id, $session_id) {
    $id = intval($id);
    $session_id = mysqli_real_escape_string($conn, $session_id);

    $query = "
        DELETE FROM order_item 
        WHERE id = $id AND session_id = '$session_id'
    ";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn) > 0;
}

function clearCart($conn, $session_id) {
    $session_id = mysqli_real_escape_string($conn, $session_id);

    $query = "
        DELETE FROM order_item 
        WHERE session_id = '$session_id' AND order_id IS NULL
    ";

    return mysqli_query($conn, $query);
}
