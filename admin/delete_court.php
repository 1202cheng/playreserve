<?php
include('../config.php');

$id = $_GET['id'];

$sql = "DELETE FROM courts WHERE court_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);

if (mysqli_stmt_execute($stmt)) {
    header("Location: manage_court.php");
} else {
    echo "Delete failed";
}
?>