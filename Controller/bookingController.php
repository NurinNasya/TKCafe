<?php
require_once '../Model/booking.php'; 
session_start(); 

// Handle ADD BOOKING
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'addBooking') {
    $data = [
        'name'   => $_POST['name'],
        'phone'  => $_POST['phone'],
        'date'   => $_POST['date'],
        'time'   => $_POST['time'],
        'guests' => $_POST['guests'],
        'table'  => $_POST['table']
    ];

       // ✅ Check table conflict
    if (!empty($data['table']) && checkTableConflict($data['table'], $data['date'], $data['time'])) {
    $_SESSION['booking_error'] = "Table already booked for this date/time!";
        header("Location: ../Views/booking_form.php?error=Table+already+booked");
        exit;
    }

   if (addBooking($data)) {
    header("Location: ../Views/booking_form.php?success=1");
    exit;
} else {
    header("Location: ../Views/booking_form.php?error=1");
    exit;
}

}

// Handle STATUS UPDATE
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'updateStatus') {
    $id = $_POST['booking_id'];
    $newStatus = $_POST['status'];

    updateBookingStatus($id, $newStatus);
    header("Location: ../Views/manage_booking.php");
    exit;
}

// Handle TABLE NUMBER UPDATE
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'updateTable') {
    $id = $_POST['booking_id'];
    $newTable = $_POST['table'];

          // Get the booking date/time of this booking
    $currentBooking = getBookingById($id); // you may need to write this function in your Model
    $date = $currentBooking['booking_date'];
    $time = $currentBooking['booking_time'];

      // ✅ Check conflict excluding current booking
    if (!empty($newTable) && checkTableConflict($newTable, $date, $time, $id)) {
        $_SESSION['booking_error'] = "Table already booked for this date/time!";
        header("Location: ../Views/manage_booking.php");
        exit;
    }
    updateBookingTable($id, $newTable);
    header("Location: ../Views/manage_booking.php");
    exit;
}

// handle Edit function 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'editBooking') {
    $id = $_POST['booking_id'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $guests = $_POST['guests'];
    $table = $_POST['table'];

        // ✅ Check table conflict before updating
    if (!empty($table) && checkTableConflict($table, $date, $time, $id)) {
        $_SESSION['booking_error'] = "Table already booked for this date/time!";
        header("Location: ../Views/manage_booking.php");
        exit;
    }
    // Call update function (example)
    updateBooking($id, $name, $phone, $date, $time, $guests, $table);

    header('Location: ../Views/manage_booking.php');
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'updateBooking') {
        $bookingId = $_POST['booking_id'];
        $data = [
            'name' => $_POST['name'],
            'phone' => $_POST['phone'],
            'date' => $_POST['date'],
            'time' => $_POST['time'],
            'guests' => $_POST['guests'],
            'table' => $_POST['table'],
            'status' => $_POST['status'],
        ];

        // updateBooking($bookingId, $data);  // <- Function in your Model
        updateBooking(
            $bookingId, 
            $data['name'], 
            $data['phone'], 
            $data['date'], 
            $data['time'], 
            $data['guests'], 
            $data['table']
        );
        header('Location: ../Views/manage_booking.php?success=updated');
        exit;
    }
}

// handle deleted function //
if (isset($_GET['id'])) {
    $bookingId = $_GET['id'];

    if (deleteBooking($bookingId)) {
        header("Location: ../Views/manage_booking.php?success=Booking+deleted");
        exit;
    } else {
        header("Location: ../Views/manage_booking.php?error=Failed+to+delete");
        exit;
    }
} else {
    header("Location: ../Views/manage_booking.php?error=Invalid+booking+ID");
    exit;
}

