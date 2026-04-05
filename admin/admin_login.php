<?php
session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-200 flex items-center justify-center min-h-screen">

    <div class="bg-white w-[400px] p-8 rounded shadow">

        <h2 class="text-center text-xl font-semibold mb-6">ADMIN LOGIN</h2>

        <!-- 🔴 Error Message (same style as forgot password) -->
        <?php if(isset($_GET['error']) && $_GET['error']=="notfound"){ ?>
        <div class="bg-red-200 border border-red-400 text-red-700 px-4 py-2 rounded mb-4 text-center">
            Email not found.
        </div>
        <?php } ?>

        <?php if(isset($_GET['error']) && $_GET['error']=="wrongpassword"){ ?>
        <div class="bg-red-200 border border-red-400 text-red-700 px-4 py-2 rounded mb-4 text-center">
            Wrong password.
        </div>
        <?php } ?>

        <form action="admin_login_process.php" method="POST" class="space-y-4">

            <div>
                <label class="text-sm text-gray-600">Admin Email</label>
                <input
                    type="email"
                    name="email"
                    class="w-full bg-blue-100 rounded p-3 mt-1 outline-none"
                    required>
            </div>

            <div>
                <label class="text-sm text-gray-600">Password</label>
                <input
                    type="password"
                    name="password"
                    class="w-full bg-blue-100 rounded p-3 mt-1 outline-none"
                    required>
            </div>

            <button class="w-full bg-blue-700 text-white py-2 rounded-full mt-4 hover:bg-blue-800 transition">
                Login
            </button>

        </form>

    </div>

</body>

</html>