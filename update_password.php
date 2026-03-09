<?php

include "config.php";

$email = $_POST['email'];
$password = $_POST['password'];
$confirm = $_POST['confirm_password'];

if ($password != $confirm) {
    header("Location: reset_password.php?error=passwordnotmatch");
    exit();
}

$hash = password_hash($password, PASSWORD_DEFAULT);

$sql = "UPDATE users SET password='$hash' WHERE email='$email'";

if (mysqli_query($conn, $sql)) {

    header("Location: login.php?success=passwordupdated");
    exit();
} else {

    echo "Error updating password";
}
