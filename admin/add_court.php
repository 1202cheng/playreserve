<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

include('../config.php');

$venue_sql = "SELECT * FROM venues ORDER BY venue_name ASC";
$venue_result = mysqli_query($conn, $venue_sql);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $venue_id = intval($_POST['venue_id']);
    $court_no = intval($_POST['court_no']);
    $status = $_POST['status'];

    $check_sql = "SELECT * FROM venue_courts WHERE venue_id = ? AND court_no = ?";
    $check_stmt = mysqli_prepare($conn, $check_sql);
    mysqli_stmt_bind_param($check_stmt, "ii", $venue_id, $court_no);
    mysqli_stmt_execute($check_stmt);
    $check_result = mysqli_stmt_get_result($check_stmt);

    if (mysqli_fetch_assoc($check_result)) {
        $error = "This court number already exists for this venue.";
    } else {
        $insert_sql = "INSERT INTO venue_courts (venue_id, court_no, status) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $insert_sql);
        mysqli_stmt_bind_param($stmt, "iis", $venue_id, $court_no, $status);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: manage_court.php");
            exit();
        } else {
            $error = "Insert failed: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Court</title>
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

        .error-msg {
            color: red;
            margin-bottom: 15px;
            font-size: 14px;
            text-align: center;
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
        <h2>Add Court</h2>

        <?php if (!empty($error)) { ?>
            <div class="error-msg"><?php echo $error; ?></div>
        <?php } ?>

        <form method="POST">
            <label>Venue</label>
            <select name="venue_id" required>
                <option value="">-- Select Venue --</option>
                <?php while ($venue = mysqli_fetch_assoc($venue_result)) { ?>
                    <option value="<?php echo $venue['venue_id']; ?>">
                        <?php echo htmlspecialchars($venue['venue_name']); ?>
                    </option>
                <?php } ?>
            </select>

            <label>Court Number</label>
            <input type="number" name="court_no" required>

            <label>Status</label>
            <select name="status" required>
                <option value="available">Available</option>
                <option value="booked">Booked</option>
                <option value="error">Error</option>
            </select>

            <div class="btn-group">
                <a href="manage_court.php" class="back-btn">Back</a>
                <button type="submit" class="save-btn">Add Court</button>
            </div>
        </form>
    </div>

</body>
</html>