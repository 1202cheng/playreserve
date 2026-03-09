<?php

$email = $_GET['email'];

?>

<!DOCTYPE html>
<html>
<head>
<title>Reset Password</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-200 flex items-center justify-center min-h-screen">

<div class="bg-white w-[420px] p-8 rounded shadow">

<h2 class="text-center text-xl mb-6">Create New Password</h2>

<form action="update_password.php" method="POST" class="space-y-4">

<input type="hidden" name="email" value="<?php echo $email; ?>">

<input
type="password"
name="password"
placeholder="New Password"
class="w-full bg-blue-100 p-3 rounded"
required>

<input
type="password"
name="confirm_password"
placeholder="Confirm Password"
class="w-full bg-blue-100 p-3 rounded"
required>

<button class="w-full bg-blue-700 text-white py-2 rounded">

Update Password

</button>

</form>

</div>

</body>
</html>