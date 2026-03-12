<?php
session_start();
include "config.php";

if(!isset($_SESSION['user_id'])){
header("Location: login.php");
exit();
}

$court_id = $_GET['court_id'];

$sql = "SELECT * FROM courts WHERE court_id='$court_id'";
$result = mysqli_query($conn,$sql);
$court = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
<title>Book Court</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<div class="max-w-lg mx-auto bg-white p-6 mt-8 rounded shadow">

<h2 class="text-xl font-bold mb-2">
<?php echo $court['court_name']; ?>
</h2>

<p class="text-gray-500 mb-6">
RM <span id="price"><?php echo $court['price_per_hour']; ?></span> / hour
</p>

<form action="booking_process.php" method="POST" enctype="multipart/form-data">

<input type="hidden" name="court_id" value="<?php echo $court_id; ?>">
<input type="hidden" id="total_price" name="total_price">
<input type="hidden" id="selected_time" name="start_time">

<!-- Date -->

<label class="font-semibold">Select Date</label>
<input type="date" name="booking_date"
class="w-full border p-2 rounded mb-4" required>

<!-- Time Slot -->

<label class="font-semibold">Select Time Slot</label>

<div class="grid grid-cols-4 gap-2 mb-4">

<?php

for($i=8;$i<=23;$i++){

$time = sprintf("%02d:00",$i);
$display = ($i<=12)?$i:$i-12;
$ampm = ($i<12)?"AM":"PM";

echo "<button type='button'
class='timeSlot border p-2 rounded hover:bg-blue-500 hover:text-white'
onclick=\"selectTime('$time',this)\">
$display $ampm
</button>";

}

for($i=0;$i<=2;$i++){

$time = sprintf("%02d:00",$i);
$display = ($i==0)?12:$i;
$ampm = "AM";

echo "<button type='button'
class='timeSlot border p-2 rounded hover:bg-blue-500 hover:text-white'
onclick=\"selectTime('$time',this)\">
$display $ampm
</button>";

}

?>

</div>


<!-- Duration -->

<label class="font-semibold">Select Duration</label>

<div class="flex gap-2 mb-4">

<label class="border px-4 py-2 rounded cursor-pointer">
<input type="radio" name="duration" value="1" onclick="calculatePrice()" required> 1h
</label>

<label class="border px-4 py-2 rounded cursor-pointer">
<input type="radio" name="duration" value="2" onclick="calculatePrice()"> 2h
</label>

<label class="border px-4 py-2 rounded cursor-pointer">
<input type="radio" name="duration" value="3" onclick="calculatePrice()"> 3h
</label>

</div>


<!-- Court Number -->

<label class="font-semibold">Select Court</label>

<select name="court_number"
class="w-full border p-2 rounded mb-4">

<option value="1">Court 1</option>
<option value="2">Court 2</option>
<option value="3">Court 3</option>

</select>


<!-- Price -->

<div class="bg-gray-100 p-3 rounded mb-4">

<b>Total Price:</b>

RM <span id="total">0</span>

</div>


<!-- Upload Receipt -->

<label class="font-semibold">Upload Payment Receipt</label>

<input type="file"
name="receipt"
id="receipt"
class="w-full border p-2 rounded mb-4"
onchange="enableCheckout()"
required>


<button
id="checkoutBtn"
disabled
class="w-full bg-gray-400 text-white py-2 rounded">

Checkout

</button>

</form>

</div>


<script>

let selectedStartTime = null;

function selectTime(time,btn){

document.querySelectorAll(".timeSlot").forEach(b=>b.classList.remove("bg-blue-600","text-white"));

btn.classList.add("bg-blue-600","text-white");

selectedStartTime = time;

document.getElementById("selected_time").value = time;

}

function calculatePrice(){

let price = <?php echo $court['price_per_hour']; ?>;

let duration = document.querySelector('input[name="duration"]:checked').value;

let total = price * duration;

document.getElementById("total").innerText = total;

document.getElementById("total_price").value = total;

}

function enableCheckout(){

document.getElementById("checkoutBtn").disabled = false;

document.getElementById("checkoutBtn").classList.remove("bg-gray-400");

document.getElementById("checkoutBtn").classList.add("bg-blue-600");

}

</script>

</body>
</html>