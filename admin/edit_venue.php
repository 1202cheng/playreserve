<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

include('../config.php');

if (!isset($_GET['id'])) {
    die("Venue ID not found.");
}

$id = intval($_GET['id']);

$sql = "SELECT * FROM venues WHERE venue_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$venue = mysqli_fetch_assoc($result);

if (!$venue) {
    die("Venue not found.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $venue_name = trim($_POST['venue_name']);
    $sport_type = trim($_POST['sport_type']);
    $location = trim($_POST['location']);
    $price_per_hour = $_POST['price_per_hour'];

    $update_sql = "UPDATE venues 
                   SET venue_name = ?, sport_type = ?, location = ?, price_per_hour = ?
                   WHERE venue_id = ?";
    $update_stmt = mysqli_prepare($conn, $update_sql);
    mysqli_stmt_bind_param($update_stmt, "sssdi", $venue_name, $sport_type, $location, $price_per_hour, $id);

    if (mysqli_stmt_execute($update_stmt)) {
        header("Location: manage_court.php?success=venue_updated");
        exit();
    } else {
        die("Update failed: " . mysqli_error($conn));
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Venue</title>
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
        <h2>Edit Venue</h2>

        <form method="POST">
            <label>Venue Name</label>
            <input type="text" name="venue_name" value="<?php echo htmlspecialchars($venue['venue_name']); ?>" required>

            <label>Sport Type</label>
            <select name="sport_type" required>
                <option value="Pickleball" <?php if($venue['sport_type'] == 'Pickleball') echo 'selected'; ?>>Pickleball</option>
                <option value="Badminton" <?php if($venue['sport_type'] == 'Badminton') echo 'selected'; ?>>Badminton</option>
            </select>

            <label>Location</label>
            <input type="text" name="location" value="<?php echo htmlspecialchars($venue['location']); ?>" required>

            <label>Price Per Hour</label>
            <input type="number" step="0.01" name="price_per_hour" value="<?php echo $venue['price_per_hour']; ?>" required>

            <div class="btn-group">
                <a href="manage_court.php" class="back-btn">Back</a>
                <button type="submit" class="save-btn">Save Changes</button>
            </div>
        </form>
    </div>

</body>
</html>