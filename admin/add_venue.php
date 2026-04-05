<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

include('../config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $venue_name = trim($_POST['venue_name']);
    $sport_type = trim($_POST['sport_type']);
    $location = trim($_POST['location']);
    $price_per_hour = $_POST['price_per_hour'];

    $insert_sql = "INSERT INTO venues (venue_name, sport_type, location, price_per_hour) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $insert_sql);
    mysqli_stmt_bind_param($stmt, "sssd", $venue_name, $sport_type, $location, $price_per_hour);

    if (mysqli_stmt_execute($stmt)) {
        $venue_id = mysqli_insert_id($conn);

        for ($i = 1; $i <= 16; $i++) {
            $court_sql = "INSERT INTO venue_courts (venue_id, court_no, status) VALUES (?, ?, 'available')";
            $court_stmt = mysqli_prepare($conn, $court_sql);
            mysqli_stmt_bind_param($court_stmt, "ii", $venue_id, $i);
            mysqli_stmt_execute($court_stmt);
        }

        header("Location: manage_court.php?success=venue_added");
        exit();
    } else {
        die("Insert failed: " . mysqli_error($conn));
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Venue</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f3f3f3;
            padding: 30px;
        }

        .form-container {
            max-width: 500px;
            margin: 0 auto;
            background: #fff;
            padding: 24px;
            border-radius: 10px;
            border: 1px solid #ccc;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-top: 12px;
            margin-bottom: 6px;
            font-weight: bold;
            font-size: 14px;
        }

        input, select {
            width: 100%;
            padding: 10px;
            border: 1px solid #aaa;
            border-radius: 6px;
        }

        .btn-group {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }

        .back-btn, .save-btn {
            text-decoration: none;
            border: none;
            padding: 10px 16px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            text-align: center;
            flex: 1;
        }

        .back-btn {
            background: #ccc;
            color: black;
        }

        .save-btn {
            background: #005ea8;
            color: white;
        }
    </style>
</head>
<body>

    <div class="form-container">
        <h2>Add Venue</h2>

        <form method="POST">
            <label>Venue Name</label>
            <input type="text" name="venue_name" required>

            <label>Sport Type</label>
            <select name="sport_type" required>
                <option value="">-- Select Sport Type --</option>
                <option value="Pickleball">Pickleball</option>
                <option value="Badminton">Badminton</option>
            </select>

            <label>Location</label>
            <input type="text" name="location" required>

            <label>Price Per Hour</label>
            <input type="number" step="0.01" name="price_per_hour" required>

            <div class="btn-group">
                <a href="manage_court.php" class="back-btn">Back</a>
                <button type="submit" class="save-btn">Add Venue</button>
            </div>
        </form>
    </div>

</body>
</html>