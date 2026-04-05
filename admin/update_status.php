<?php
include "../config.php";

$id = $_GET['id'];
$status = $_GET['status'];

$conn->query("UPDATE courts SET status='$status' WHERE court_id=$id");

header("Location: manage_courts.php");
?>