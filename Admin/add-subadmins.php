<?php
session_start();
include('../conn.php');
error_reporting(0);
if(strlen($_SESSION['login'])==0) { 
    header('location:index.php');
} else {
    // Code for Add New Sub Admin
    if(isset($_POST['submit'])){
        $username = $_POST['sadminusername'];
        $email = $_POST['emailid'];
        $password = md5($_POST['pwd']);
        $usertype = '0';
        $query = mysqli_query($con, "INSERT INTO tbladmin(AdminUserName,AdminEmailId,AdminPassword,userType) VALUES('$username','$email','$password','$usertype')");
        if ($query) {
            $msg = "Sub-Category created ";
        } else {
            $error = "Something went wrong . Please try again.";
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
                <nav class="mt-2 ">
                    <ol class="flex space-x-2 text-gray-600">
                        <li><a href="#" class="hover:text-blue-500">Admin /</a></li>
                        <li><a href="#" class="hover:text-blue-500">Subadmin /</a></li>
                        <li>Add Subadmin</li>
                    </ol>
                </nav>
            </div>
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

            <div class="w-full mx-auto p-6 bg-white rounded-lg shadow-md">
    <h4 class="text-xl font-semibold mb-4">Add Subadmin</h4>
    <hr class="mb-6" />

    <form class="space-y-6" name="addsuadmin" method="post">
        <div class="flex flex-col space-y-4">
            <div class="flex flex-col">
                <label for="sadminusername" class="text-gray-700 text-sm font-medium">Username (used for login)</label>
                <input type="text" placeholder="Enter Sub-Admin Username" name="sadminusername" id="sadminusername" class="w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-500" pattern="^[a-zA-Z][a-zA-Z0-9-_.]{5,12}$" title="Username must be alphanumeric 6 to 12 chars" required>
                <span id="user-availability-status" class="text-sm text-red-500 mt-1"></span>
            </div>

            <div class="flex flex-col">
                <label for="emailid" class="text-gray-700 text-sm font-medium">Email Id</label>
                <input type="email" class="w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-500" id="emailid" name="emailid" placeholder="Enter email" required>
            </div>

            <div class="flex flex-col">
                <label for="pwd" class="text-gray-700 text-sm font-medium">Password</label>
                <input type="password" class="w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-500" id="pwd" name="pwd" placeholder="Enter password" required>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-lg shadow-md hover:bg-blue-700 focus:ring focus:ring-blue-200 focus:ring-opacity-50" id="submit" name="submit">Submit</button>
            </div>
        </div>
    </form>
</div>
        </div>
        <!-- Content End -->

        <!-- Footer -->
      
        <!-- Footer End -->

    </div>
    <?php include('../includes/footer.php'); ?>
    <div class="fixed inset-0 bg-gray-800 bg-opacity-50 z-50 hidden" id="right-sidebar">
        <div class="bg-white w-64 p-4">
            <button class="text-gray-600" id="close-sidebar">
                <i class="mdi mdi-close-circle-outline text-2xl"></i>
            </button>
            <h4 class="text-xl font-bold mb-4">Settings</h4>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <h5 class="text-gray-700">Notifications</h5>
                    <input type="checkbox" checked class="switchery" data-color="#7fc1fc" data-size="small"/>
                </div>
                <div class="flex justify-between items-center">
                    <h5 class="text-gray-700">API Access</h5>
                    <input type="checkbox" checked class="switchery" data-color="#7fc1fc" data-size="small"/>
                </div>
                <div class="flex justify-between items-center">
                    <h5 class="text-gray-700">Auto Updates</h5>
                    <input type="checkbox" checked class="switchery" data-color="#7fc1fc" data-size="small"/>
                </div>
                <div class="flex justify-between items-center">
                    <h5 class="text-gray-700">Online Status</h5>
                    <input type="checkbox" checked class="switchery" data-color="#7fc1fc" data-size="small"/>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('close-sidebar').addEventListener('click', function() {
            document.getElementById('right-sidebar').classList.add('hidden');
        });
        document.getElementById('toggleButton').addEventListener('click', function() {
            document.getElementById('toggleContent').classList.toggle('hidden');
        });

    </script>

        <script>
            var resizefunc = [];
        </script>

        <!-- jQuery  -->
        <script src="../assets/js/jquery.min.js"></script>
 
        <script src="../assets/js/jquery.app.js"></script>

</body>
</html>
<?php } ?>