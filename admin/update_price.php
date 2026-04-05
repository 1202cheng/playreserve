<?php
include "../config.php";

$id = $_POST['court_id'];
$price = $_POST['price'];

$conn->query("UPDATE courts SET price_per_hour=$price WHERE court_id=$id");

header("Location: manage_courts.php");
?>