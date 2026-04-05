<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

require_once('config.php');

// 抓 booking + user + court
$sql = "SELECT 
    bookings.booking_id,
    bookings.booking_date,
    bookings.start_time,
    bookings.end_time,
    bookings.total_price,

    users.username,
    users.email,

    venues.venue_name,
    venues.location,
    bookings.court_no

FROM bookings
JOIN users ON bookings.user_id = users.id
JOIN venues ON bookings.venue_id = venues.venue_id

ORDER BY bookings.booking_date DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manage Booking</title>

<style>
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
}

body {
    background: #f3f3f3;
    padding: 24px 20px 40px;
}

.page-wrapper {
    max-width: 1100px;
    margin: 0 auto;
}

.top-header {
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    margin-bottom: 26px;
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
}

.alert {
    max-width: 600px;
    margin: 0 auto 20px;
    padding: 12px 16px;
    border-radius: 6px;
    text-align: center;
    font-weight: bold;
}

.alert.success {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.booking-list {
    display: flex;
    flex-direction: column;
    gap: 14px;
}

.booking-card {
    width: 100%;
    min-height: 70px;
    background: #f8f8f8;
    border: 1.5px solid #666;
    border-radius: 14px;
    display: grid;
    grid-template-columns: 80px 1.5fr 1.7fr 0.9fr 90px;
    align-items: center;
    overflow: hidden;
}

.booking-section {
    height: 100%;
    display: flex;
    align-items: center;
    padding: 12px;
    border-right: 1px solid #888;
}

.booking-section:last-child {
    border-right: none;
}

.date-box {
    justify-content: center;
    text-align: center;
    flex-direction: column;
}

.club-box,
.user-box {
    flex-direction: column;
    align-items: flex-start;
}

.club-name,
.user-name {
    font-size: 14px;
    font-weight: bold;
}

.club-location,
.user-email {
    font-size: 11px;
    color: #555;
}

.price-box {
    justify-content: center;
}

.price {
    font-size: 20px;
    font-weight: bold;
}

.action-box {
    justify-content: center;
    gap: 10px;
}

.action-btn {
    text-decoration: none;
    font-size: 18px;
    color: #444;
}

/* responsive */
@media (max-width: 700px) {
    .booking-card {
        grid-template-columns: 1fr;
    }

    .booking-section {
        border-right: none;
        border-bottom: 1px solid #ccc;
    }

    .booking-section:last-child {
        border-bottom: none;
    }
}
</style>

</head>
<body>

<div class="page-wrapper">

    <div class="top-header">
        <a href="admin_dashboard.php" class="back-btn">&#8592;</a>
        <div class="page-title">MANAGE BOOKING</div>
    </div>

    <?php if (isset($_GET['success'])) { ?>
        <div class="alert success" id="successAlert">
            <?php
            switch ($_GET['success']) {
                case 'booking_updated':
                    echo "Booking updated successfully!";
                    break;
                case 'booking_deleted':
                    echo "Booking deleted successfully!";
                    break;
                default:
                    echo "Action completed successfully!";
                    break;
            }
            ?>
        </div>
    <?php } ?>

    <div class="booking-list">

    <?php if ($result->num_rows > 0) { ?>

        <?php while ($row = $result->fetch_assoc()) { ?>

            <div class="booking-card">

                <!-- DATE -->
                <div class="booking-section date-box">
                    <div><?php echo date("d", strtotime($row['booking_date'])); ?></div>
                    <div><?php echo strtoupper(date("M", strtotime($row['booking_date']))); ?></div>
                </div>

                <!-- CLUB -->
                <div class="booking-section club-box">
    <div class="club-name">
        <?= $row['venue_name']; ?> - Court <?= $row['court_no']; ?>
    </div>
    <div class="club-location">
        <?= $row['location']; ?>
    </div>
</div>

                <!-- USER -->
                <div class="booking-section user-box">
                    <div class="user-name"><?php echo $row['username']; ?></div>
                    <div class="user-email"><?php echo $row['email']; ?></div>
                </div>

                <!-- PRICE -->
                <div class="booking-section price-box">
                   RM <span class="price">
<?= number_format($row['total_price'], 2); ?>
</span>
                </div>

                <!-- ACTION -->
                <div class="booking-section action-box">
                    <a href="edit_booking.php?id=<?php echo $row['booking_id']; ?>" class="action-btn">✎</a>
                    <a href="delete_booking.php?id=<?php echo $row['booking_id']; ?>" 
                       class="action-btn"
                       onclick="return confirm('Are you sure you want to delete this booking?');">
                       ⓧ
                    </a>
                </div>

            </div>

        <?php } ?>

    <?php } else { ?>

        <p style="text-align:center; margin-top:20px;">No bookings found</p>

    <?php } ?>

    </div>

</div>

<script>
    setTimeout(function () {
        var alertBox = document.getElementById('successAlert');
        if (alertBox) {
            alertBox.style.display = 'none';
        }
    }, 2500);
</script>

</body>
</html>