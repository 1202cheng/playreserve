<!DOCTYPE html>
<html>

<head>
    <title>Reset Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-200 flex items-center justify-center min-h-screen">

    <div class="bg-white w-[420px] p-8 rounded shadow">

        <h2 class="text-center text-xl mb-6">Create New Password</h2>

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
                    title="Password must contain 1 uppercase, 1 lowercase, 1 number and 1 symbol"
                    class="w-full bg-blue-100 p-3 rounded outline-none"
                    required>

                <button
                    type="button"
                    onclick="togglePassword('password')"
                    class="absolute right-3 top-3 text-gray-600">
                    👁
                </button>
            </div>

            <!-- Confirm Password -->
            <div class="relative">
                <input
                    type="password"
                    id="confirm_password"
                    name="confirm_password"
                    placeholder="Confirm Password"
                    class="w-full bg-blue-100 p-3 rounded outline-none"
                    required>

                <button
                    type="button"
                    onclick="togglePassword('confirm_password')"
                    class="absolute right-3 top-3 text-gray-600">
                    👁
                </button>
            </div>

            <p id="errorMsg" class="text-red-500 text-sm hidden">
                Passwords do not match
            </p>

            <button class="w-full bg-blue-700 text-white py-2 rounded">
                Update Password
            </button>

        </form>

    </div>

    <script>
        // Show / Hide Password
        function togglePassword(id) {
            const field = document.getElementById(id);
            field.type = field.type === "password" ? "text" : "password";
        }

        // Confirm password validation
        function validatePassword() {

            const password = document.getElementById("password").value;
            const confirm = document.getElementById("confirm_password").value;
            const errorMsg = document.getElementById("errorMsg");

            if (password !== confirm) {
                errorMsg.classList.remove("hidden");
                return false;
            }

            return true;
        }
    </script>

</body>

</html>