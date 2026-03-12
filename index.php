<?php
session_start();
include "config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$sql = "SELECT * FROM courts WHERE availability = 1";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>PlayReserve</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <!-- Header -->

    <div class="bg-blue-600 p-4 flex justify-between text-white">

        <h1 class="font-bold text-lg">PlayReserve</h1>

        <div>

            <?php if (isset($_SESSION['username'])) { ?>

                <a href="profile.php"
                    class="bg-white text-blue-600 px-3 py-1 rounded font-semibold">

                    <?php echo $_SESSION['username']; ?>

                </a>

                <a href="logout.php"
                    class="ml-3 bg-red-500 px-3 py-1 rounded">

                    Logout

                </a>
                    <a href="admin/admin_login.php"
                        class="bg-black px-3 py-1 rounded text-white ml-3">
                        Admin
</a>

            <?php } else { ?>

                <a href="signup.php" class="mr-4">Sign Up</a>
                <a href="login.php" class="bg-green-500 px-3 py-1 rounded">Log In</a>

            <?php } ?>

        </div>

    </div>


    <!-- Banner -->

    <div class="h-40 bg-cover bg-center"
        style="background-image:url('images/banner.jpg')">
    </div>


    <div class="p-6">

        <!-- Search -->

        <div class="flex mb-4">

            <input
                type="text"
                id="search"
                placeholder="Search court..."
                class="w-full p-3 rounded-l border outline-none">

            <button
                onclick="searchCourt()"
                class="bg-gray-200 px-4 rounded-r">

                🔍

            </button>

        </div>


        <!-- Filter -->

        <div class="flex gap-3 mb-6">

            <button onclick="filterSport('pickleball')"
                class="bg-green-400 text-white px-4 py-2 rounded">
                Pickleball
            </button>

            <button onclick="filterSport('badminton')"
                class="bg-blue-500 text-white px-4 py-2 rounded">
                Badminton
            </button>

            <button onclick="filterSport('all')"
                class="bg-gray-400 text-white px-4 py-2 rounded">
                All
            </button>

        </div>


        <!-- Courts -->

        <div id="courts" class="grid grid-cols-2 gap-4">

            <?php
            while ($court = mysqli_fetch_assoc($result)) {

                $sport = strtolower($court['sport_type']);
            ?>

                <a href="court_details.php?id=<?php echo $court['court_id']; ?>">

                    <div class="court <?php echo $sport; ?> bg-white rounded shadow hover:shadow-lg">

                        <img
                            src="images/<?php echo $sport; ?>.jpg"
                            class="w-full h-32 object-cover rounded-t">

                        <div class="p-2">

                            <p class="font-semibold">
                                <?php echo $court['court_name']; ?>
                            </p>

                            <p class="text-sm text-gray-500">
                                <?php echo $court['location']; ?>
                            </p>

                            <p class="text-green-600 font-semibold">
                                RM <?php echo $court['price_per_hour']; ?>/hour
                            </p>

                        </div>

                    </div>

                </a>

            <?php } ?>

        </div>

    </div>


    <!-- Footer -->

    <div class="bg-blue-600 text-white text-center p-4 mt-10">

        📞 +6017-893 9188
        &nbsp;&nbsp;&nbsp;&nbsp;
        ✉ playreserve9188@gmail.com

    </div>


    <script>
        function searchCourt() {

            let input = document.getElementById("search").value.toLowerCase();

            let courts = document.querySelectorAll(".court");

            courts.forEach(court => {

                let name = court.innerText.toLowerCase();

                if (name.includes(input)) {
                    court.style.display = "block";
                } else {
                    court.style.display = "none";
                }

            });

        }


        function filterSport(type) {

            let courts = document.querySelectorAll(".court");

            courts.forEach(court => {

                if (type === "all") {
                    court.style.display = "block";
                } else if (court.classList.contains(type)) {
                    court.style.display = "block";
                } else {
                    court.style.display = "none";
                }

            });

        }
    </script>

</body>

</html>