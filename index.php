<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>

<title>PlayReserve</title>

<script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-[#0f4c81] min-h-screen flex flex-col">

<!-- Navbar -->
<div class="flex justify-between items-center px-8 py-4 text-white">

<div class="text-xl font-semibold">
PlayReserve
</div>

<div class="flex items-center space-x-6">

<a href="#" class="hover:underline">Booking</a>

<a href="signup.php" class="hover:underline">Sign Up</a>

<?php if(isset($_SESSION['username'])): ?>


<a href="logout.php" class="hover:underline">Log Out</a>
<div class="bg-green-400 text-black px-4 py-1 rounded-full">
<?php echo $_SESSION['username']; ?>
</div>
<?php else: ?>

<a href="login.php" class="bg-green-400 text-black px-4 py-1 rounded-full">
Log In
</a>

<?php endif; ?>

</div>

</div>

<!-- Search Bar -->
<div class="flex justify-center mt-6">

<input
type="text"
placeholder="Search"
class="w-[600px] p-3 rounded-full outline-none shadow">

</div>

<!-- Sport Tabs -->
<div class="flex space-x-3 mt-6 px-10">

<button class="bg-gray-300 px-4 py-2 rounded">
Pickleball
</button>

<button class="bg-blue-500 text-white px-4 py-2 rounded">
Badminton
</button>

</div>

<!-- Court Cards -->
<div class="grid grid-cols-3 gap-6 px-10 mt-6">

<!-- Card 1 -->
<div class="bg-white rounded shadow overflow-hidden">

<img src="images/court1.jpg" class="h-40 w-full object-cover">

<div class="p-3">

<p class="font-semibold">AA Pickle Club</p>
<p class="text-sm text-gray-500">Johor Jaya, Johor</p>

</div>

</div>

<!-- Card 2 -->
<div class="bg-white rounded shadow overflow-hidden">

<img src="images/court2.jpg" class="h-40 w-full object-cover">

<div class="p-3">

<p class="font-semibold">BB Pickle Club</p>
<p class="text-sm text-gray-500">Bukit Jalil, Kuala Lumpur</p>

</div>

</div>

<!-- Card 3 -->
<div class="bg-white rounded shadow overflow-hidden">

<img src="images/court3.jpg" class="h-40 w-full object-cover">

<div class="p-3">

<p class="font-semibold">Apex Pickle Square</p>
<p class="text-sm text-gray-500">Ampang, Selangor</p>

</div>

</div>

</div>

<!-- Footer -->
<div class="bg-[#0a3b63] text-white mt-auto py-4 flex justify-center space-x-10">

<p>📞 +6017-8939188</p>

<p>✉ playerserve918@gmail.com</p>

</div>

</body>
</html>