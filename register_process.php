<?php

include "config.php";

$email = $_POST['email'];
$password = $_POST['password'];
$confirm = $_POST['confirm_password'];
$username = $_POST['username'];
$dob = $_POST['dob'];
$phone = $_POST['phone'];
$gender = $_POST['gender'];

if ($password != $confirm) {
    echo "Password not match";
    exit();
}

$hash = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO users (email,password,username,dob,phone,gender)
VALUES ('$email','$hash','$username','$dob','$phone','$gender')";

if (mysqli_query($conn, $sql)) {
    header("Location: login.php");
} else {
    echo "Error";
}
