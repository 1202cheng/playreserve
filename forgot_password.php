<!DOCTYPE html>
<html>

<head>
    <title>Forgot Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-200 flex items-center justify-center min-h-screen">

<div class="bg-white w-[420px] p-8 rounded shadow">

<h2 class="text-center text-xl mb-6">Reset Password</h2>

<?php if(isset($_GET['error']) && $_GET['error']=="emailnotfound"){ ?>
<div class="bg-red-200 border border-red-400 text-red-700 px-4 py-2 rounded mb-4 text-center">
Email not found. Please enter a registered email.
</div>
<?php } ?>

<form action="check_email.php" method="POST" class="space-y-4">

<input
type="email"
name="email"
placeholder="Enter your email"
class="w-full bg-blue-100 p-3 rounded"
required>

<button class="w-full bg-blue-700 text-white py-2 rounded">
Continue
</button>

</form>

</div>

</body>

</html>