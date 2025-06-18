<?php
require_once '../Model/menu.php';
class Order {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

   private function generateOrderNumber() {
    // Generate a 4-digit random number with leading zeros
    $randomNumber = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
    return '#' . $randomNumber; // Format: #0123, #9999, etc.
}

public function createInitialOrder($sessionId, $orderType) {
    // Generate unique order number
    do {
        $orderNumber = $this->generateOrderNumber();
        $stmt = $this->conn->prepare("SELECT id FROM orders WHERE order_number = ?");
        $stmt->bind_param("s", $orderNumber);
        $stmt->execute();
        $result = $stmt->get_result();
    } while ($result->num_rows > 0); // Keep trying if duplicate found
    
    // Create the order
    $stmt = $this->conn->prepare("
        INSERT INTO orders 
        (order_number, session_id, order_type, status) 
        VALUES (?, ?, ?, 'preparing')
    ");
    $stmt->bind_param("sss", $orderNumber, $sessionId, $orderType);
    
    if (!$stmt->execute()) {
        throw new Exception("Failed to create initial order: " . $stmt->error);
    }
    
    return $this->conn->insert_id;
}
    public function updateOrderType($sessionId, $orderType) {
        $stmt = $this->conn->prepare("
            UPDATE orders 
            SET order_type = ?, updated_at = CURRENT_TIMESTAMP 
            WHERE session_id = ? AND status = 'preparing'
            ORDER BY created_at DESC LIMIT 1
        ");
        $stmt->bind_param("ss", $orderType, $sessionId);
        
        if (!$stmt->execute()) {
            throw new Exception("Failed to update order type: " . $stmt->error);
        }
        
        return $stmt->affected_rows > 0;
    }

    public function getCurrentOrderBySession($sessionId) {
        $stmt = $this->conn->prepare("
            SELECT * FROM orders 
            WHERE session_id = ? 
            ORDER BY created_at DESC 
            LIMIT 1
        ");
        $stmt->bind_param("s", $sessionId);
        $stmt->execute();
        
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function createOrder($sessionId, $orderType, $total, $cartItems) {
        $this->conn->begin_transaction();
        
        try {
            // 1. Create the order header
            $orderNumber = $this->generateOrderNumber();
            $stmt = $this->conn->prepare("
                INSERT INTO orders 
                (order_number, session_id, order_type, total, status) 
                VALUES (?, ?, ?, ?, 'preparing')
            ");
            $stmt->bind_param("sssd", $orderNumber, $sessionId, $orderType, $total);
            
            if (!$stmt->execute()) {
                throw new Exception("Failed to create order: " . $stmt->error);
            }
            
            $orderId = $this->conn->insert_id;
            
            // 2. Save all cart items
            foreach ($cartItems as $item) {
                $this->addOrderItem($orderId, $item);
            }
            
            $this->conn->commit();
            return $orderId;
            
        } catch (Exception $e) {
            $this->conn->rollback();
            throw $e;
        }
    }

    private function addOrderItem($orderId, $item) {
        $stmt = $this->conn->prepare("
            INSERT INTO order_item 
            (order_id, menu_id, quantity, price, session_id, customizations) 
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        
        $customizations = isset($item['customizations']) ? 
            (is_string($item['customizations']) ? $item['customizations'] : json_encode($item['customizations'])) : 
            null;
        
        $stmt->bind_param(
            "iiidss", 
            $orderId,
            $item['menu_id'],
            $item['quantity'],
            $item['price'],
            $item['session_id'],
            $customizations
        );
        
        if (!$stmt->execute()) {
            throw new Exception("Failed to add order item: " . $stmt->error);
        }
    }

    public function getOrderDetails($orderId) {
        // Use prepared statement to prevent SQL injection
        $stmt = $this->conn->prepare("
            SELECT * FROM orders 
            WHERE id = ?
        ");
        $stmt->bind_param("i", $orderId);
        $stmt->execute();
        $order = $stmt->get_result()->fetch_assoc();

        if (!$order) {
            return null;
        }

        // Get items with prepared statement
        $stmt = $this->conn->prepare("
            SELECT * FROM order_item 
            WHERE order_id = ?
        ");
        $stmt->bind_param("i", $orderId);
        $stmt->execute();
        $items = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        $menu = new Menu();
        
        return [
            'order' => $order,
            'items' => array_map(function($item) use ($menu) {
                $menuItem = $menu->getItemById($item['menu_id']);
                return [
                    'name' => $menuItem['name'] ?? 'Item #'.$item['menu_id'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'customizations' => !empty($item['customizations']) 
                        ? (is_string($item['customizations']) 
                            ? json_decode($item['customizations'], true) 
                            : $item['customizations'])
                        : null
                ];
            }, $items)
        ];
    }

    public function clearCart($sessionId) {
        $stmt = $this->conn->prepare("
            DELETE FROM order_item 
            WHERE session_id = ?
        ");
        $stmt->bind_param("s", $sessionId);
        
        if (!$stmt->execute()) {
            throw new Exception("Failed to clear cart: " . $stmt->error);
        }
        
        return $stmt->affected_rows;
    }
}

    /*public function __construct($db) {
        $this->conn = $db;
    }

    private function generateOrderNumber() {
        return '#' . mt_rand(100, 9999);
    }

    public function createInitialOrder($sessionId, $orderType) {
    $orderNumber = '#' . mt_rand(100, 9999);
    
    $stmt = $this->conn->prepare("
        INSERT INTO orders 
        (order_number, session_id, order_type) 
        VALUES (?, ?, ?)
    ");
    $stmt->bind_param("sss", $orderNumber, $sessionId, $orderType);
    $stmt->execute();
    
    return $this->conn->insert_id;
}

    public function updateOrderType($sessionId, $orderType) {
        $stmt = $this->conn->prepare("
            UPDATE orders 
            SET order_type = ?, updated_at = CURRENT_TIMESTAMP 
            WHERE session_id = ? AND status = 'preparing'
            ORDER BY created_at DESC LIMIT 1
        ");
        $stmt->bind_param("ss", $orderType, $sessionId);
        return $stmt->execute();
    }

    public function getCurrentOrderBySession($sessionId) {
        $stmt = $this->conn->prepare("
            SELECT * FROM orders 
            WHERE session_id = ? 
            ORDER BY created_at DESC 
            LIMIT 1
        ");
        $stmt->bind_param("s", $sessionId);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

   public function createOrder($session_id, $order_type, $total, $cart_items) {
        $order_number = $this->generateOrderNumber();
        
        $this->conn->begin_transaction();
        
        try {
            // 1. Create the order header
            $stmt = $this->conn->prepare("
                INSERT INTO orders 
                (order_number, session_id, order_type, total) 
                VALUES (?, ?, ?, ?)
            ");
            $stmt->bind_param("sssd", $order_number, $session_id, $order_type, $total);
            $stmt->execute();
            $order_id = $this->conn->insert_id;
            
            // 2. Save all cart items
            foreach ($cart_items as $item) {
                $this->addOrderItem($order_id, $item);
            }
            
            $this->conn->commit();
            return $order_id;
            
        } catch (Exception $e) {
            $this->conn->rollback();
            throw $e; // Re-throw for error handling
        }
    }

       private function addOrderItem($order_id, $item) {
    // ONLY insert what's needed for the receipt:
    $stmt = $this->conn->prepare("
        INSERT INTO order_item 
        (order_id, menu_id, quantity, price, session_id, customizations) 
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("iiidss", 
        $order_id,
        $item['menu_id'],      // From cart
        $item['quantity'],     // From cart
        $item['price'],        // From cart (must be a number, e.g., 10.00)
        $item['session_id'],   // Must match session_id()
        $item['customizations'] ?? null
    );
    return $stmt->execute();
}
    public function getOrderDetails($order_id) {
        // Get order from database
        $order = $this->conn->query("
            SELECT * FROM orders WHERE id = $order_id
        ")->fetch_assoc();

        if (!$order) {
            return null;
        }

        // Get items from database
        $items = $this->conn->query("
            SELECT * FROM order_item 
            WHERE order_id = $order_id
        ")->fetch_all(MYSQLI_ASSOC);

        // Process items with Menu class
        $menu = new Menu();
        
        return [
            'order' => $order,
            'items' => array_map(function($item) use ($menu) {
                $menuItem = $menu->getItemById($item['menu_id']);
                return [
                    'name' => $menuItem['name'] ?? 'Item #'.$item['menu_id'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'customizations' => !empty($item['customizations']) 
                        ? json_decode($item['customizations'], true) 
                        : null
                ];
            }, $items)
        ];
    }
    public function clearCart($session_id) {
        $stmt = $this->conn->prepare("DELETE FROM order_item WHERE session_id = ?");
        $stmt->bind_param("s", $session_id);
        return $stmt->execute();
    }
}*/


?>