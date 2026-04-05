<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}
require_once('config.php');

// Available Court（available）
$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM venue_courts WHERE status = 'available'");
$row = mysqli_fetch_assoc($result);
$totalCourts = $row['total'];

// Total Bookings
$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM bookings");
$row = mysqli_fetch_assoc($result);
$totalBookings = $row['total'];

// Total Users
$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM users");
$row = mysqli_fetch_assoc($result);
$totalUsers = $row['total'];

// Today's Bookings
$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM bookings WHERE booking_date = CURDATE()");
$row = mysqli_fetch_assoc($result);
$todayBookings = $row['total'];

// Latest Bookings
$sql = "SELECT 
            bookings.booking_id,
            bookings.booking_date,
            bookings.status,
            users.username,
            CONCAT(venues.venue_name, ' - Court ', bookings.court_no) AS court_name
        FROM bookings
        JOIN users ON bookings.user_id = users.id
        JOIN venues ON bookings.venue_id = venues.venue_id
        ORDER BY bookings.booking_date DESC
        LIMIT 5";

$latestBookings = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            background: #eeeeee;
        }

        .container {
            width: 100%;
            padding: 20px 40px;
        }

        .top-bar {
            width: 100%;
            height: 70px;
            background: #005ea8;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
            border-radius: 8px;
        }

        .logo {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            overflow: hidden;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .logout {
            background: #66ff00;
            padding: 10px 18px;
            border-radius: 8px;
            text-decoration: none;
            color: white;
            font-weight: bold;
            font-size: 16px;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-top: 30px;
        }

        .card {
            background: #dce8f3;
            padding: 22px;
            border-radius: 10px;
            text-align: center;
        }

        .card-title {
            font-size: 14px;
            color: #222;
        }

        .card-value {
            font-size: 32px;
            font-weight: bold;
            margin-top: 10px;
            color: #111;
        }

        .buttons {
            display: flex;
            gap: 20px;
            margin-top: 30px;
        }

        .btn {
            background: #005ea8;
            color: white;
            padding: 15px 25px;
            border-radius: 10px;
            text-decoration: none;
            text-align: center;
            flex: 1;
            font-size: 18px;
            font-weight: normal;
        }

        .table {
            margin-top: 30px;
            width: 100%;
        }

        .table-header,
        .row {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            padding: 12px 14px;
            align-items: center;
        }

        .table-header {
            background: #6fa7d4;
            font-weight: bold;
            border-radius: 6px;
            color: #111;
        }

        .row {
            background: white;
            border-radius: 10px;
            margin-top: 10px;
            border: 1px solid #ccc;
            color: #222;
        }

        .action a {
            margin-right: 10px;
            text-decoration: none;
            color: #333;
            font-size: 18px;
        }

        .no-data {
            text-align: center;
            margin-top: 16px;
            color: #555;
            font-size: 16px;
        }

        @media (max-width: 900px) {
            .stats {
                grid-template-columns: repeat(2, 1fr);
            }

            .buttons {
                flex-direction: column;
            }
        }

        @media (max-width: 700px) {
            .container {
                padding: 20px;
            }

            .table-header,
            .row {
                grid-template-columns: 1fr;
                gap: 8px;
            }
        }
    </style>
</head>
<body>

<div class="container">

    <div class="top-bar">
        <div class="logo">
            <img src="logo.png" alt="">
        </div>

        <a href="admin_logout.php" class="logout">Log Out</a>
    </div>

    <div class="stats">
        <div class="card">
            <div class="card-title">Available Court</div>
            <div class="card-value"><?php echo $totalCourts; ?></div>
        </div>

        <div class="card">
            <div class="card-title">Total Bookings</div>
            <div class="card-value"><?php echo $totalBookings; ?></div>
        </div>

        <div class="card">
            <div class="card-title">Total Users</div>
            <div class="card-value"><?php echo $totalUsers; ?></div>
        </div>

        <div class="card">
            <div class="card-title">Today's Bookings</div>
            <div class="card-value"><?php echo $todayBookings; ?></div>
        </div>
    </div>

    <div class="buttons">
        <a href="manage_court.php" class="btn">Manage Court</a>
        <a href="manage_booking.php" class="btn">Manage Booking</a>
        <a href="manage_user.php" class="btn">Manage User</a>
    </div>

    <div class="table">
        <div class="table-header">
            <div>Booking ID</div>
            <div>User</div>
            <div>Court</div>
            <div>Date</div>
            <div>Status</div>
            <div>Action</div>
        </div>

        <?php if (mysqli_num_rows($latestBookings) > 0) { ?>
            <?php while ($row = mysqli_fetch_assoc($latestBookings)) { ?>
                <div class="row">
                    <div><?php echo $row['booking_id']; ?></div>
                    <div><?php echo htmlspecialchars($row['username']); ?></div>
                    <div><?php echo htmlspecialchars($row['court_name']); ?></div>
                    <div><?php echo htmlspecialchars($row['booking_date']); ?></div>
                    <div><?php echo htmlspecialchars($row['status']); ?></div>
                    <div class="action">
                        <a href="edit_booking.php?id=<?php echo $row['booking_id']; ?>">✏</a>
                        <a href="delete_booking.php?id=<?php echo $row['booking_id']; ?>" onclick="return confirm('Are you sure you want to delete this booking?');">🗑</a>
                    </div>
                </div>
            <?php } ?>
        <?php } else { ?>
            <div class="no-data">No bookings found</div>
        <?php } ?>
    </div>

</div>

</body>
</html>