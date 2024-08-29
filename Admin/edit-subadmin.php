<?php
session_start();
include('../conn.php');
error_reporting(0);
if(strlen($_SESSION['login'])==0) { 
    header('location:index.php');
} else {
    if(isset($_POST['submit'])) {
        $aid = intval($_GET['said']);
        $email = $_POST['emailid'];
        $query = mysqli_query($con, "UPDATE tbladmin SET AdminEmailId='$email' WHERE userType=0 AND id='$aid'");
    
    
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
    <title>Newsportal | Edit Subadmin</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css">
    <script src="../assets/js/modernizr.min.js"></script>
</head>
<body class="bg-gray-100">
<?php include('../includes/topheader.php'); ?>
    <!-- Page Wrapper -->
    <div id="wrapper" class="flex min-h-screen">
    <div id="toggleContent">
            <?php include('../includes/leftsidebar.php'); ?>
        </div>      

        <div class=" p-6 w-10/12 mx-auto">
            <!-- Page Title -->
            <!-- <div class="mb-4 flex-col justify-between items-center py-4"> -->
                <div class="mb-4 flex justify-between items-center py-4">
                    <h1 class="text-2xl font-semibold text-gray-800">Manage Sub-admins</h1>
                    <nav class="mt-2 ">
                        <ol class="flex space-x-2 text-gray-600">
                            <li><a href="#" class="hover:text-blue-500">Admin /</a></li>
                            <li><a href="./manage-subadmins.php" class="hover:text-blue-500">Subadmin /</a></li>
                            <li>Manage Sub-admins</li>
                        </ol>
                    </nav>
                </div>

                        <div class="row mb-4">
                        
                                <!--- Success Message --->
                                <?php if ($msg) { ?>
                                    <div class="mb-4 p-3 rounded bg-green-200 text-green-800 border border-green-300">
                                        <strong>Well done!</strong> <?php echo htmlentities($msg); ?>
                                    </div>
                                <?php } ?>

                                <!--- Error Message --->
                                <?php if ($error) { ?>
                                    <div class="mb-4 p-3 rounded bg-red-200 text-red-800 border border-red-300">
                                        <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                                    </div>
                                <?php } ?>
                        
                            </div>


            <!-- Form -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold mb-4">Edit Subadmin</h2>
                <hr class="mb-6" />

               

                <?php 
                $aid = intval($_GET['said']);
                $query = mysqli_query($con, "SELECT * FROM tbladmin WHERE userType=0 AND id='$aid'");
                $row = mysqli_fetch_array($query);
                ?>

                <form class="space-y-6" name="suadmin" method="post">
                    <div class="flex flex-col">
                        <label for="adminusername" class="text-gray-700 text-sm font-medium">Username</label>
                        <input type="text" id="adminusername" value="<?php echo htmlentities($row['AdminUserName']);?>" class="w-full p-2 border border-gray-300 bg-gray-200 rounded-lg shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-500" name="adminusername" readonly>
                    </div>

                    <div class="flex flex-col">
                        <label for="emailid" class="text-gray-700 text-sm font-medium">Email Id</label>
                        <input type="text" id="emailid" value="<?php echo htmlentities($row['AdminEmailId']);?>" class="w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-500" name="emailid" required>
                    </div>

                    <div class="flex flex-col">
                        <label for="cdate" class="text-gray-700 text-sm font-medium">Creation Date</label>
                        <input type="text" id="cdate" value="<?php echo htmlentities($row['CreationDate']);?>" class="w-full p-2 border border-gray-300 bg-gray-200 rounded-lg shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-500" name="cdate" readonly>
                    </div>

                    <div class="flex flex-col">
                        <label for="udate" class="text-gray-700 text-sm font-medium">Updation Date</label>
                        <input type="text" id="udate" value="<?php echo htmlentities($row['UpdationDate']);?>" class="w-full p-2 border border-gray-300 bg-gray-200 rounded-lg shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-500" name="udate" readonly>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-lg shadow-md hover:bg-blue-700 focus:ring focus:ring-blue-200 focus:ring-opacity-50" name="submit">Update</button>
                    </div>
                </form>
            </div>
        </div>
        </div>
        <!-- Content End -->
        </div>
        <!-- Footer -->
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
