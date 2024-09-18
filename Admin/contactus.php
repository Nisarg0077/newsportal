<?php 
session_start();
include('../conn.php');
error_reporting(0);

if(strlen($_SESSION['login']) == 0) { 
    header('location:index.php');
} else {
    if(isset($_POST['update'])) {
        $pagetype = 'contactus';
        $pagetitle = $_POST['pagetitle'];
        $pagedetails = $_POST['pagedescription'];

        $query = mysqli_query($con, "UPDATE tblpages SET PageTitle='$pagetitle', Description='$pagedetails' WHERE PageName='$pagetype'");
        if($query) {
            $msg = "Contact us page successfully updated";
        } else {
            $error = "Something went wrong. Please try again.";    
        } 
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
        <meta name="author" content="Coderthemes">
        <title>Newsportal | Contact us Page</title>
        <!-- Tailwind CSS -->
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <link rel="stylesheet" href="https://cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote.min.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote.min.css" rel="stylesheet">
    </head>

    <body class="bg-gray-100">

        <?php include('../includes/topheader.php'); ?>
        <!-- Begin page -->
        <div id="wrapper" class="flex flex-row min-h-screen">
        <div id="toggleContent">
            <?php include('../includes/leftsidebar.php'); ?>
        </div>

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="flex-grow container mx-auto p-6">
                <!-- Start content -->
                <div class="content">
                    <div class="container mx-auto">

                        <div class="row mb-6">
                            <div class="col-xs-12">
                                <div class="mb-6">
                                    <div class="text-xl font-semibold mb-2">Contact us Page</div>
                                    <ol class="flex space-x-1.5 justify-end text-sm text-gray-500">
                                        <li>
                                            <a href="./admin.php" class="hover:text-gray-900">Pages /</a>
                                        </li>
                                        <li class="hover:text-gray-900">
                                            Contact us
                                        </li>
                                    </ol>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>

                        <?php if($msg){ ?>
                        <div class="row mb-6">
                            <div class="col-sm-6">
                                <div class="bg-green-100 text-green-700 p-4 rounded-lg shadow-md">
                                    <strong>Well done!</strong> <?php echo htmlentities($msg); ?>
                                </div>
                            </div>
                        </div>
                        <?php } ?>

                        <?php if($error){ ?>
                        <div class="row mb-6">
                            <div class="col-sm-6">
                                <div class="bg-red-100 text-red-700 p-4 rounded-lg shadow-md">
                                    <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                                </div>
                            </div>
                        </div>
                        <?php } ?>

                        <?php 
                        $pagetype = 'contactus';
                        $query = mysqli_query($con, "SELECT PageTitle, Description FROM tblpages WHERE PageName='$pagetype'");
                        while($row = mysqli_fetch_array($query)) {
                        ?>

                        <div class="row ">
                            <div class="col-md-10 mx-auto">
                                <div class="bg-white p-6 rounded-lg shadow-md">
                                    <form name="aboutus" method="post">
                                        <div class="mb-6">
                                            <label for="pagetitle" class="block text-gray-700 text-sm font-bold mb-2">Page Title</label>
                                            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight  focus:shadow-outline" id="pagetitle" name="pagetitle" value="<?php echo htmlentities($row['PageTitle'])?>" required>
                                        </div>

                                        <div class="mb-6">
                                            <label for="pagedescription" class="block text-gray-700 text-sm font-bold mb-2">Page Details</label>
                                            <textarea class="summernote shadow appearance-none border rounded w-full h-36 py-2 px-3 text-gray-700 leading-tight  focus:shadow-outline" name="pagedescription" required><?php echo htmlentities($row['Description'])?></textarea>
                                        </div>

                                        <button type="submit" name="update" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Update and Post</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php } ?>

                    </div> <!-- container -->
                </div> <!-- content -->

                
            </div>
            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->
            
        </div>
        <?php include('../includes/footer.php'); ?>
        <div class="fixed inset-0 bg-gray-800 bg-opacity-50 z-50 hidden" id="right-sidebar">
        <div class="bg-white w-64 p-4">
            <button class="text-gray-600" id="close-sidebar">
                <i class="mdi mdi-close-circle-outline text-2xl"></i>
            </button>
        </div>
    </div>

    <script>
    document.getElementById('user-menu-button').addEventListener('click', function() {
        const userMenu = document.getElementById('user-menu');
        userMenu.classList.toggle('hidden');
    });
</script>
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
        <script src="../plugins/summernote/summernote.min.js"></script>
        <script>
            jQuery(document).ready(function(){
                $('.summernote').summernote({
                    height: 240,                 
                    minHeight: null,             
                    maxHeight: null,             
                    focus: false                 
                });
            });
        </script>
    </body>
</html>
<?php } ?>
