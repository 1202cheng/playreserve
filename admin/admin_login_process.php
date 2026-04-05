<?php

session_start();
include "../config.php";

$email = $_POST['email'];
$password = $_POST['password'];

// Optional: prevent SQL injection
$email = mysqli_real_escape_string($conn, $email);

$sql = "SELECT * FROM admins WHERE email='$email'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 1) {

    $admin = mysqli_fetch_assoc($result);

    if (password_verify($password, $admin['password'])) {

        $_SESSION['admin_id'] = $admin['id'];

        header("Location: admin_dashboard.php");
        exit();

    } else {

        // ❌ Wrong password
        header("Location: admin_login.php?error=wrongpassword");
        exit();
    }

} else {

    // ❌ Email not found
    header("Location: admin_login.php?error=notfound");
    exit();
}
?>