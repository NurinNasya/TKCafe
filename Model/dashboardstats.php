<?php
class DashboardStats {
    private $conn;

    public function __construct($dbConn) {
        $this->conn = $dbConn;
    }

    public function getTotalSales() {
        // Use the correct column name: 'total'
        $stmt = $this->conn->query("SELECT SUM(total) AS total_sales FROM orders");
        $row = $stmt->fetch_assoc();
        return $row['total_sales'] ?? 0;
    }

    public function getTotalOrders() {
        $stmt = $this->conn->query("SELECT COUNT(*) AS total_orders FROM orders");
        $row = $stmt->fetch_assoc();
        return $row['total_orders'] ?? 0;
    }

    // public function getTodaysOrders() {
    //     $stmt = $this->conn->query("SELECT COUNT(*) AS today_orders FROM orders WHERE DATE(created_at) = CURDATE()");
    //     $row = $stmt->fetch_assoc();
    //     return $row['today_orders'] ?? 0;
    // }
    public function getTodaysOrders() {
    $stmt = $this->conn->query("SELECT COUNT(*) AS today_orders FROM `orders` WHERE DATE(created_at) = CURDATE()");
    $row = $stmt->fetch_assoc();
    return $row['today_orders'] ?? 0;
}

    public function getSalesLast7Days() {
        $sql = "SELECT DATE(created_at) as sale_date, SUM(total) as total_sales
                FROM orders
                WHERE created_at >= CURDATE() - INTERVAL 6 DAY
                GROUP BY sale_date
                ORDER BY sale_date";
        $result = $this->conn->query($sql);

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
}


}
