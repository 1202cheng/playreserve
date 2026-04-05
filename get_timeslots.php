<?php
include "config.php";

$venue_id = $_GET['venue_id'];
$court_no = $_GET['court_no'];
$date = $_GET['date'];

$slots = mysqli_query($conn, "
SELECT * FROM court_timeslots
WHERE venue_id='$venue_id'
AND court_no='$court_no'
AND date='$date'
ORDER BY time ASC
");

echo "<div class='grid grid-cols-4 gap-2 mb-4'>";

while($s = mysqli_fetch_assoc($slots)){

$time = date("H:i", strtotime($s['time']));
$display = date("g A", strtotime($s['time']));
$status = $s['status'];

$class = "timeSlot border p-2 rounded";

if($status == 'booked'){
    $class .= " bg-red-400 text-white cursor-not-allowed";
}
elseif($status == 'blocked'){
    $class .= " bg-gray-400 text-white cursor-not-allowed";
}
else{
    $class .= " hover:bg-blue-500 hover:text-white";
}

echo "<button type='button'
class='$class'
".($status!='available'?'disabled':'')."
onclick=\"selectTime('$time',this)\">
$display
</button>";
}

echo "</div>";