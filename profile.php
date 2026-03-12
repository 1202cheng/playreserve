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
    <title>My Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <!-- Header -->

    <div class="bg-blue-600 text-white p-4 flex justify-between">

        <a href="index.php">← Back</a>

        <a href="logout.php" class="bg-red-500 px-3 py-1 rounded">
            Logout
        </a>

    </div>


    <div class="max-w-3xl mx-auto mt-6 p-4">

        <!-- Profile Card -->

        <div class="bg-white p-4 rounded shadow mb-6">

            <h2 class="text-xl font-bold mb-3">
                My Profile
            </h2>

            <p><b>Username:</b> <?php echo $user['username']; ?></p>
            <p><b>Email:</b> <?php echo $user['email']; ?></p>
            <p><b>Phone:</b> <?php echo $user['phone']; ?></p>
            <p><b>Gender:</b> <?php echo $user['gender']; ?></p>

        </div>


        <!-- Booking History -->

        <div class="bg-white p-4 rounded shadow">

            <h2 class="text-xl font-bold mb-3">
                My Bookings
            </h2>

            <?php
            if (mysqli_num_rows($booking_result) == 0) {
                echo "<p>No bookings yet.</p>";
            }
            ?>

            <table class="w-full text-left">

                <tr class="border-b">
                    <th class="py-2">Court</th>
                    <th>Date</th>
                    <th>Start</th>
                    <th>End</th>
                    <th>Status</th>
                </tr>

                <?php
                while ($row = mysqli_fetch_assoc($booking_result)) {
                ?>

                    <tr class="border-b">

                        <td class="py-2">
                            <?php echo $row['court_name']; ?>
                        </td>

                        <td>
                            <?php echo $row['booking_date']; ?>
                        </td>

                        <td>
                            <?php echo $row['start_time']; ?>
                        </td>

                        <td>
                            <?php echo $row['end_time']; ?>
                        </td>

                        <td>
                            <?php echo $row['status']; ?>
                        </td>

                    </tr>

                <?php
                }
                ?>

            </table>

        </div>

    </div>

</body>

</html>