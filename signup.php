<!DOCTYPE html>
<html>
<head>
<title>Sign Up</title>

<script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-gray-200 flex items-center justify-center min-h-screen">

<div class="bg-white w-[420px] p-10 rounded shadow relative">

<a href="index.php" class="absolute left-4 top-4 text-xl">←</a>

<h2 class="text-center text-xl font-semibold mb-8">SIGN UP</h2>

<form action="register_process.php" method="POST" class="space-y-4">

<div>
<label class="text-sm text-gray-600">Email</label>
<input type="email" name="email"
class="w-full bg-blue-100 rounded p-2.5">
</div>

<div>
<label class="text-sm text-gray-600">Password</label>
<input type="password" name="password"
class="w-full bg-blue-100 rounded p-2.5 mt-1 outline-none">
</div>

<div>
<label class="text-sm text-gray-600">Confirm Password</label>
<input type="password" name="confirm_password"
class="w-full bg-blue-100 rounded p-2.5 mt-1 outline-none">
</div>

<div>
<label class="text-sm text-gray-600">Username</label>
<input type="text" name="username"
class="w-full bg-blue-100 rounded p-2.5 mt-1 outline-none">
</div>

<div>
<label class="text-sm text-gray-600">Date of Birth</label>
<input 
type="date"
name="dob"
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
class="w-full bg-blue-100 rounded p-3 mt-1  appearance-none"
required>

<option value="">Select Gender</option>
<option value="Male">Male</option>
<option value="Female">Female</option>

</select>
</div>

<button class="w-full bg-blue-700 text-white py-2 rounded-full mt-4">
SIGN UP
</button>

<p class="text-xs text-center text-gray-500 mt-2">
By signing up, I agree to the PlayReserve Terms of Use and Privacy Policy.
</p>

<!-- <div class="flex items-center my-4">
<div class="flex-1 border-t"></div>
<span class="px-3 text-gray-500 text-sm">OR</span>
<div class="flex-1 border-t"></div>
</div> -->

<!-- <a href="google-login.php"
class="block text-center bg-blue-700 text-white py-2 rounded">
Continue with GOOGLE
</a> -->

<p class="text-center text-sm mt-4">
Already have an account?
<a href="login.php" class="text-blue-600">Log In</a>
</p>

</form>

</div>

</body>
</html>