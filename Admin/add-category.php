<?php
    session_start();
        include('../conn.php');
    error_reporting(0);
    if(strlen($_SESSION['login'])==0)
    { 
    header('location:index.php');
    }
    else{

    if(isset($_POST['submit']))
    {
        $category=$_POST['category'];
        $description=$_POST['description'];
        $status=1;
        $query=mysqli_query($con,"insert into tblcategory(CategoryName,Description,Is_Active) values('$category','$description','$status')");
    if($query)
    {
        $msg="Category created ";
    }
    else{
        $error="Something went wrong . Please try again.";    
    } 
    }
?>


<!DOCTYPE html>
<html lang="en">
    <head>

        <title>Newsportal | Add Category</title>

        <!-- App css -->
        <link href="../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/css/core.css" rel="stylesheet" type="text/css" />
        <link href="../assets/css/components.css" rel="stylesheet" type="text/css" />
        <link href="../assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="../assets/css/pages.css" rel="stylesheet" type="text/css" />
        <link href="../assets/css/menu.css" rel="stylesheet" type="text/css" />
        <link href="../assets/css/responsive.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" href="../plugins/switchery/switchery.min.css">
        <script src="../assets/js/modernizr.min.js"></script>

    </head>


    <body class="fixed-left">

        <!-- Begin page -->
        <div id="wrapper">

<!-- Top Bar Start -->
 <?php include('../includes/topheader.php');?>
<!-- Top Bar End -->


<!-- ========== Left Sidebar Start ========== -->
           <?php include('../includes/leftsidebar.php');?>
 <!-- Left Sidebar End -->

            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container mx-auto sm:px-4">


                        <div class="flex flex-wrap ">
							<div class="sm:w-full pr-4 pl-4">
								<div class="page-title-box">
                                    <h4 class="page-title">Add Category</h4>
                                    <ol class="flex flex-wrap list-reset pt-3 pb-3 py-4 px-4 mb-4 bg-gray-200 rounded p-0 m-0">
                                        <li>
                                            <a href="#">Admin</a>
                                        </li>
                                        <li>
                                            <a href="#">Category </a>
                                        </li>
                                        <li class="active">
                                            Add Category
                                        </li>
                                    </ol>
                                    <div class="clearfix"></div>
                                </div>
							</div>
						</div>
                        <!-- end row -->


                        <div class="flex flex-wrap ">
                            <div class="sm:w-full pr-4 pl-4">
                                <div class="card-box">
                                    <h4 class="m-t-0 header-title"><b>Add Category </b></h4>
                                    <hr />
                        		


<div class="flex flex-wrap ">
<div class="sm:w-1/2 pr-4 pl-4">  
<!---Success Message--->  
<?php if($msg){ ?>
<div class="relative px-3 py-3 mb-4 border rounded bg-green-200 border-green-300 text-green-800" role="alert">
<strong>Well done!</strong> <?php echo htmlentities($msg);?>
</div>
<?php } ?>

<!---Error Message--->
<?php if($error){ ?>
<div class="relative px-3 py-3 mb-4 border rounded bg-red-200 border-red-300 text-red-800" role="alert">
<strong>Oh snap!</strong> <?php echo htmlentities($error);?></div>
<?php } ?>


</div>
</div>





                        			<div class="flex flex-wrap ">
                        				<div class="md:w-1/2 pr-4 pl-4">
                        					<form class="form-horizontal" name="category" method="post">
	                                            <div class="mb-4">
	                                                <label class="md:w-1/5 pr-4 pl-4 control-label">Category</label>
	                                                <div class="md:w-4/5 pr-4 pl-4">
	                                                    <input type="text" class="block appearance-none w-full py-1 px-2 mb-1 text-base leading-normal bg-white text-gray-800 border border-gray-200 rounded" value="" name="category" required>
	                                                </div>
	                                            </div>
	                                     
	                                            <div class="mb-4">
	                                                <label class="md:w-1/5 pr-4 pl-4 control-label">Category Description</label>
	                                                <div class="md:w-4/5 pr-4 pl-4">
	                                                    <textarea class="block appearance-none w-full py-1 px-2 mb-1 text-base leading-normal bg-white text-gray-800 border border-gray-200 rounded" rows="5" name="description" required></textarea>
	                                                </div>
	                                            </div>

        <div class="mb-4">
                                                    <label class="md:w-1/5 pr-4 pl-4 control-label">&nbsp;</label>
                                                    <div class="md:w-4/5 pr-4 pl-4">
                                                  
                                                <button type="submit" class="inline-block align-middle text-center select-none border font-normal whitespace-no-wrap rounded py-1 px-3 leading-normal no-underline btn-custom waves-effect waves-light btn-md" name="submit">
                                                    Submit
                                                </button>
                                                    </div>
                                                </div>

	                                        </form>
                        				</div>


                        			</div>


                        		

                                </div>
                            </div>
                        </div>
                        <!-- end row -->


                    </div> <!-- container -->

                </div> <!-- content -->

<?php include('../includes/footer.php');?>

            </div>
        </div>

        <script>
            var resizefunc = [];
        </script>

        <!-- jQuery  -->
        <script src="../assets/js/jquery.min.js"></script>
        <script src="../assets/js/bootstrap.min.js"></script>
        <script src="../assets/js/detect.js"></script>
        <script src="../assets/js/fastclick.js"></script>
        <script src="../assets/js/jquery.blockUI.js"></script>
        <script src="../assets/js/waves.js"></script>
        <script src="../assets/js/jquery.slimscroll.js"></script>
        <script src="../assets/js/jquery.scrollTo.min.js"></script>
        <script src="../plugins/switchery/switchery.min.js"></script>

        <!-- App js -->
        <script src="../assets/js/jquery.core.js"></script>
        <script src="../assets/js/jquery.app.js"></script>
        <?php
session_start();
include('includes/config.php');
error_reporting(0);
if(strlen($_SESSION['login'])==0) {
    header('location:index.php');
} else {
    if(isset($_POST['submit'])) {
        $category = $_POST['category'];
        $description = $_POST['description'];
        $status = 1;
        $query = mysqli_query($con, "INSERT INTO tblcategory (CategoryName, Description, Is_Active) VALUES ('$category', '$description', '$status')");
        if($query) {
            $msg = "Category created";
        } else {
            $error = "Something went wrong. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Newsportal | Add Category</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="min-h-screen bg-gray-100">

    <!-- Begin page -->
    <div id="wrapper" class="flex flex-col min-h-screen">

        <!-- Top Bar Start -->
        <?php include('includes/topheader.php'); ?>
        <!-- Top Bar End -->

        <!-- Left Sidebar Start -->
        <?php include('includes/leftsidebar.php'); ?>
        <!-- Left Sidebar End -->

        <div class="flex-grow">
            <!-- Start content -->
            <div class="container mx-auto px-4 py-6">

                <div class="mb-6">
                    <div class="text-xl font-semibold mb-2">Add Category</div>
                    <ol class="flex space-x-4 text-sm text-gray-500">
                        <li><a href="#" class="hover:text-gray-900">Admin</a></li>
                        <li><a href="#" class="hover:text-gray-900">Category</a></li>
                        <li class="text-gray-900">Add Category</li>
                    </ol>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h4 class="text-lg font-semibold mb-4">Add Category</h4>

                    <!-- Success Message -->
                    <?php if($msg){ ?>
                    <div class="mb-4 p-3 rounded bg-green-200 text-green-800 border border-green-300">
                        <strong>Well done!</strong> <?php echo htmlentities($msg); ?>
                    </div>
                    <?php } ?>

                    <!-- Error Message -->
                    <?php if($error){ ?>
                    <div class="mb-4 p-3 rounded bg-red-200 text-red-800 border border-red-300">
                        <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                    </div>
                    <?php } ?>

                    <form class="space-y-4" name="category" method="post">
                        <div class="flex items-center">
                            <label class="w-1/5 text-gray-700">Category</label>
                            <div class="w-4/5">
                                <input type="text" class="w-full p-2 border border-gray-300 rounded" name="category" required>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <label class="w-1/5 text-gray-700">Category Description</label>
                            <div class="w-4/5">
                                <textarea class="w-full p-2 border border-gray-300 rounded" rows="5" name="description" required></textarea>
                            </div>
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700" name="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div> <!-- container -->

        </div> <!-- content -->
        
        <?php include('includes/footer.php'); ?>

    </div>

</body>
</html>
<?php } ?>

    </body>
</html>
<?php } ?>