<?php
include "config.php";

$venue_id = $_GET['venue_id'];
$court_no = $_GET['court_no'];
$date = $_GET['date'];

$sql = "SELECT start_time, end_time FROM bookings
WHERE venue_id='$venue_id'
AND court_no='$court_no'
AND booking_date='$date'";

$result = mysqli_query($conn, $sql);

$booked = [];

while($row = mysqli_fetch_assoc($result)){
    $start = strtotime($row['start_time']);
    $end = strtotime($row['end_time']);

    for($t = $start; $t < $end; $t += 3600){
        $booked[] = date("H:i", $t);
    }
}

echo json_encode($booked);