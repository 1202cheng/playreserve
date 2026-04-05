<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: manage_court.php?success=court_deleted");
    exit();
}

include('../config.php');

if (!isset($_GET['id'])) {
    die("Court ID not found.");
}

$id = intval($_GET['id']);

$sql = "DELETE FROM venue_courts WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);

if (mysqli_stmt_execute($stmt)) {
    header("Location: manage_court.php");
    exit();
} else {
    die("Delete failed: " . mysqli_error($conn));
}
?>