<?php

include "config.php";

$email = $_POST['email'];

$sql = "SELECT * FROM users WHERE email='$email'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {

    header("Location: reset_password.php?email=$email");
} else {

    echo "Email not found";
}
