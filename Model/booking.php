<?php
require_once __DIR__ . '/../db.php'; 

function addBooking($data) {
    $conn = getConnection();
    $status = 'Confirmed'; // default status
    $stmt = $conn->prepare("INSERT INTO bookings (customer_name, phone_number, booking_date, booking_time, guests, table_number, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $data['name'], $data['phone'], $data['date'], $data['time'], $data['guests'], $data['table'], $status);
    return $stmt->execute();
}


function updateBookingStatus($id, $status) {
    $conn = getConnection();
    $stmt = $conn->prepare("UPDATE bookings SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $id);
    return $stmt->execute();

}

function getAllBookings($status = null) {
    $conn = getConnection();
    if ($status && $status !== 'all') {
        $stmt = $conn->prepare("SELECT * FROM bookings WHERE status = ? ORDER BY booking_date DESC");
        $stmt->bind_param("s", $status);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    } else {
        $result = $conn->query("SELECT * FROM bookings ORDER BY booking_date DESC");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}

function updateBookingTable($id, $tableNumber) {
    $conn = getConnection();
    $stmt = $conn->prepare("UPDATE bookings SET table_number = ? WHERE id = ?");
    $stmt->bind_param("si", $tableNumber, $id);
    return $stmt->execute();
}

function editBooking($id, $data) {
    $conn = getConnection();
    $stmt = $conn->prepare("UPDATE bookings SET customer_name=?, phone_number=?, booking_date=?, booking_time=?, guests=?, table_number=? WHERE id=?");
    $stmt->bind_param("ssssssi", $data['name'], $data['phone'], $data['date'], $data['time'], $data['guests'], $data['table'], $id);
    return $stmt->execute();
}

function updateBooking($id, $name, $phone, $date, $time, $guests, $table) {
    $conn = getConnection();
    $stmt = $conn->prepare("UPDATE bookings SET customer_name=?, phone_number=?, booking_date=?, booking_time=?, guests=?, table_number=? WHERE id=?");
    $stmt->bind_param("ssssiii", $name, $phone, $date, $time, $guests, $table, $id);
    $stmt->execute();
    $stmt->close();
    $conn->close();
}

function deleteBooking($id) {
    $conn = getConnection();
    $stmt = $conn->prepare("DELETE FROM bookings WHERE id = ?");
    $stmt->bind_param("i", $id);
    $result = $stmt->execute();
    $stmt->close();
    $conn->close();
    return $result;
}



?>
