<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
<title>Login</title>

<script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-gray-200 flex items-center justify-center min-h-screen">

<div class="bg-white w-[500px] p-10 rounded shadow relative">

<a href="index.php" class="absolute left-4 top-4 text-xl">←</a>

<h2 class="text-center text-xl font-semibold mb-8">LOG IN</h2>

<?php
if(isset($_GET['error'])){
?>
<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-center">
    
    <?php
    if($_GET['error'] == "usernotfound"){
        echo "User is not found.";
    }

    if($_GET['error'] == "wrongpassword"){
        echo "Incorrect password.";
    }
    ?>

</div>
<?php
}
?>

<?php
if(isset($_GET['success'])){
?>

<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 text-center">

<?php
if($_GET['success'] == "passwordupdated"){
    echo "Password updated successfully. Please login.";
}
?>

</div>

<?php
}
?>

<form action="login_process.php" method="POST" class="space-y-6">

<!-- Email -->
<div>
<label class="text-gray-700">Email</label>
<input type="email" name="email"
class="w-full bg-blue-100 rounded p-3 mt-2 outline-none">
</div>

<!-- Password -->
<div>
<label class="text-gray-700">Password</label>

<input type="password" name="password"
class="w-full bg-blue-100 rounded p-3 mt-2 outline-none">

<!-- Forgot Password -->
<div class="flex justify-end mt-1">
<a href="forgot_password.php" class="text-sm text-blue-600 hover:underline">
Forgot Password?
</a>
</div>

</div>

<!-- Login Button -->
<button class="w-full bg-blue-700 text-white py-3 rounded-full hover:bg-blue-800 transition">

LOG IN

</button>

<p class="text-center text-sm">
Don't have an account?
<a href="signup.php" class="text-blue-600">Sign Up</a>
</p>

</form>

</div>

</body>
</html>