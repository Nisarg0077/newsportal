<?php
session_start();
// Database Configuration File
include('../conn.php');

// Initialize error variables
$usernameError = $passwordError = $generalError = '';

if (isset($_POST['login'])) {
    // Getting username and password
    $uname = trim($_POST['username']);
    $password = md5(trim($_POST['password']));

    // Initialize error flag
    $hasError = false;

    // Validate username and password on server side
    if (empty($uname)) {
        $usernameError = 'Username is required.';
        $hasError = true;
    } elseif (strlen($uname) < 3) {
        $usernameError = 'Username must be at least 3 characters long.';
        $hasError = true;
    }

    if (empty($password)) {
        $passwordError = 'Password is required.';
        $hasError = true;
    }
    if (!$hasError) {
        // Fetch data from database on the basis of username and password
        $q = "SELECT AdminUserName, AdminEmailId, AdminPassword, userType FROM tbladmin WHERE AdminUserName='$uname' AND AdminPassword='$password'";
        $sql = mysqli_query($con, $q);
        $num = mysqli_fetch_array($sql);

        if ($num) {
            $_SESSION['login'] = $uname;
            $_SESSION['utype'] = $num['userType'];
            echo "<script type='text/javascript'> document.location = '../Admin/admin.php'; </script>";
        } else {
            $generalError = 'Invalid username or password.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script>
        function validateForm(event) {
            // Clear previous error messages
            document.querySelectorAll('.error-message').forEach(elem => elem.textContent = '');

            // Get the values of the input fields
            var username = document.getElementById('username').value.trim();
            var password = document.getElementById('password').value.trim();

            // Initialize error flag
            let hasError = false;

            // Check for empty username
            if (username === '') {
                document.getElementById('username-error').textContent = 'Username is required.';
                hasError = true;
            } else if (username.length < 3) {
                document.getElementById('username-error').textContent = 'Username must be at least 3 characters long.';
                hasError = true;
            }

            // Check for empty password
            if (password === '') {
                document.getElementById('password-error').textContent = 'Password is required.';
                hasError = true;
            } 
            // Prevent form submission if there are errors
            if (hasError) {
                event.preventDefault();
                return false;
            }

            return true;
        }
    </script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="w-full max-w-xs">
        <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" action="" method="POST" onsubmit="return validateForm(event)">
            <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>

            <!-- Display general error -->
            <?php if (!empty($generalError)): ?>
                <div class="mb-4 text-red-500 text-sm text-center">
                    <?php echo htmlspecialchars($generalError); ?>
                </div>
            <?php endif; ?>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
                    Username
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline <?php echo !empty($usernameError) ? 'border-red-500' : ''; ?>" id="username" type="text" name="username" placeholder="Username" autocomplete="off" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
                <p id="username-error" class="text-red-500 text-sm error-message"><?php echo $usernameError; ?></p> <!-- Error message container -->
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                    Password
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline <?php echo !empty($passwordError) ? 'border-red-500' : ''; ?>" id="password" type="password" name="password" placeholder="Password" autocomplete="off">
                <p id="password-error" class="text-red-500 text-sm error-message"><?php echo $passwordError; ?></p> <!-- Error message container -->
            </div>
            <div class="flex items-center space-x-1 mt-2 border-1 rounded shadow border-back py-2 px-3 mt-4">
                <svg width="20%" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-800">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                </svg>
                <a href="../index.php" class="text-black " style="text-decoration: none;">Back Home</a>
            </div>
            <div class="flex items-center justify-between">
                <input class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit" name="login" value="Sign In">
            </div>
        </form>
    </div>
</body>
</html>
