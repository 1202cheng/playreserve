<?php

$host = "localhost";
$user = "root";
$pass = "";
$db = "playreserve";

$conn = mysqli_connect(hostname: $host, username: $user, password: $pass, database: $db);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
