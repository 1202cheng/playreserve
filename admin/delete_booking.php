<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

require_once('config.php');

if (isset($_GET['id'])) {
    $booking_id = intval($_GET['id']);

    $sql = "DELETE FROM bookings WHERE booking_id = $booking_id";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location: manage_booking.php?deleted=1");
        exit();
    } else {
        echo "Delete failed: " . mysqli_error($conn);
    }
} else {
    header("Location: manage_booking.php?success=booking_deleted");
    exit();
}
?>