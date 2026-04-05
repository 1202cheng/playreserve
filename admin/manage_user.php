<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

require_once('config.php');

$sql = "SELECT id, username, phone, email FROM users ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manage User</title>

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

.table-header {
    width: 100%;
    background: #74a7d1;
    display: grid;
    grid-template-columns: 90px 1fr 1.3fr 2fr 140px;
    align-items: center;
    padding: 10px 14px;
    font-size: 14px;
    color: #111;
    margin-bottom: 12px;
}

.user-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.user-row {
    width: 100%;
    min-height: 52px;
    border: 1.5px solid #666;
    border-radius: 16px;
    background: #f9f9f9;
    display: grid;
    grid-template-columns: 90px 1fr 1.3fr 2fr 140px;
    align-items: center;
    padding: 8px 14px;
}

.photo-box {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
}

.photo-box img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.cell {
    font-size: 14px;
    color: #222;
    word-break: break-word;
}

.action-box {
    display: flex;
    gap: 10px;
    align-items: center;
}

.action-btn {
    text-decoration: none;
    color: #444;
    font-size: 18px;
}

.no-data {
    text-align: center;
    padding: 20px;
    color: #555;
}
</style>
</head>

<body>

<div class="page-wrapper">

    <div class="top-header">
        <a href="admin_dashboard.php" class="back-btn">&#8592;</a>
        <div class="page-title">MANAGE USER</div>
    </div>

    <?php if (isset($_GET['success'])) { ?>
        <div class="alert success" id="successAlert">
            <?php
            switch ($_GET['success']) {
                case 'user_updated':
                    echo "User updated successfully!";
                    break;
                case 'user_deleted':
                    echo "User deleted successfully!";
                    break;
                default:
                    echo "Action completed successfully!";
                    break;
            }
            ?>
        </div>
    <?php } ?>

    <div class="table-header">
        <div>Photo</div>
        <div>Name</div>
        <div>Mobile</div>
        <div>Email</div>
        <div>Action</div>
    </div>

    <div class="user-list">

    <?php if (mysqli_num_rows($result) > 0) { ?>

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>

            <div class="user-row">

                <div class="photo-box">
                    <img src="default-user.png" alt="User">
                </div>

                <div class="cell">
                    <?php echo htmlspecialchars($row['username']); ?>
                </div>

                <div class="cell">
                    <?php echo htmlspecialchars($row['phone']); ?>
                </div>

                <div class="cell">
                    <?php echo htmlspecialchars($row['email']); ?>
                </div>

                <div class="action-box">
                    <a href="user_history.php?id=<?php echo $row['id']; ?>" class="action-btn">↩</a>
                    <a href="edit_user.php?id=<?php echo $row['id']; ?>" class="action-btn">✎</a>
                    <a href="delete_user.php?id=<?php echo $row['id']; ?>" class="action-btn"
                       onclick="return confirm('Delete this user?');">🗑</a>
                </div>

            </div>

        <?php } ?>

    <?php } else { ?>

        <div class="no-data">No users found</div>

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