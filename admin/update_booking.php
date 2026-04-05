<?php
include "../config.php";

$id = $_GET['id'];
$status = $_GET['status'];

$conn->query("UPDATE bookings SET status='$status' WHERE booking_id=$id");

header("Location: admin_dashboard.php");
?>