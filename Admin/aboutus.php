<?php 
session_start();
include('../conn.php');
error_reporting(0);
if(strlen($_SESSION['login']) == 0) { 
    header('location:index.php');
} else {
    if(isset($_POST['update'])) {
        $pagetype = 'aboutus';
        $pagetitle = $_POST['pagetitle'];
        $pagedetails = addslashes($_POST['pagedescription']);

        $query = mysqli_query($con, "UPDATE tblpages SET PageTitle='$pagetitle', Description='$pagedetails' WHERE PageName='$pagetype'");
        if($query) {
            $msg = "About us page successfully updated";
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
    <title>Newsportal | About us Page</title>
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
        <div class="content-page w-10/12">
            <!-- Start content -->
            <div class="content">
                <div class="container mx-auto p-6">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="mb-6">
                            <div class="text-xl font-semibold mb-2">About Page</div>
                                <ol class="flex space-x-1.5 justify-end text-sm text-gray-500">
                                    <li><a href="./admin.php" class="hover:text-gray-900">About Page /</a></li>
                                    <li><a href="#" class="hover:text-gray-900">Pages /</a></li>
                                    <li class="text-gray-900">About us</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->

                    <div class="row mb-6">
                        <div class="col-sm-6">
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
                    </div>
                    <?php 
                    $pagetype = 'aboutus';
                    $query = mysqli_query($con, "SELECT PageTitle, Description FROM tblpages WHERE PageName='$pagetype'");
                    while($row = mysqli_fetch_array($query)) {
                    ?>

                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <div class="p-6 bg-white shadow-md rounded">
                                <div class="">
                                    <form name="aboutus" method="post">
                                        <div class="form-group mb-4">
                                            <label for="pagetitle" class="block text-gray-700">Page Title</label>
                                            <input type="text" class="form-control w-full p-2 border border-gray-300 rounded" id="pagetitle" name="pagetitle" value="<?php echo htmlentities($row['PageTitle']) ?>" required>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="card-box">
                                                    <h4 class="mb-4 header-title text-gray-700"><b>Page Details</b></h4>
                                                    <textarea class=" w-full h-44 p-2 border border-gray-300 rounded" name="pagedescription" required><?php echo ($row['Description']) ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } ?>
                                        <button type="submit" name="update" class="bg-green-500 text-white px-4 py-2 rounded mt-4 hover:bg-green-600">Update and Post</button>
                                    </form>
                                </div>
                            </div> <!-- end p-20 -->
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->
                </div> <!-- container -->
            </div> <!-- content -->
        </div>
        <!-- End Right content here -->
    </div>
    <?php include('../includes/footer.php'); ?>
    <!-- END wrapper -->
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
</body>
</html>
<?php } ?>
