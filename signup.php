<?php

$message = "";
$messageType = "";

if(isset($_GET['error'])){

   switch($_GET['error']){

    case "email":
        $message = "Email already registered.";
        $messageType = "error";
        break;

    case "phone":
        $message = "Phone number already registered.";
        $messageType = "error";
        break;

    case "password":
        $message = "Password not match.";
        $messageType = "error";
        break;

    case "dob":
        $message = "Date of Birth is required.";
        $messageType = "error";
        break;

}

}

if(isset($_GET['success'])){
    $message = "Successfully registered! Please log in.";
    $messageType = "success";
}

?>

<!DOCTYPE html>
<html>

<head>
<title>Sign Up</title>

<script src="https://cdn.tailwindcss.com"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<!-- Added Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<body class="bg-gray-200 flex items-center justify-center min-h-screen">

<div class="bg-white w-[420px] p-10 rounded shadow relative">

<a href="index.php" class="absolute left-4 top-4 text-xl">←</a>

<h2 class="text-center text-xl font-semibold mb-6">SIGN UP</h2>


<!-- ALERT MESSAGE -->

<?php if($message!=""){ ?>

<div class="<?php echo $messageType=="error" ? 'bg-red-100 border border-red-400 text-red-700' : 'bg-green-100 border border-green-400 text-green-700'; ?> px-4 py-3 rounded mb-5 text-center">

<?php echo $message; ?>

</div>

<?php } ?>


<form action="register_process.php" method="POST" class="space-y-4">


<div>

<label class="text-sm text-gray-600">Email</label>

<input
type="email"
name="email"
required
class="w-full bg-blue-100 rounded p-2.5">

</div>


<div class="relative">

<label class="text-sm text-gray-600">Password</label>

<input
type="password"
id="password"
name="password"
pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}"
title="Must contain 1 uppercase, 1 lowercase, 1 number, 1 symbol, and at least 8 characters"
class="w-full bg-blue-100 rounded p-2.5 outline-none pr-10"
required>

<button type="button" onclick="togglePassword('password',this)" class="absolute right-3 top-9 text-gray-600">

<i class="fa-solid fa-eye"></i>

</button>

</div>


<div class="relative">

<label class="text-sm text-gray-600">Confirm Password</label>

<input
type="password"
id="confirm_password"
name="confirm_password"
class="w-full bg-blue-100 rounded p-2.5 outline-none pr-10"
required>

<button type="button" onclick="togglePassword('confirm_password',this)" class="absolute right-3 top-9 text-gray-600">

<i class="fa-solid fa-eye"></i>

</button>

</div>


<div>

<label class="text-sm text-gray-600">Username</label>

<input
type="text"
name="username"
id="username"
class="w-full bg-blue-100 rounded p-2.5 mt-1 outline-none"
required>

</div>


<div>

<label class="text-sm text-gray-600">Date of Birth</label>

<input
type="date"
name="dob"
id="dob"
max="<?= date('Y-m-d'); ?>"
class="w-full bg-blue-100 rounded p-3 mt-1 outline-none"
required>

</div>


<div>

<label class="text-sm text-gray-600">Phone Number</label>

<input
type="tel"
name="phone"
placeholder="+60123456789"
pattern="^(\+60|60|0)?1[0-9]{8,9}$|^(\+65|65)?[689][0-9]{7}$"
class="w-full bg-blue-100 rounded p-3 mt-1 outline-none"
required>

</div>


<div>

<label class="text-sm text-gray-600">Gender</label>

<select
name="gender"
class="w-full bg-blue-100 rounded p-3 mt-1 appearance-none"
required>

<option value="">Select Gender</option>
<option value="Male">Male</option>
<option value="Female">Female</option>

</select>

</div>


<button class="w-full bg-blue-700 text-white py-2 rounded-full mt-6">

SIGN UP

</button>


<p class="text-xs text-center text-gray-500">

By signing up, I agree to the PlayReserve Terms of Use and Privacy Policy.

</p>


<p class="text-center text-sm mt-4">

Already have an account?

<a href="login.php" class="text-blue-600">Log In</a>

</p>


</form>

</div>


<script>

flatpickr("#dob",{

dateFormat:"d/m/Y",
maxDate:"today"

});


function togglePassword(id,btn){

const field=document.getElementById(id);
const icon=btn.querySelector("i");

if(field.type==="password"){

field.type="text";
icon.classList.remove("fa-eye");
icon.classList.add("fa-eye-slash");

}else{

field.type="password";
icon.classList.remove("fa-eye-slash");
icon.classList.add("fa-eye");

}

}


// PASSWORD MATCH CHECK

const password=document.getElementById("password");
const confirmPassword=document.getElementById("confirm_password");

confirmPassword.addEventListener("input",function(){

if(password.value!==confirmPassword.value){

confirmPassword.setCustomValidity("Password not match");

}else{

confirmPassword.setCustomValidity("");

}

});


// Username first letter capital

document.getElementById("username").addEventListener("input",function(){

this.value=this.value.charAt(0).toUpperCase()+this.value.slice(1);

});


// Auto hide alert

setTimeout(()=>{

const alert=document.querySelector(".bg-red-100,.bg-green-100");

if(alert){

alert.style.display="none";

}

},3000);

</script>

</body>

</html>