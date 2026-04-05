<?php

include "config.php";

$email = $_POST['email'];
$password = $_POST['password'];
$confirm = $_POST['confirm_password'];

/* Check password match */
if ($password != $confirm) {

header("Location: reset_password.php?error=passwordnotmatch&email=$email");
exit();

}

/* Get current password */
$sql = "SELECT password FROM users WHERE email='$email'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

$oldPasswordHash = $user['password'];

/* Check if same as old password */
if (password_verify($password, $oldPasswordHash)) {

header("Location: reset_password.php?error=samepassword&email=$email");
exit();

}

/* Hash new password */
$hash = password_hash($password, PASSWORD_DEFAULT);

/* Update password */
$sql = "UPDATE users SET password='$hash' WHERE email='$email'";

if (mysqli_query($conn, $sql)) {

header("Location: login.php?success=passwordupdated");
exit();

} else {

echo "Error updating password";

}

?>