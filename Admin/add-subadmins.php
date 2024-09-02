<?php
session_start();
include('../conn.php');
error_reporting(0);
if(strlen($_SESSION['login'])==0) { 
    header('location:index.php');
} else {
    if(isset($_POST['submit'])){
        $username = $_POST['sadminusername'];
        $email = $_POST['emailid'];
        $password = md5($_POST['pwd']);
        $usertype = '0';
        $query = mysqli_query($con, "INSERT INTO tbladmin(AdminUserName,AdminEmailId,AdminPassword,userType) VALUES('$username','$email','$password','$usertype')");
        if ($query) {
            $msg = "Sub-Admin created ";
        } else {
            $error = "Something went wrong. Please try again.";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Newsportal | Add Subadmin</title>
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css">
    <script src="../assets/js/modernizr.min.js"></script>
</head>
<body class="bg-gray-100">
<?php include('../includes/topheader.php'); ?>

<!-- Page Wrapper -->
<div id="wrapper" class="flex flex-row min-h-screen">
    <div id="toggleContent">
        <?php include('../includes/leftsidebar.php'); ?>
    </div>

    <!-- Left Sidebar -->
    <div class="flex-1 p-6 w-10/12 mx-auto">
        <!-- Page Title -->
        <div class="mb-4 flex justify-between items-center py-4">
            <h1 class="text-2xl font-semibold text-gray-800">Add Subadmin</h1>
            <nav class="mt-2">
                <ol class="flex space-x-2 text-gray-600">
                    <li><a href="#" class="hover:text-blue-500">Admin /</a></li>
                    <li><a href="./manage-subadmins.php" class="hover:text-blue-500">Subadmin /</a></li>
                    <li>Add Subadmin</li>
                </ol>
            </nav>
        </div>

        <!-- Messages -->
        <div class="mb-6">
            <?php if($msg){ ?>
                <div class="mb-4 p-3 rounded bg-green-200 text-green-800 border border-green-300">
                    <strong>Well done!</strong> <?php echo htmlentities($msg); ?>
                </div>
            <?php } ?>
            <?php if($error){ ?>
                <div class="mb-4 p-3 rounded bg-red-200 text-red-800 border border-red-300">
                    <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                </div>
            <?php } ?>
        </div>

        <!-- Form -->
        <div class="w-full mx-auto p-6 bg-white rounded-lg shadow-md">
            <h4 class="text-xl font-semibold mb-4">Add Subadmin</h4>
            <hr class="mb-6" />

            <form class="space-y-6" name="addsuadmin" method="post" onsubmit="return validateForm()">
                <div class="flex flex-col space-y-4">
                    <div class="flex flex-col">
                        <label for="sadminusername" class="text-gray-700 text-sm font-medium">Username (used for login)</label>
                        <input type="text" placeholder="Enter Sub-Admin Username" name="sadminusername" id="sadminusername" class="w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-500">
                        <span id="user-availability-status" class="text-sm text-red-500 mt-1"></span>
                    </div>

                    <div class="flex flex-col">
                        <label for="emailid" class="text-gray-700 text-sm font-medium">Email Id</label>
                        <input type="email" placeholder="Enter email" id="emailid" name="emailid" class="w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-500">
                    </div>

                    <div class="flex flex-col">
                        <label for="pwd" class="text-gray-700 text-sm font-medium">Password</label>
                        <input type="password" placeholder="Enter password" id="pwd" name="pwd" class="w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-500">
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-lg shadow-md hover:bg-blue-700 focus:ring focus:ring-blue-200 focus:ring-opacity-50" id="submit" name="submit">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include('../includes/footer.php'); ?>

<script>
function validateForm() {
    const username = document.getElementById('sadminusername').value;
    const email = document.getElementById('emailid').value;
    const password = document.getElementById('pwd').value;
    const usernamePattern = /^[a-zA-Z][a-zA-Z0-9-_.]{5,12}$/;
    const emailPattern = /^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/;

    if(username === ""){
        alert("Username required.");
        return false;
    }
    
    if (!username.match(usernamePattern)) {
        alert('Username must be alphanumeric and 6 to 12 characters long.');
        return false;
    }

    if (!email.match(emailPattern)) {
        alert('Please enter a valid email address.');
        return false;
    }
    if(password === ""){
        alert("password required.");
        return false;
    }

    if (password.length < 6) {
        alert('Password must be at least 6 characters long.');
        return false;
    }

    return true;
}
</script>

<script src="../assets/js/jquery.min.js"></script>
<script src="../assets/js/jquery.app.js"></script>
</body>
</html>
<?php } ?>
