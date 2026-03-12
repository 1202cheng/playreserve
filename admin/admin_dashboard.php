<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <div class="p-6">

        <h1 class="text-2xl font-bold">Admin Dashboard</h1>

        <p class="mt-2">Welcome Admin</p>

        <a href="admin_logout.php" class="text-red-500 mt-4 inline-block">Logout</a>

    </div>

</body>

</html>