<?php

class Cart {
    private $conn;

    public function __construct($db) {
        $this->conn = $db; // This is a mysqli connection
    }

    public function addItem($menu_id, $quantity, $price, $session_id) {
        $stmt = $this->conn->prepare("INSERT INTO order_item (menu_id, quantity, price, session_id) VALUES (?, ?, ?, ?)");
        if (!$stmt) return false;
        $stmt->bind_param("iids", $menu_id, $quantity, $price, $session_id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function getItems($session_id) {
        $stmt = $this->conn->prepare("SELECT * FROM order_item WHERE session_id = ?");
        if (!$stmt) return [];
        $stmt->bind_param("s", $session_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $items = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $items;
    }

    // add updateItem, deleteItem later if needed
}
