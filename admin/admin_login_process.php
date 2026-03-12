<?php

session_start();
include "../config.php";

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM admins WHERE email='$email'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 1) {

    $admin = mysqli_fetch_assoc($result);

    if (password_verify($password, $admin['password'])) {

        $_SESSION['admin_id'] = $admin['id'];

        header("Location: admin_dashboard.php");
        exit();
    } else {

        echo "Wrong password";
    }
} else {

    echo "Admin not found";
}
