<?php

session_start();
include "config.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$venue_id = $_POST['venue_id'];
$court_no = $_POST['court_no'];
$booking_date = $_POST['booking_date'];
$start_time = $_POST['start_time'];
$duration = $_POST['duration'];
$total_price = $_POST['total_price'];

/* =========================
   FORMAT TIME
========================= */

$start_time = date("H:i:s", strtotime($start_time));

$start = new DateTime($start_time);
$start->modify("+$duration hour");
$end_time = $start->format("H:i:s");


/* =========================
   CHECK COURT STATUS
========================= */

$status_check = mysqli_query($conn,"
SELECT status FROM venue_courts
WHERE venue_id='$venue_id'
AND court_no='$court_no'
");

if(!$status_check){
    die("SQL Error: " . mysqli_error($conn));
}

$row = mysqli_fetch_assoc($status_check);

if($row['status'] == 'error'){
    echo "<script>
    alert('This court is under maintenance!');
    window.history.back();
    </script>";
    exit();
}


/* =========================
   CHECK TIME SLOT (ANTI DOUBLE BOOK)
========================= */

for($i = 0; $i < $duration; $i++){

    $check_time = date("H:i:s", strtotime("+$i hour", strtotime($start_time)));

    $check_sql = "SELECT * FROM bookings
    WHERE venue_id='$venue_id'
    AND court_no='$court_no'
    AND booking_date='$booking_date'
    AND start_time <= '$check_time'
    AND end_time > '$check_time'
    ";

    $result = mysqli_query($conn, $check_sql);

    if(!$result){
        die("SQL Error: " . mysqli_error($conn));
    }

    if(mysqli_num_rows($result) > 0){
        echo "<script>
        alert('This time slot is already booked!');
        window.history.back();
        </script>";
        exit();
    }
}


/* =========================
   UPLOAD RECEIPT
========================= */

$receipt_name = $_FILES['receipt']['name'];
$tmp = $_FILES['receipt']['tmp_name'];

$allowed = ['jpg','jpeg','png'];
$ext = strtolower(pathinfo($receipt_name, PATHINFO_EXTENSION));

if(!in_array($ext,$allowed)){
    echo "<script>
    alert('Only JPG, JPEG or PNG allowed');
    window.history.back();
    </script>";
    exit();
}

$new_receipt_name = time() . "_" . $receipt_name;

move_uploaded_file($tmp, "receipts/" . $new_receipt_name);


/* =========================
   INSERT BOOKING
========================= */

$insert = mysqli_query($conn,"
INSERT INTO bookings
(user_id, venue_id, court_no, booking_date, start_time, end_time, total_price, receipt, status)
VALUES
('$user_id','$venue_id','$court_no','$booking_date','$start_time','$end_time','$total_price','$new_receipt_name','Pending')
");

if(!$insert){
    die("Insert Error: " . mysqli_error($conn));
}


/* =========================
   SUCCESS
========================= */

header("Location: profile.php");
exit();

?>