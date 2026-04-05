<?php
$email = $_GET['email'];
?>

<!DOCTYPE html>
<html>

<head>
<title>Reset Password</title>

<script src="https://cdn.tailwindcss.com"></script>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<body class="bg-gray-200 flex items-center justify-center min-h-screen">

<div class="bg-white w-[420px] p-8 rounded shadow">

<h2 class="text-center text-xl mb-6">Create New Password</h2>

<!-- Error Messages -->

<?php if(isset($_GET['error']) && $_GET['error']=="samepassword"){ ?>

<div class="bg-red-200 border border-red-400 text-red-700 px-4 py-2 rounded mb-6 text-center">

New password cannot be the same as old password.

</div>

<?php } ?>

<?php if(isset($_GET['error']) && $_GET['error']=="passwordnotmatch"){ ?>

<div class="bg-red-200 border border-red-400 text-red-700 px-4 py-2 rounded mb-6 text-center">

Passwords do not match.

</div>

<?php } ?>

<form action="update_password.php" method="POST" class="space-y-4" onsubmit="return validatePassword()">

<input type="hidden" name="email" value="<?php echo $email; ?>">

<!-- New Password -->

<div class="relative">

<input
type="password"
id="password"
name="password"
placeholder="New Password"
pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}"
title="Password must contain uppercase, lowercase, number, symbol and 8 characters"
class="w-full bg-blue-100 p-3 pr-10 rounded outline-none"
required>

<button
type="button"
onclick="togglePassword('password',this)"
class="absolute right-3 top-[12px] text-gray-400 hover:text-gray-600">

<i class="fa-solid fa-eye"></i>

</button>

</div>

<!-- Confirm Password -->

<div class="relative">

<input
type="password"
id="confirm_password"
name="confirm_password"
placeholder="Confirm Password"
class="w-full bg-blue-100 p-3 pr-10 rounded outline-none"
required>

<button
type="button"
onclick="togglePassword('confirm_password',this)"
class="absolute right-3 top-[12px] text-gray-400 hover:text-gray-600">

<i class="fa-solid fa-eye"></i>

</button>

</div>

<p id="errorMsg" class="text-red-500 text-sm hidden">
Passwords do not match
</p>

<button class="w-full bg-blue-700 text-white py-2 rounded hover:bg-blue-800">

Update Password

</button>

</form>

</div>

<script>

/* SHOW / HIDE PASSWORD */

function togglePassword(id,btn){

const field = document.getElementById(id);
const icon = btn.querySelector("i");

if(field.type === "password"){

field.type = "text";
icon.classList.remove("fa-eye");
icon.classList.add("fa-eye-slash");

}else{

field.type = "password";
icon.classList.remove("fa-eye-slash");
icon.classList.add("fa-eye");

}

}


/* PASSWORD MATCH CHECK */

function validatePassword(){

const password = document.getElementById("password").value;
const confirm = document.getElementById("confirm_password").value;
const errorMsg = document.getElementById("errorMsg");

if(password !== confirm){

errorMsg.classList.remove("hidden");
return false;

}

return true;

}

</script>

</body>
</html>