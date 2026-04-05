<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

include('../config.php');

$sql = "SELECT * FROM venues ORDER BY venue_id DESC";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Court</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f3f3f3;
            padding: 24px 28px 40px;
        }

        .top-header {
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            margin-bottom: 28px;
        }

        .back-btn {
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            text-decoration: none;
            color: black;
            font-size: 28px;
            font-weight: bold;
        }

        .page-title {
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 0.5px;
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

        .legend {
            display: flex;
            justify-content: center;
            gap: 34px;
            margin-bottom: 24px;
            flex-wrap: wrap;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
        }

        .legend-circle {
            width: 16px;
            height: 16px;
            border-radius: 50%;
            border: 1px solid #8a8a8a;
        }

        .available {
            background: #ffffff;
        }

        

        .error {
            background: #e6e6e6;
        }

        .clubs-wrapper {
            display: grid;
            grid-template-columns: repeat(2, minmax(320px, 1fr));
            gap: 18px;
            max-width: 980px;
            margin: 0 auto;
        }

        .club-card {
            background: #f8f8f8;
            border: 1.5px solid #555;
            border-radius: 10px;
            padding: 10px 10px 8px;
            position: relative;
        }

        .club-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 10px;
        }

        .club-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 2px;
        }

        .club-subtitle {
            font-size: 10px;
            color: #555;
            text-transform: uppercase;
        }

        .court-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px 8px;
            margin-bottom: 12px;
        }

        .court-box {
            height: 34px;
            border: 1px solid #666;
            border-radius: 7px;
            font-size: 11px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            line-height: 1.05;
            text-align: center;
            background: white;
            color: #222;
        }

        .court-box.error {
            background: #ededed;
            color: #9a9a9a;
            border-color: #b5b5b5;
        }

        .club-bottom {
            margin-top: 6px;
        }

        .edit-icon {
            font-size: 14px;
            color: #444;
            text-decoration: none;
            font-weight: bold;
            transition: 0.2s ease;
        }

        .edit-icon:hover {
            transform: scale(1.2);
            color: #005ea8;
        }

        .delete-icon {
            position: absolute;
            bottom: 8px;
            right: 10px;
            font-size: 16px;
            text-decoration: none;
            color: #b00020;
        }

        .delete-icon:hover {
            transform: scale(1.2);
            color: red;
        }
    </style>
</head>
<body>

<div class="top-header">
    <a href="admin_dashboard.php" class="back-btn">&#8592;</a>
    <div class="page-title">MANAGE COURT</div>
</div>

<?php if (isset($_GET['success'])) { ?>
    <div class="alert success" id="successAlert">
        <?php
        switch ($_GET['success']) {
            case 'venue_added':
                echo "Venue added successfully!";
                break;
            case 'venue_updated':
                echo "Venue updated successfully!";
                break;
            case 'venue_deleted':
                echo "Venue deleted successfully!";
                break;
            case 'court_added':
                echo "Court added successfully!";
                break;
            case 'court_updated':
                echo "Court updated successfully!";
                break;
            case 'court_deleted':
                echo "Court deleted successfully!";
                break;
            default:
                echo "Action completed successfully!";
                break;
        }
        ?>
    </div>
<?php } ?>

<div style="text-align:center; margin-bottom:20px;">
    <a href="add_venue.php" style="text-decoration:none; background:#005ea8; color:white; padding:10px 16px; border-radius:6px; font-weight:bold; margin-right:10px;">+ Add Venue</a>
    <a href="add_court.php" style="text-decoration:none; background:#444; color:white; padding:10px 16px; border-radius:6px; font-weight:bold;">+ Add Court</a>
</div>

<div class="legend">
    <div class="legend-item">
        <div class="legend-circle available"></div>
        <span>Available</span>
    </div>

    <div class="legend-item">
        <div class="legend-circle error"></div>
        <span>Error</span>
    </div>
</div>

<div class="clubs-wrapper">
<?php while ($venue = mysqli_fetch_assoc($result)) { ?>
    <div class="club-card">
        <div class="club-top">
            <div>
                <div class="club-title"><?php echo htmlspecialchars($venue['venue_name']); ?></div>
                <div class="club-subtitle"><?php echo htmlspecialchars($venue['location']); ?></div>
            </div>
        </div>

        <div class="court-grid">
            <?php
            $venue_id = $venue['venue_id'];
            $court_sql = "SELECT * FROM venue_courts WHERE venue_id = $venue_id ORDER BY court_no ASC";
            $court_result = mysqli_query($conn, $court_sql);

            while ($court = mysqli_fetch_assoc($court_result)) {
                $status = $court['status'];
            ?>
                <a href="edit_single_court.php?id=<?php echo $court['id']; ?>" style="text-decoration:none;">
                    <div class="court-box <?php echo $status; ?>">
                        COURT<br><?php echo $court['court_no']; ?>
                    </div>
                </a>
            <?php } ?>
        </div>

        <div class="club-bottom">
            <a href="edit_venue.php?id=<?php echo $venue['venue_id']; ?>" class="edit-icon">✎ Edit Venue</a>
            <a href="delete_venue.php?id=<?php echo $venue['venue_id']; ?>"
               class="delete-icon"
               onclick="return confirm('Delete this venue and all courts?');">
               🗑
            </a>
        </div>
    </div>
<?php } ?>
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