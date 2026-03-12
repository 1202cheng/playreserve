<!DOCTYPE html>
<html>

<head>
    <title>Sign Up</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

</head>

<body class="bg-gray-200 flex items-center justify-center min-h-screen">

    <div class="bg-white w-[420px] p-10 rounded shadow relative">
        <a href="index.php" class="absolute left-4 top-4 text-xl">←</a>
        <h2 class="text-center text-xl font-semibold mb-8">SIGN UP</h2>
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
                    class="w-full bg-blue-100 rounded p-2.5 outline-none"
                    required>

                <button type="button" onclick="togglePassword('password')"
                    class="absolute right-3 top-9 text-gray-600">

                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">

                        <path d="M1 12C1 12 5 4 12 4C19 4 23 12 23 12"
                            stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />

                        <path d="M1 12C1 12 5 20 12 20C19 20 23 12 23 12"
                            stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />

                        <circle cx="12" cy="12" r="3"
                            stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />

                    </svg>

                </button>

            </div>

            <div class="relative">
                <label class="text-sm text-gray-600">Confirm Password</label>

                <input
                    type="password"
                    id="confirm_password"
                    name="confirm_password"
                    class="w-full bg-blue-100 rounded p-2.5 outline-none"
                    required>

                <button type="button" onclick="togglePassword('confirm_password')"
                    class="absolute right-3 top-9 text-gray-600">

                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">

                        <path d="M1 12C1 12 5 4 12 4C19 4 23 12 23 12"
                            stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />

                        <path d="M1 12C1 12 5 20 12 20C19 20 23 12 23 12"
                            stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />

                        <circle cx="12" cy="12" r="3"
                            stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />

                    </svg>

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
                    type="text"
                    id="dob"
                    name="dob"
                    placeholder="DD/MM/YYYY"
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

            <button class="w-full bg-blue-700 text-white py-2 rounded-full mt-6 ">
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
        // Date picker
        flatpickr("#dob", {
            dateFormat: "d/m/Y",
            maxDate: "today"
        });

        // Show / Hide password
        function togglePassword(id) {
            const field = document.getElementById(id);

            if (field.type === "password") {
                field.type = "text";
            } else {
                field.type = "password";
            }
        }

        // Username first letter capital
        document.getElementById("username").addEventListener("input", function() {
            this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1);
        });
    </script>
</body>

</html>