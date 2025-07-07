<?php

function getTotalSales($conn) {
    $result = mysqli_query($conn, "SELECT SUM(total) AS total_sales FROM orders");
    $row = mysqli_fetch_assoc($result);
    return $row['total_sales'] ?? 0;
}

function getTotalOrders($conn) {
    $result = mysqli_query($conn, "SELECT COUNT(*) AS total_orders FROM orders");
    $row = mysqli_fetch_assoc($result);
    return $row['total_orders'] ?? 0;
}

function getTodaysOrders($conn) {
    $result = mysqli_query($conn, "SELECT COUNT(*) AS today_orders FROM orders WHERE DATE(created_at) = CURDATE()");
    $row = mysqli_fetch_assoc($result);
    return $row['today_orders'] ?? 0;
}

function getSalesLast7Days($conn) {
    $sql = "SELECT DATE(created_at) as sale_date, SUM(total) as total_sales
            FROM orders
            WHERE created_at >= CURDATE() - INTERVAL 6 DAY
            GROUP BY sale_date
            ORDER BY sale_date";
    
    $result = mysqli_query($conn, $sql);
    $data = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    return $data;
}
