<?php

$message = "";
$messageType = "";

/* SUCCESS MESSAGE */

if(isset($_GET['success'])){

    if($_GET['success'] == "register"){
        $message = "Registration successful! Please log in.";
        $messageType = "success";
    }

    if($_GET['success'] == "passwordupdated"){
        $message = "Password updated successfully. Please login.";
        $messageType = "success";
    }

}

/* ERROR MESSAGE */

if(isset($_GET['error'])){

    if($_GET['error'] == "usernotfound"){
        $message = "User is not found.";
        $messageType = "error";
    }

    if($_GET['error'] == "wrongpassword"){
        $message = "Incorrect password.";
        $messageType = "error";
    }

}

?>

<!DOCTYPE html>
<html>

<head>
<title>Login</title>

<script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-gray-200 flex items-center justify-center min-h-screen">

<div class="bg-white w-[500px] p-10 rounded shadow relative">

<!-- <a href="index.php" class="absolute left-4 top-4 text-xl">←</a> -->

<h2 class="text-center text-xl font-semibold mb-8">LOG IN</h2>

<!-- ALERT MESSAGE -->

<?php if(!empty($message)){ ?>

<div class="<?php echo $messageType == 'error'
? 'bg-red-100 border border-red-400 text-red-700'
: 'bg-green-100 border border-green-400 text-green-700'; ?> px-4 py-3 rounded mb-4 text-center">

<?php echo $message; ?>

</div>

<?php } ?>

<form action="login_process.php" method="POST" class="space-y-6">

<!-- Email -->

<div>
<label class="text-gray-700">Email</label>

<input type="email"
name="email"
required
class="w-full bg-blue-100 rounded p-3 mt-2 outline-none">

</div>


<!-- Password -->

<div>

<label class="text-gray-700">Password</label>

<input type="password"
name="password"
required
class="w-full bg-blue-100 rounded p-3 mt-2 outline-none">

<div class="flex justify-end mt-1">

<a href="forgot_password.php" class="text-sm text-blue-600 hover:underline">

Forgot Password?

</a>

</div>

</div>


<!-- LOGIN BUTTON -->

<button class="w-full bg-blue-700 text-white py-3 rounded-full hover:bg-blue-800 transition">

LOG IN

</button>

<p class="text-center text-sm">

Don't have an account?

<a href="signup.php" class="text-blue-600">Sign Up</a>

</p>

</form>

</div>

<script>

/* AUTO HIDE ALERT */

setTimeout(() => {

const alert = document.querySelector('.bg-red-100,.bg-green-100');

if(alert){
alert.style.display = "none";
}

},3000);

</script>

</body>

</html>