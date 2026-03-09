<?php

session_start();
include "config.php";

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE email='$email'";
$result = mysqli_query(mysql: $conn,query: $sql);

if(mysqli_num_rows(result: $result) == 1){

    $user = mysqli_fetch_assoc(result: $result);

    if(password_verify(password: $password, hash: $user['password'])){

        $_SESSION['username'] = $user['username'];
        header(header: "Location: index.php");
        exit();

    }else{

        header(header: "Location: login.php?error=wrongpassword");
        exit();

    }

}else{

    header(header: "Location: login.php?error=usernotfound");
    exit();

}

?>