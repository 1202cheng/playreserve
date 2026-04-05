<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: manage_user.php?success=user_updated");
    exit();
}

require_once('config.php');

if (!isset($_GET['id'])) {
    header("Location: manage_user.php");
    exit();
}

$id = intval($_GET['id']);

if (isset($_POST['update'])) {
    $username = $_POST['username'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    $sql = "UPDATE users 
            SET username='$username', phone='$phone', email='$email'
            WHERE id=$id";

    if (mysqli_query($conn, $sql)) {
        header("Location: manage_user.php?success=user_updated");
        exit();
    } else {
        echo "Update failed: " . mysqli_error($conn);
    }
}

$sql = "SELECT * FROM users WHERE id = $id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>

    <style>
        * {
            box-sizing: border-box;
            font-family: Arial;
        }

        body {
            padding: 40px;
            background: #f2f2f2;
        }

        .form-container {
            max-width: 400px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 12px;
            border: 1px solid #ccc;
        }

        h2 {
            margin-bottom: 20px;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            border: 1px solid #999;   /* 🔥 统一边框 */
            border-radius: 4px;
            font-size: 14px;
        }

        input:focus {
            outline: none;
            border-color: #005ea8;
        }

        button {
            margin-top: 15px;
            padding: 12px;
            width: 100%;
            background: #005ea8;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            cursor: pointer;
        }

        button:hover {
            background: #004080;
        }
    </style>
</head>

<body>

<div class="form-container">
    <h2>Edit User</h2>

    <form method="POST">
        <input type="text" name="username"
            value="<?php echo htmlspecialchars($row['username']); ?>" required>

        <input type="text" name="phone"
            value="<?php echo htmlspecialchars($row['phone']); ?>" required>

        <input type="email" name="email"
            value="<?php echo htmlspecialchars($row['email']); ?>" required>

        <button type="submit" name="update">Save</button>
    </form>
</div>

</body>
</html>