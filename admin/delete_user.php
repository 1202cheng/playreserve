<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: manage_user.php?success=user_deleted");
    exit();
}

require_once('config.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $sql = "DELETE FROM users WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        header("Location: manage_user.php");
        exit();
    } else {
        echo "Delete failed: " . mysqli_error($conn);
    }
} else {
    header("Location: manage_user.php");
    exit();
}
?>