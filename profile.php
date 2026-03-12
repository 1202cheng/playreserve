<?php
session_start();
include "config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$user_sql = "SELECT * FROM users WHERE id='$user_id'";
$user_result = mysqli_query($conn, $user_sql);
$user = mysqli_fetch_assoc($user_result);

$booking_sql = "SELECT bookings.*, courts.court_name
FROM bookings
JOIN courts ON bookings.court_id = courts.court_id
WHERE bookings.user_id = '$user_id'
ORDER BY booking_date DESC";

$booking_result = mysqli_query($conn, $booking_sql);
?>

<!DOCTYPE html>
<html>

<head>
<title>My Dashboard</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<!-- Header -->

<div class="bg-blue-600 text-white p-4 flex justify-between items-center">

<h1 class="font-bold text-lg">PlayReserve</h1>

<div class="flex gap-4">
<a href="index.php" class="bg-black px-3 py-1 rounded text-white">Home</a>
<a href="logout.php" class="bg-red-500 px-3 py-1 rounded">Logout</a>
</div>

</div>


<div class="max-w-5xl mx-auto mt-8">

<!-- Profile Card -->

<div class="bg-white rounded-lg shadow p-6 mb-6">

<h2 class="text-xl font-bold mb-4">
My Profile
</h2>

<div class="grid grid-cols-2 gap-4">

<div>
<p class="text-gray-500">Username</p>
<p class="font-semibold"><?php echo $user['username']; ?></p>
</div>

<div>
<p class="text-gray-500">Email</p>
<p class="font-semibold"><?php echo $user['email']; ?></p>
</div>

<div>
<p class="text-gray-500">Phone</p>
<p class="font-semibold"><?php echo $user['phone']; ?></p>
</div>

<div>
<p class="text-gray-500">Gender</p>
<p class="font-semibold"><?php echo $user['gender']; ?></p>
</div>

</div>

</div>


<!-- Booking Section -->

<div class="bg-white rounded-lg shadow p-6">

<h2 class="text-xl font-bold mb-4">
My Bookings
</h2>

<?php
if (mysqli_num_rows($booking_result) == 0) {
echo "<p class='text-gray-500'>No bookings yet.</p>";
}
?>

<div class="overflow-x-auto">

<table class="w-full">

<thead>

<tr class="border-b text-left text-gray-600">

<th class="py-3">Court</th>
<th>Date</th>
<th>Start</th>
<th>End</th>
<th>Price</th>
<th>Status</th>
<th>Receipt</th>

</tr>

</thead>

<tbody>

<?php
while ($row = mysqli_fetch_assoc($booking_result)) {

/* Status Color */

$statusColor = "bg-yellow-100 text-yellow-700";

if($row['payment_status'] == "Complete"){
$statusColor = "bg-green-100 text-green-700";
}

?>

<tr class="border-b hover:bg-gray-50">

<td class="py-3 font-medium">
<?php echo $row['court_name']; ?>
</td>

<td>
<?php echo $row['booking_date']; ?>
</td>

<td>
<?php echo substr($row['start_time'],0,5); ?>
</td>

<td>
<?php echo substr($row['end_time'],0,5); ?>
</td>

<td class="text-green-600 font-semibold">
RM <?php echo $row['total_price']; ?>
</td>

<td>

<!-- <span class="px-3 py-1 rounded-full text-sm <?php echo $statusColor; ?>"> -->

<?php echo $row['status']; ?>

<!-- </span> -->

</td>

<td>

<?php if($row['receipt']){ ?>

<a href="receipts/<?php echo $row['receipt']; ?>"
target="_blank"
class="bg-blue-500 text-white px-3 py-1 rounded text-sm">

View

</a>

<?php } else { ?>

<span class="text-gray-400 text-sm">
No receipt
</span>

<?php } ?>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>

</body>

</html>