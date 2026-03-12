<?php

session_start();
include "config.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$court_id = $_POST['court_id'];
$court_number = $_POST['court_number'];
$booking_date = $_POST['booking_date'];
$start_time = $_POST['start_time'];
$duration = $_POST['duration'];
$total_price = $_POST['total_price'];


/* Calculate End Time */

$start = new DateTime($start_time);
$start->modify("+$duration hour");
$end_time = $start->format("H:i");


/* Check if time slot already booked */

$check_sql = "SELECT * FROM bookings
WHERE court_id='$court_id'
AND court_number='$court_number'
AND booking_date='$booking_date'
AND (
(start_time < '$end_time' AND end_time > '$start_time')
)";

$check_result = mysqli_query($conn,$check_sql);

if(mysqli_num_rows($check_result) > 0){

    echo "<script>
    alert('This court is already booked during this time.');
    window.history.back();
    </script>";

    exit();
}


/* Upload Receipt */

$receipt_name = $_FILES['receipt']['name'];
$tmp = $_FILES['receipt']['tmp_name'];

/* File validation */

$allowed = ['jpg','jpeg','png'];

$ext = strtolower(pathinfo($receipt_name, PATHINFO_EXTENSION));

if(!in_array($ext,$allowed)){
    echo "<script>
    alert('Only JPG, JPEG or PNG files are allowed.');
    window.history.back();
    </script>";
    exit();
}

$new_receipt_name = time() . "_" . $receipt_name;

move_uploaded_file($tmp, "receipts/" . $new_receipt_name);


/* Insert Booking */

$sql = "INSERT INTO bookings
(user_id,court_id,court_number,booking_date,start_time,end_time,total_price,receipt,status,payment_status)

VALUES
('$user_id','$court_id','$court_number','$booking_date','$start_time','$end_time','$total_price','$new_receipt_name','Pending','Uploaded')";

mysqli_query($conn,$sql);


/* Redirect */

header("Location: profile.php");
exit();

?>