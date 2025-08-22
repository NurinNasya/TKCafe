<?php
require_once __DIR__ . '/../db.php'; 

function addBooking($data) {
    $conn = getConnection();
     // ✅ Time validation (allow only between 09:00 and 17:00)
    $bookingTime = $data['time'];
    if ($bookingTime < "09:00" || $bookingTime > "17:00") {
        return false; // reject booking
    }

    $status = 'Pending'; // default status
    $stmt = $conn->prepare("INSERT INTO bookings (customer_name, phone_number, booking_date, booking_time, guests, table_number, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $data['name'], $data['phone'], $data['date'], $data['time'], $data['guests'], $data['table'], $status);
    return $stmt->execute();
}

// ✅ NEW: Get a single booking by ID
function getBookingById($id) {
    $conn = getConnection();
    $stmt = $conn->prepare("SELECT * FROM bookings WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

// ✅ NEW: Check if a table is already booked at same date & time
function checkTableConflict($tableNumber, $date, $time, $excludeBookingId = null) {
    $conn = getConnection();
    
    if ($excludeBookingId) {
        $stmt = $conn->prepare("SELECT id FROM bookings 
                                WHERE table_number = ? AND booking_date = ? AND booking_time = ? 
                                AND id != ?");
        $stmt->bind_param("sssi", $tableNumber, $date, $time, $excludeBookingId);
    } else {
        $stmt = $conn->prepare("SELECT id FROM bookings 
                                WHERE table_number = ? AND booking_date = ? AND booking_time = ?");
        $stmt->bind_param("sss", $tableNumber, $date, $time);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0; // true if conflict exists
}


function updateBookingStatus($id, $status) {
    $conn = getConnection();
    $stmt = $conn->prepare("UPDATE bookings SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $id);
    return $stmt->execute();

}

function getAllBookings($status = null, $searchTerm = '', $filterDate = null) {
// function getAllBookings($status = null, $searchTerm = '') {
$conn = getConnection();
$query = "SELECT * FROM bookings WHERE 1=1";

$params = [];
$types = "";

// Filter by status if not "all"
if ($status && $status !== 'all') {
    $query .= " AND status = ?";
    $types .= "s";
    $params[] = $status;
}

// Filter by search term (name or phone)
if (!empty($searchTerm)) {
    $query .= " AND (customer_name LIKE ? OR phone_number LIKE ?)";
    $types .= "ss";
    $searchWildcard = '%' . $searchTerm . '%';
    $params[] = $searchWildcard;
    $params[] = $searchWildcard;
}

  // ✅ Filter by booking_date
    if (!empty($filterDate)) {
        $query .= " AND booking_date = ?";
        $types .= "s";
        $params[] = $filterDate;
    }

$query .= " ORDER BY booking_date DESC";

$stmt = $conn->prepare($query);

// Bind parameters dynamically if any
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

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
