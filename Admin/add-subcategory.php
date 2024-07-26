<?php
session_start();
include('../conn.php');
error_reporting(0);
if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {
    if (isset($_POST['submitsubcat'])) {
        $categoryid = $_POST['category'];
        $subcatname = $_POST['subcategory'];
        $subcatdescription = $_POST['sucatdescription'];
        $status = 1;
        $query = mysqli_query($con, "insert into tblsubcategory(CategoryId,Subcategory,SubCatDescription,Is_Active) values('$categoryid','$subcatname','$subcatdescription','$status')");
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
    <meta charset="utf-8">
    <title>Newsportal | Add Sub Category</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css">
    <script src="../assets/js/modernizr.min.js"></script>
</head>

<body class="bg-gray-100 min-w-full sm:min-w-full">
    <?php include('../includes/topheader.php'); ?>
    <div id="wrapper" class="flex flex-row min-h-screen">
        <div id="toggleContent">
            <?php include('../includes/leftsidebar.php'); ?>
        </div>
        <div class="content p-5 flex flex-col w-full">
            <div class="container mx-auto py-6">
            <div class="row mb-3">
                <div class="col-xs-12">
                <div class="mb-3">
                    <div class="text-xl font-semibold mb-2">Add Sub-Category</div>
                    <ol class="flex space-x-1.5 justify-end text-sm text-gray-500">
                        <li><a href="./admin.php" class="hover:text-gray-900">Admin /</a></li>
                        <li><a href="#" class="hover:text-gray-900">Category /</a></li>
                        <li class="text-gray-900">Add Sub-Category</li>
                    </ol>
                </div>
                </div>
            </div>
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h4 class="text-lg font-semibold mb-4">Add Sub-Category</h4>
                        <hr class="mb-4" />

                        <div class="row mb-4">
                            <div class="col-sm-6">
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
                        </div>

                        <form class="space-y-4" name="category" method="post">
                            <div class="flex items-center">
                                <label class="w-1/5 text-gray-700">Category</label>
                                <div class="w-4/5">
                                    <select class="w-full p-2 border border-gray-300 rounded" name="category" required>
                                        <option value="">Select Category</option>
                                        <?php
                                        // Fetching active categories
                                        $ret = mysqli_query($con, "select id,CategoryName from tblcategory where Is_Active=1");
                                        while ($result = mysqli_fetch_array($ret)) {
                                        ?>
                                            <option value="<?php echo htmlentities($result['id']); ?>"><?php echo htmlentities($result['CategoryName']); ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <label class="w-1/5 text-gray-700">Sub-Category</label>
                                <div class="w-4/5">
                                    <input type="text" class="w-full p-2 border border-gray-300 rounded" name="subcategory" required>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <label class="w-1/5 text-gray-700">Sub-Category Description</label>
                                <div class="w-4/5">
                                    <textarea class="w-full p-2 border border-gray-300 rounded" rows="5" name="sucatdescription" required></textarea>
                                </div>
                            </div>
                            <div class="flex justify-end">
                                <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700" name="submitsubcat">
                                    Submit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
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
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/detect.js"></script>
    <script src="../assets/js/fastclick.js"></script>
    <script src="../assets/js/jquery.blockUI.js"></script>
    <script src="../assets/js/waves.js"></script>
    <script src="../assets/js/jquery.slimscroll.js"></script>
    <script src="../assets/js/jquery.scrollTo.min.js"></script>
    <script src="../plugins/switchery/switchery.min.js"></script>
    <script src="../assets/js/jquery.core.js"></script>
    <script src="../assets/js/jquery.app.js"></script>
</body>
</html>
<?php }  ?>