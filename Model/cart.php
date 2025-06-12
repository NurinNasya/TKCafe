<?php

class Cart {
    private $conn;

    public function __construct($db) {
        $this->conn = $db; // This is a mysqli connection
    }

    public function addItem($menu_id, $quantity, $price, $session_id, $customizations = null) {
    $customizationsJson = $customizations ? json_encode($customizations) : null;
    $stmt = $this->conn->prepare("INSERT INTO order_item (menu_id, quantity, price, session_id, customizations) VALUES (?, ?, ?, ?, ?)");
    if (!$stmt) return false;
    $stmt->bind_param("iidss", $menu_id, $quantity, $price, $session_id, $customizationsJson);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
    }
    /*public function addItem($menu_id, $quantity, $price, $session_id) {
        $stmt = $this->conn->prepare("INSERT INTO order_item (menu_id, quantity, price, session_id) VALUES (?, ?, ?, ?)");
        if (!$stmt) return false;
        $stmt->bind_param("iids", $menu_id, $quantity, $price, $session_id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    } ori */

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
    
    public function updateQuantity($id, $quantity, $session_id) {
        $stmt = $this->conn->prepare("UPDATE order_item SET quantity = ? WHERE id = ? AND session_id = ?");
        if (!$stmt) return false;
        $stmt->bind_param("iis", $quantity, $id, $session_id);
        $result = $stmt->execute();
        
        // Check affected rows
        $affected = $stmt->affected_rows;
        $stmt->close();
        
        return $affected > 0;
    }

    public function removeItem($id, $session_id) {
        $stmt = $this->conn->prepare("DELETE FROM order_item WHERE id = ? AND session_id = ?");
        if (!$stmt) return false;
        $stmt->bind_param("is", $id, $session_id);
        $result = $stmt->execute();
        $affected = $stmt->affected_rows;
        $stmt->close();
        return $affected > 0;
    }
}
