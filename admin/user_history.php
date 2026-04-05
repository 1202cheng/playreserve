<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

require_once('config.php');

if (!isset($_GET['id'])) {
    header("Location: manage_user.php");
    exit();
}

$user_id = intval($_GET['id']);

// user
$userSql = "SELECT id, username, phone, email FROM users WHERE id = $user_id";
$userResult = mysqli_query($conn, $userSql);
$user = mysqli_fetch_assoc($userResult);

if (!$user) {
    echo "User not found.";
    exit();
}

// user booking history
$sql = "SELECT 
            bookings.booking_id,
            bookings.booking_date,
            bookings.start_time,
            bookings.end_time,
            bookings.status,
            bookings.payment_status,
            courts.court_name,
            courts.location,
            courts.price_per_hour
        FROM bookings
        JOIN courts ON bookings.court_id = courts.court_id
        WHERE bookings.user_id = $user_id
        ORDER BY bookings.booking_date DESC, bookings.start_time DESC";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User History</title>

<style>
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
}

body {
    background: #f2f2f2;
    padding: 20px 16px 40px;
}

.page-wrapper {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
}

.top-header {
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    margin-bottom: 18px;
}

.back-btn {
    position: absolute;
    left: 0;
    top: 50%;
    transform: translateY(-50%);
    text-decoration: none;
    color: #111;
    font-size: 30px;
}

.page-title {
    font-size: 24px;
    font-weight: bold;
    color: #111;
}

.user-info {
    background: #dce8f3;
    border-radius: 16px;
    padding: 16px 20px;
    margin-bottom: 16px;
    line-height: 1.8;
    color: #222;
}

.table-header {
    width: 100%;
    background: #74a7d1;
    display: grid;
    grid-template-columns: 90px 1.2fr 1.2fr 1fr 1fr 1fr 1fr;
    align-items: center;
    padding: 10px 14px;
    font-size: 14px;
    color: #111;
    margin-bottom: 12px;
}

.history-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.history-row {
    width: 100%;
    min-height: 52px;
    border: 1.5px solid #666;
    border-radius: 16px;
    background: #f9f9f9;
    display: grid;
    grid-template-columns: 90px 1.2fr 1.2fr 1fr 1fr 1fr 1fr;
    align-items: center;
    padding: 8px 14px;
}

.cell {
    font-size: 14px;
    color: #222;
    word-break: break-word;
}

.no-data {
    text-align: center;
    padding: 20px;
    color: #555;
}

@media (max-width: 700px) {
    .table-header {
        display: none;
    }

    .history-row {
        grid-template-columns: 1fr;
        gap: 8px;
    }

    .page-title {
        font-size: 22px;
    }
}
</style>
</head>

<body>

<div class="page-wrapper">

    <div class="top-header">
        <a href="manage_user.php" class="back-btn">&#8592;</a>
        <div class="page-title">USER HISTORY</div>
    </div>

    <div class="user-info">
        <div><strong>Name:</strong> <?php echo htmlspecialchars($user['username']); ?></div>
        <div><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone']); ?></div>
        <div><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></div>
    </div>

    <div class="table-header">
        <div>ID</div>
        <div>Court</div>
        <div>Location</div>
        <div>Date</div>
        <div>Start</div>
        <div>End</div>
        <div>Status</div>
    </div>

    <div class="history-list">

        <?php if (mysqli_num_rows($result) > 0) { ?>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <div class="history-row">
                    <div class="cell"><?php echo $row['booking_id']; ?></div>
                    <div class="cell"><?php echo htmlspecialchars($row['court_name']); ?></div>
                    <div class="cell"><?php echo htmlspecialchars($row['location']); ?></div>
                    <div class="cell"><?php echo htmlspecialchars($row['booking_date']); ?></div>
                    <div class="cell"><?php echo htmlspecialchars($row['start_time']); ?></div>
                    <div class="cell"><?php echo htmlspecialchars($row['end_time']); ?></div>
                    <div class="cell"><?php echo htmlspecialchars($row['status']); ?></div>
                </div>
            <?php } ?>
        <?php } else { ?>
            <div class="no-data">No booking history found for this user</div>
        <?php } ?>

    </div>

</div>

</body>
</html>