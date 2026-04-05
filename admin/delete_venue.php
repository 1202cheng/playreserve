<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

include('../config.php');

if (!isset($_GET['id'])) {
    die("Venue ID not found.");
}

$id = intval($_GET['id']);

$sql = "DELETE FROM venues WHERE venue_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);

if (mysqli_stmt_execute($stmt)) {
    header("Location: manage_court.php?success=venue_deleted");
    exit();
} else {
    die("Delete failed: " . mysqli_error($conn));
}
?>