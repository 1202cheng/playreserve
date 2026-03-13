<?php
include "config.php";

$email = $_POST['email'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];
$username = $_POST['username'];
$dob_input = $_POST['dob'];
$phone = $_POST['phone'];
$gender = $_POST['gender'];

/* DOB CHECK */
if(empty($dob_input)){
    header("Location: signup.php?error=dob");
    exit();
}

$dob = $_POST['dob'];

/* PASSWORD MATCH */
if($password != $confirm_password){
    header("Location: signup.php?error=password");
    exit();
}

/* CHECK EMAIL */
$sql = "SELECT * FROM users WHERE email='$email'";
$result = mysqli_query($conn,$sql);

if(mysqli_num_rows($result) > 0){
    header("Location: signup.php?error=email");
    exit();
}

/* CHECK PHONE */
$sql = "SELECT * FROM users WHERE phone='$phone'";
$result = mysqli_query($conn,$sql);

if(mysqli_num_rows($result) > 0){
    header("Location: signup.php?error=phone");
    exit();
}

/* HASH PASSWORD */
$hashed_password = password_hash($password,PASSWORD_DEFAULT);

/* INSERT USER */
$sql = "INSERT INTO users (email,password,username,dob,phone,gender)
VALUES ('$email','$hashed_password','$username','$dob','$phone','$gender')";

if(mysqli_query($conn,$sql)){
    header("Location: login.php?success=register");
}else{
    header("Location: signup.php?error=register");
}

exit();
?>