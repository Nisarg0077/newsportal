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
        <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
        <meta name="author" content="Coderthemes">
        <!-- App title -->
        <title>News Portal | Dashboard</title>
        <link rel="stylesheet" href="../plugins/morris/morris.css">
        <!-- App css -->
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

        <script src="../assets/js/modernizr.min.js"></script>
    </head>
    <body class="bg-gray-100">
        <?php include('../includes/topheader.php');?>
        <!-- Begin page -->
        <div id="wrapper" class="flex flex-row min-h-screen">
            

            <!-- ========== Left Sidebar Start ========== -->
            <?php include('../includes/leftsidebar.php');?>
            <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="flex-grow">
                <!-- Start content -->
                <div class="content p-6">
                    <div class="container mx-auto">
                        <div class="mb-4">
                            <div class="flex justify-between items-center">
                                <h4 class="text-2xl font-bold">Dashboard</h4>
                                <ol class="breadcrumb flex space-x-2">
                                    <li><a href="#" class="text-gray-600">NewsPortal</a></li>
                                    <li><a href="#" class="text-gray-600">Admin</a></li>
                                    <li class="text-gray-500">Dashboard</li>
                                </ol>
                            </div>
                        </div>
                        <!-- end row -->

                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                            <a href="manage-categories.php" class="block bg-white p-6 rounded-lg shadow">
                                <div class="flex items-center space-x-4">
                                    <i class="mdi mdi-chart-areaspline text-4xl text-gray-600"></i>
                                    <div>
                                        <p class="text-gray-600 uppercase font-semibold">Categories Listed</p>
                                        <?php 
                                            $query = mysqli_query($con, "select * from tblcategory where Is_Active=1");
                                            $countcat = mysqli_num_rows($query);
                                        ?>
                                        <h2 class="text-2xl font-bold"><?php echo htmlentities($countcat); ?></h2>
                                    </div>
                                </div>
                            </a>

                            <a href="manage-subcategories.php" class="block bg-white p-6 rounded-lg shadow">
                                <div class="flex items-center space-x-4">
                                    <i class="mdi mdi-layers text-4xl text-gray-600"></i>
                                    <div>
                                        <p class="text-gray-600 uppercase font-semibold">Listed Subcategories</p>
                                        <?php 
                                            $query = mysqli_query($con, "select * from tblsubcategory where Is_Active=1");
                                            $countsubcat = mysqli_num_rows($query);
                                        ?>
                                        <h2 class="text-2xl font-bold"><?php echo htmlentities($countsubcat); ?></h2>
                                    </div>
                                </div>
                            </a>

                            <a href="manage-posts.php" class="block bg-white p-6 rounded-lg shadow">
                                <div class="flex items-center space-x-4">
                                    <i class="mdi mdi-layers text-4xl text-gray-600"></i>
                                    <div>
                                        <p class="text-gray-600 uppercase font-semibold">Live News</p>
                                        <?php 
                                            $query = mysqli_query($con, "select * from tblposts where Is_Active=1");
                                            $countposts = mysqli_num_rows($query);
                                        ?>
                                        <h2 class="text-2xl font-bold"><?php echo htmlentities($countposts); ?></h2>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <!-- end row -->

                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mt-4">
                            <a href="trash-posts.php" class="block bg-white p-6 rounded-lg shadow">
                                <div class="flex items-center space-x-4">
                                    <i class="mdi mdi-layers text-4xl text-gray-600"></i>
                                    <div>
                                        <p class="text-gray-600 uppercase font-semibold">Trash News</p>
                                        <?php 
                                            $query = mysqli_query($con, "select * from tblposts where Is_Active=0");
                                            $countposts = mysqli_num_rows($query);
                                        ?>
                                        <h2 class="text-2xl font-bold"><?php echo htmlentities($countposts); ?></h2>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div> <!-- container -->
                </div> <!-- content -->
            </div>
            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->
            
            <!-- Right Sidebar -->
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
            <!-- /Right-bar -->
        </div>
        <!-- END wrapper -->
        <?php include('../includes/footer.php');?>
        
        <script>
            var resizefunc = [];
            document.getElementById('close-sidebar').addEventListener('click', function() {
                document.getElementById('right-sidebar').classList.add('hidden');
            });
        </script>

        <!-- jQuery  -->
        <script src="../assets/js/jquery.min.js"></script>
        <script src="../assets/js/detect.js"></script>
        <script src="../assets/js/fastclick.js"></script>
        <script src="../assets/js/waves.js"></script>
        <script src="../assets/js/jquery.blockUI.js"></script>
        <script src="../assets/js/jquery.scrollTo.min.js"></script>
        <script src="../assets/js/jquery.slimscroll.js"></script>
        <script src="../plugins/switchery/switchery.min.js"></script>

        <!-- Counter js  -->
        <script src="../plugins/waypoints/jquery.waypoints.min.js"></script>
        <script src="../plugins/counterup/jquery.counterup.min.js"></script>

        <!--Morris Chart-->
        <script src="../plugins/morris/morris.min.js"></script>
        <script src="../plugins/raphael/raphael-min.js"></script>

        <!-- Dashboard init -->
        <script src="../assets/pages/jquery.dashboard.js"></script>

        <!-- App js -->
        <script src="../assets/js/jquery.core.js"></script>
        <script src="../assets/js/jquery.app.js"></script>
    </body>
</html>
<?php } ?>
