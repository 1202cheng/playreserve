<?php
session_start();
include "config.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

if(!isset($_GET['venue_id'])){
    die("Invalid access");
}

$venue_id = $_GET['venue_id'];

// Get venue
$venue = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT * FROM venues WHERE venue_id='$venue_id'")
);

// Get courts
$courts = mysqli_query($conn, "
    SELECT * FROM venue_courts 
    WHERE venue_id='$venue_id'
");
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
<?= $venue['venue_name']; ?>
</h2>

<p class="text-gray-500 mb-6">
RM <span id="price"><?= $venue['price_per_hour']; ?></span> / hour
</p>

<form action="booking_process.php" method="POST" enctype="multipart/form-data">

<input type="hidden" name="venue_id" value="<?= $venue_id ?>">
<input type="hidden" id="total_price" name="total_price">
<input type="hidden" id="selected_time" name="start_time">

<!-- Date -->
<label class="font-semibold">Select Date</label>
<input type="date" name="booking_date"
class="w-full border p-2 rounded mb-4" required>

<!-- Time -->
<label class="font-semibold">Select Time Slot</label>

<div class="grid grid-cols-4 gap-2 mb-4">

<?php
for($i=8;$i<=23;$i++){
    $time = sprintf("%02d:00",$i);
    $display = ($i<=12)?$i:$i-12;
    $ampm = ($i<12)?"AM":"PM";

    echo "<button type='button'
    class='timeSlot border p-2 rounded hover:bg-blue-500 hover:text-white'
    onclick=\"selectTime('$time',this)\"
    data-time='$time'>
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

<!-- Court -->
<label class="font-semibold">Select Court</label>

<select name="court_no" class="w-full border p-2 rounded mb-4">

<?php while($c = mysqli_fetch_assoc($courts)) { ?>

<option value="<?= $c['court_no'] ?>"
<?= ($c['status'] == 'error') ? 'disabled' : '' ?>>

Court <?= $c['court_no'] ?> (<?= $c['status'] ?>)

</option>

<?php } ?>

</select>

<!-- Price -->
<div class="bg-gray-100 p-3 rounded mb-4">
<b>Total Price:</b>
RM <span id="total">0</span>
</div>

<!-- Receipt -->
<label class="font-semibold">Upload Payment Receipt</label>

<input type="file"
name="receipt"
class="w-full border p-2 rounded mb-4"
onchange="enableCheckout()" required>

<button
id="checkoutBtn"
disabled
class="w-full bg-gray-400 text-white py-2 rounded">

Checkout

</button>

</form>

</div>

<script>

function selectTime(time,btn){

document.querySelectorAll(".timeSlot").forEach(b=>{
b.classList.remove("bg-blue-600","text-white");
});

btn.classList.add("bg-blue-600","text-white");

document.getElementById("selected_time").value = time;

updateCourts(); // 🔥 ADD THIS
}

function calculatePrice(){
    let price = <?= $venue['price_per_hour']; ?>;
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

/* 🔥 LOAD BOOKED TIME */
function loadBookedSlots(){

let date = document.querySelector('[name="booking_date"]').value;
let court = document.querySelector('[name="court_no"]').value;
let venue = <?= $venue_id ?>;

if(!date || !court) return;

fetch(`get_booked_slots.php?venue_id=${venue}&court_no=${court}&date=${date}`)
.then(res => res.json())
.then(data => {

    document.querySelectorAll(".timeSlot").forEach(btn => {

        let time = btn.getAttribute("data-time");

        if(data.includes(time)){
            btn.disabled = true;
            btn.classList.add("bg-red-400","text-white");
        } else {
            btn.disabled = false;
            btn.classList.remove("bg-red-400","text-white");
        }

    });

});

}

document.querySelector('[name="booking_date"]').addEventListener("change", updateCourts);
document.querySelector('[name="court_no"]').addEventListener("change", loadBookedSlots);

function updateCourts(){

let date = document.querySelector('[name="booking_date"]').value;
let time = document.getElementById("selected_time").value;
let venue = <?= $venue_id ?>;

if(!date || !time) return;

fetch(`get_available_courts.php?venue_id=${venue}&date=${date}&time=${time}`)
.then(res => res.json())
.then(data => {

    let select = document.querySelector('[name="court_no"]');

    select.innerHTML = "";

    if(data.length == 0){
        select.innerHTML = "<option>No courts available</option>";
        return;
    }

    data.forEach(court => {
        select.innerHTML += `<option value="${court}">
            Court ${court} (available)
        </option>`;
    });

});

}

</script>

</body>
</html>