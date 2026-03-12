<?php
session_start();
include "config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$court_id = $_GET['id'];

$sql = "SELECT * FROM courts WHERE court_id = $court_id";
$result = mysqli_query($conn, $sql);

$court = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Court Details</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <!-- Header -->

    <div class="bg-blue-600 text-white p-4">

        <a href="index.php">← Back</a>

    </div>


    <!-- Court Image -->

    <img
        src="images/<?php echo strtolower($court['sport_type']); ?>.jpg"
        class="w-full h-56 object-cover">


    <div class="p-4">

        <h2 class="text-xl font-bold">
            <?php echo $court['court_name']; ?>
        </h2>

        <p class="text-gray-500">
            <?php echo $court['location']; ?>
        </p>


        <!-- Announcement -->

        <div class="bg-blue-100 p-3 rounded mt-4">

            <b>Announcement</b>

            <p class="text-sm">
                Ramadan Promo: Enjoy 20% off starting 22nd February until 20th March
            </p>

        </div>


        <!-- Venue Information -->

        <div class="mt-4">

            <h3 class="font-semibold mb-2">Venue Information</h3>

            <div class="bg-gray-200 p-3 rounded flex justify-between">
                Opening Hours & Pricing
                <span>></span>
            </div>

            <div class="bg-gray-200 p-3 rounded flex justify-between mt-2">
                Venue Layout
                <span>></span>
            </div>

        </div>


        <!-- Location -->

        <div class="mt-4">

            <h3 class="font-semibold mb-2">Location</h3>

            <img src="images/map.jpg" class="rounded">

            <div class="flex gap-4 mt-2 text-sm">

                <a href="https://waze.com" target="_blank">
                    📍 Open in Waze
                </a>

                <a href="https://maps.google.com" target="_blank">
                    📍 Open in Google Maps
                </a>

            </div>

        </div>


        <!-- Book Button -->

        <a href="booking.php?court_id=<?php echo $court['court_id']; ?>">

            <button class="w-full bg-blue-600 text-white py-3 rounded mt-6">

                Book Now

            </button>

        </a>

    </div>


    <!-- Footer -->

    <div class="bg-blue-600 text-white text-center p-4 mt-10">

        📞 +6017-893 9188
        &nbsp;&nbsp;&nbsp;&nbsp;
        ✉ playreserve9188@gmail.com

    </div>

</body>

</html>