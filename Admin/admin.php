<?php
    session_start();
    include('../conn.php');
    error_reporting(0);
    if(strlen($_SESSION['login'])==0)
    { 
        header('location:index.php');
    }
    else {
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>News Portal | Dashboard</title>
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <link rel="stylesheet" href="https://cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css">
        <script src="../assets/js/modernizr.min.js"></script>
    </head>
    <body class="bg-gray-100 min-h-screen">

        <?php include('../includes/topheader.php');?>

        <!-- Begin page -->
        <div id="wrapper" class="flex flex-col md:flex-row min-h-screen">

            <!-- Left Sidebar Start -->
            <div id="toggleContent">
                <?php include('../includes/leftsidebar.php');?>
            </div>
            <!-- Left Sidebar End -->

            <!-- Start right Content here -->
            <div class="flex-grow p-6">
                <!-- Start content -->
                <div class="content">
                    <div class="container mx-auto">
                        <div class="mb-6">
                            <div class="flex justify-between items-center">
                                <h4 class="text-2xl font-bold">Dashboard</h4>
                                <ol class="breadcrumb flex space-x-1.5 text-sm">
                                    <li><a href="../index.php" class="text-gray-600 hover:text-gray-800">NewsPortal /</a></li>
                                    <li><a href="#" class="text-gray-600 hover:text-gray-800">Admin /</a></li>
                                    <li class="text-gray-500">Dashboard</li>
                                </ol>
                            </div>
                        </div>

                        <!-- Cards Row 1 -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                            <a href="./manage-categories.php" class="block bg-white p-6 rounded-lg shadow">
                                <div class="flex justify-between items-center space-x-4">
                                    <div>
                                        <p class="text-gray-600 uppercase font-semibold">Categories Listed</p>
                                        <?php 
                                            $query = mysqli_query($con, "select * from tblcategory where Is_Active=1");
                                            $countcat = mysqli_num_rows($query);
                                        ?>
                                        <h2 class="text-2xl font-bold"><?php echo htmlentities($countcat); ?></h2>
                                    </div>
                                    <i class="fa-solid fa-list text-4xl text-gray-600"></i>
                                </div>
                            </a>

                            <a href="manage-subcategories.php" class="block bg-white p-6 rounded-lg shadow">
                                <div class="flex justify-between items-center space-x-4">
                                    <div>
                                        <p class="text-gray-600 uppercase font-semibold">Listed Subcategories</p>
                                        <?php 
                                            $query = mysqli_query($con, "select * from tblsubcategory where Is_Active=1");
                                            $countsubcat = mysqli_num_rows($query);
                                        ?>
                                        <h2 class="text-2xl font-bold"><?php echo htmlentities($countsubcat); ?></h2>
                                    </div>
                                    <i class="fa-solid fa-table-list text-4xl text-gray-600"></i>
                                </div>
                            </a>

                            <a href="manage-posts.php" class="block bg-white p-6 rounded-lg shadow">
                                <div class="flex justify-between items-center space-x-4">
                                    <div>
                                        <p class="text-gray-600 uppercase font-semibold">Live News</p>
                                        <?php 
                                            $query = mysqli_query($con, "select * from tblposts where Is_Active=1");
                                            $countposts = mysqli_num_rows($query);
                                        ?>
                                        <h2 class="text-2xl font-bold"><?php echo htmlentities($countposts); ?></h2>
                                    </div>
                                    <i class="fa-solid fa-newspaper text-4xl text-gray-600"></i>
                                </div>
                            </a>
                        </div>

                        <!-- Cards Row 2 -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mt-4">
                            <a href="trash-posts.php" class="block bg-white p-6 rounded-lg shadow">
                                <div class="flex justify-between items-center space-x-4">
                                    <div>
                                        <p class="text-gray-600 uppercase font-semibold">Trash News</p>
                                        <?php 
                                            $query = mysqli_query($con, "select * from tblposts where Is_Active=0");
                                            $countposts = mysqli_num_rows($query);
                                        ?>
                                        <h2 class="text-2xl font-bold"><?php echo htmlentities($countposts); ?></h2>
                                    </div>
                                    <i class="fa-solid fa-dumpster text-4xl text-gray-600"></i>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Right content here -->

            <!-- Right Sidebar -->
            <div class="fixed inset-0 bg-gray-800 bg-opacity-50 z-50 hidden" id="right-sidebar">
                <div class="bg-white w-64 p-4">
                    <button class="text-gray-600" id="close-sidebar">
                        <i class="mdi mdi-close-circle-outline text-2xl"></i>
                    </button>
                </div>
            </div>
            <!-- /Right Sidebar -->

        </div>
        <!-- END wrapper -->

        <?php include('../includes/footer.php');?>

        <script src="../assets/js/jquery.min.js"></script>
        <script src="../assets/js/jquery.core.js"></script>
        <script src="../assets/js/jquery.app.js"></script>

        <script>
            document.getElementById('close-sidebar').addEventListener('click', function() {
                document.getElementById('right-sidebar').classList.add('hidden');
            });
            document.getElementById('toggleButton').addEventListener('click', function() {
                document.getElementById('toggleContent').classList.toggle('hidden');
            });
        </script>

    </body>
</html>
<?php } ?>
