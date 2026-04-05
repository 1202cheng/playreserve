<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

require_once('config.php');

if (!isset($_GET['id'])) {
    header("Location: manage_booking.php");
    exit();
}

$id = intval($_GET['id']);

if (isset($_POST['update'])) {
    $booking_date = $_POST['booking_date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $status = $_POST['status'];

    $sql = "UPDATE bookings 
            SET booking_date='$booking_date', start_time='$start_time', end_time='$end_time', status='$status'
            WHERE booking_id=$id";

    if (mysqli_query($conn, $sql)) {
        header("Location: manage_booking.php?success=booking_updated");
        exit();
    } else {
        echo "Update failed: " . mysqli_error($conn);
    }
}

$sql = "SELECT * FROM bookings WHERE booking_id = $id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if (!$row) {
    header("Location: manage_booking.php?success=booking_updated");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Booking</title>

<style>
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
}

body {
    background: #f2f2f2;
    padding: 40px 20px;
}

.form-container {
    max-width: 500px;
    margin: 0 auto;
    background: #fff;
    border: 1px solid #ccc;
    border-radius: 16px;
    padding: 28px;
}

.page-title {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 24px;
    color: #111;
}

.form-group {
    margin-bottom: 18px;
}

.form-label {
    display: block;
    font-size: 14px;
    font-weight: bold;
    margin-bottom: 8px;
    color: #222;
}

.form-input,
.form-select {
    width: 100%;
    padding: 12px 14px;
    border: 1px solid #999;
    border-radius: 8px;
    font-size: 14px;
    background: #fff;
}

.form-input:focus,
.form-select:focus {
    outline: none;
    border-color: #005ea8;
}

.btn-group {
    display: flex;
    gap: 12px;
    margin-top: 10px;
}

.back-btn,
.save-btn {
    flex: 1;
    text-align: center;
    text-decoration: none;
    padding: 12px;
    border: none;
    border-radius: 10px;
    font-size: 15px;
    font-weight: bold;
    cursor: pointer;
}

.back-btn {
    background: #d9d9d9;
    color: #111;
}

.save-btn {
    background: #005ea8;
    color: #fff;
}

.save-btn:hover {
    background: #004b87;
}

.back-btn:hover {
    background: #c9c9c9;
}
</style>
</head>
<body>

<div class="form-container">
    <div class="page-title">Edit Booking</div>

    <form method="POST">
        <div class="form-group">
            <label class="form-label">Date</label>
            <input type="date" name="booking_date" class="form-input"
                   value="<?php echo htmlspecialchars($row['booking_date']); ?>" required>
        </div>

        <div class="form-group">
            <label class="form-label">Start Time</label>
            <input type="time" name="start_time" class="form-input"
                   value="<?php echo htmlspecialchars($row['start_time']); ?>" required>
        </div>

        <div class="form-group">
            <label class="form-label">End Time</label>
            <input type="time" name="end_time" class="form-input"
                   value="<?php echo htmlspecialchars($row['end_time']); ?>" required>
        </div>

        <div class="form-group">
            <label class="form-label">Status</label>
            <select name="status" class="form-select" required>
                <option value="Confirmed" <?php if($row['status'] == 'Confirmed') echo 'selected'; ?>>Confirmed</option>
                <option value="Pending" <?php if($row['status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                <option value="Cancelled" <?php if($row['status'] == 'Cancelled') echo 'selected'; ?>>Cancelled</option>
            </select>
        </div>

        <div class="btn-group">
            <a href="manage_booking.php" class="back-btn">Back</a>
            <button type="submit" name="update" class="save-btn">Save</button>
        </div>
    </form>
</div>

</body>
</html>