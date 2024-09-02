<?php
session_start();
include('../conn.php');
error_reporting(0);

if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
    exit();
}

if (isset($_POST['sucatdescription'])) {
    $subcatid = intval($_GET['scid']);
    $categoryid = $_POST['category'];
    $subcatname = $_POST['subcategory'];
    $subcatdescription = $_POST['sucatdescription'];
    
    // Server-side validation
    if (!empty($categoryid) && !empty($subcatname) && !empty($subcatdescription)) {
        $query = mysqli_query($con, "UPDATE tblsubcategory SET CategoryId='$categoryid', Subcategory='$subcatname', SubCatDescription='$subcatdescription' WHERE SubCategoryId='$subcatid'");
        
        if ($query) {
            $msg = "Sub-Category updated successfully.";
        } else {
            $error = "Something went wrong. Please try again.";
        }
    } else {
        $error = "Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Newsportal | Edit Sub Category</title>
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
        <div class="content-page w-10/12">
            <div class="content">
                <div class="container mx-auto p-6">
                    <div class="flex flex-wrap mb-6">
                        <div class="w-full">
                            <div class="mb-3">
                                <div class="text-xl font-semibold mb-2">Edit Sub-Category</div>
                                <ol class="flex space-x-1.5 justify-end text-sm text-gray-500">
                                    <li><a href="./admin.php" class="hover:text-gray-900">Admin /</a></li>
                                    <li><a href="./manage-subcategories.php" class="hover:text-gray-900">Sub-Category /</a></li>
                                    <li class="text-gray-900">Edit Sub-Category</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-wrap mb-6">
                        <div class="w-full">
                            <div class="bg-white p-6 rounded-lg shadow-md">
                                <h4 class="text-xl font-semibold mb-4">Edit Sub-Category</h4>
                                <hr class="mb-4" />
                                <!-- Success Message -->
                                <?php if ($msg) { ?>
                                    <div class="mb-4 p-3 rounded bg-green-200 text-green-800 border border-green-300">
                                        <strong>Well done!</strong> <?php echo htmlentities($msg); ?>
                                    </div>
                                <?php } ?>
                                <!-- Error Message -->
                                <?php if ($error) { ?>
                                    <div class="mb-4 p-3 rounded bg-red-200 text-red-800 border border-red-300">
                                        <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                                    </div>
                                <?php } ?>
                                <?php 
                                // Fetching Category details
                                $subcatid = intval($_GET['scid']);
                                $query = mysqli_query($con, "SELECT tblcategory.CategoryName as catname, tblcategory.id as catid, tblsubcategory.Subcategory as subcatname, tblsubcategory.SubCatDescription as SubCatDescription FROM tblsubcategory JOIN tblcategory ON tblsubcategory.CategoryId=tblcategory.id WHERE tblsubcategory.Is_Active=1 AND SubCategoryId='$subcatid'");
                                while ($row = mysqli_fetch_array($query)) {
                                ?>
                                <form class="space-y-4" id="editSubCategoryForm" method="post">
                                    <div class="flex items-center">
                                        <label class="w-1/5 text-gray-700">Category</label>
                                        <div class="w-4/5">
                                            <select class="w-full p-2 border border-gray-300 rounded mt-4" name="category" id="category">
                                                <option value="<?php echo htmlentities($row['catid']); ?>"><?php echo htmlentities($row['catname']); ?></option>
                                                <?php
                                                // Fetching active categories
                                                $ret = mysqli_query($con, "SELECT id, CategoryName FROM tblcategory WHERE Is_Active=1");
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
                                            <input type="text" class="w-full p-2 border border-gray-300 rounded" value="<?php echo htmlentities($row['subcatname']); ?>" name="subcategory" id="subcategory">
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        <label class="w-1/5 text-gray-700">Sub-Category Description</label>
                                        <div class="w-4/5">
                                            <textarea class="w-full p-2 border border-gray-300 rounded" rows="5" name="sucatdescription" id="sucatdescription"><?php echo htmlentities($row['SubCatDescription']); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="flex justify-end">
                                        <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-lg shadow-md hover:bg-blue-700 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                            Submit
                                        </button>
                                    </div>
                                </form>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
                                                </div>
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
        <?php include('../includes/footer.php'); ?>
        <script>
            document.getElementById('close-sidebar').addEventListener('click', function() {
                document.getElementById('right-sidebar').classList.add('hidden');
            });
            document.getElementById('toggleButton').addEventListener('click', function() {
                document.getElementById('toggleContent').classList.toggle('hidden');
            });
            
            document.getElementById('editSubCategoryForm').addEventListener('submit', function(event) {
                const category = document.getElementById('category').value.trim();
                const subcategory = document.getElementById('subcategory').value.trim();
                const sucatdescription = document.getElementById('sucatdescription').value.trim();
                
                if (!category || !subcategory || !sucatdescription) {
                    event.preventDefault();
                    alert('Please fill in all fields.');
                }
            });
        </script>
        <script src="../assets/js/jquery.min.js"></script>
        <script src="../assets/js/jquery.app.js"></script>
    </body>
</html>
