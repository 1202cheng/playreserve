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
    die("Court ID not found.");
}

$id = intval($_GET['id']);

$sql = "SELECT * FROM venue_courts WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$court = mysqli_fetch_assoc($result);

if (!$court) {
    die("Court not found.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $court_no = intval($_POST['court_no']);
    $status = $_POST['status'];

    $update_sql = "UPDATE venue_courts SET court_no = ?, status = ? WHERE id = ?";
    $update_stmt = mysqli_prepare($conn, $update_sql);
    mysqli_stmt_bind_param($update_stmt, "isi", $court_no, $status, $id);

    if (mysqli_stmt_execute($update_stmt)) {
        header("Location: manage_court.php?success=court_updated");
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
    <title>Edit Court</title>
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
        <h2>Edit Single Court</h2>

        <form method="POST">

    <label>Court Number</label>
    <input type="number" name="court_no" value="<?php echo $court['court_no']; ?>" required>

    <label>Status</label>
    <select name="status" required>
    <option value="available" <?= $court['status']=='available'?'selected':'' ?>>Available</option>
    <option value="error" <?= $court['status']=='error'?'selected':'' ?>>Error (Maintenance)</option>
</select>

    <div class="btn-group">
        <a href="manage_court.php" class="back-btn">Back</a>

        <button type="submit" class="save-btn">Save Changes</button>
    </div>

</form>

<!-- 🔥 DELETE BUTTON -->
<form action="delete_single_court.php" method="GET" 
      onsubmit="return confirm('Are you sure to delete this court?');">

    <input type="hidden" name="id" value="<?php echo $court['id']; ?>">

    <button type="submit" 
            style="margin-top:10px; width:100%; background:red; color:white; padding:10px; border:none; border-radius:6px; font-weight:bold;">
        🗑 Delete Court
    </button>

</form>

</body>
</html>