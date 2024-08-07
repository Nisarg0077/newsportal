<?php 
session_start();
include('../conn.php');
error_reporting(0);

if(strlen($_SESSION['login']) == 0) { 
    header('location:index.php');
} else {
    if(isset($_POST['update'])) {
        $posttitle = $_POST['posttitle'];
        $catid = $_POST['category'];
        $subcatid = $_POST['subcategory'];
        $postdetails = $_POST['postdescription'];
        $lastuptdby = $_SESSION['login'];
        $arr = explode(" ", $posttitle);
        $url = implode("-", $arr);
        $status = 1;
        $postid = intval($_GET['pid']);
        $query = mysqli_query($con, "UPDATE tblposts SET PostTitle='$posttitle', CategoryId='$catid', SubCategoryId='$subcatid', PostDetails='$postdetails', PostUrl='$url', Is_Active='$status', lastUpdatedBy='$lastuptdby' WHERE id='$postid'");

        if($query) {
            $msg = "Post updated successfully";
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
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <title>Newsportal | Edit Post</title>
    
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css">
    <script src="../assets/js/modernizr.min.js"></script>

    <script src="../assets/js/modernizr.min.js"></script>
    <script>
        function getSubCat(val) {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "get_subcategory.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    document.getElementById("subcategory").innerHTML = xhr.responseText;
                }
            };
            xhr.send("catid=" + val);
        }
    </script>
</head>

<body class="bg-gray-100 min-w-full sm:min-w-full" >
<?php include('../includes/topheader.php');?>

<!-- Begin page -->
<div id="wrapper" class="flex flex-row min-h-screen"> 
    <div id="toggleContent">
        <?php include('../includes/leftsidebar.php'); ?>
    </div>
    <!-- Right Content Start -->
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container mx-auto">

                <!-- Page Title -->
                <div class="flex justify-between items-center py-4">
                    <h4 class="text-xl font-semibold">Edit Post</h4>
                    <ol class="flex space-x-2 text-gray-600">
                        <li><a href="#" class="text-blue-600">Admin</a></li>
                        <li><a href="#" class="text-blue-600">Posts</a></li>
                        <li class="text-gray-500">Edit Post</li>
                    </ol>
                </div>

                <!-- Success/Error Messages -->
                <div class="mb-4">
                    <?php if($msg): ?>
                    <div class="bg-green-100 text-green-800 p-4 rounded-lg">
                        <strong>Well done!</strong> <?php echo htmlentities($msg); ?>
                    </div>
                    <?php endif; ?>
                    <?php if($error): ?>
                    <div class="bg-red-100 text-red-800 p-4 rounded-lg">
                        <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                    </div>
                    <?php endif; ?>
                </div>

                <?php
                $postid = intval($_GET['pid']);
                $query = mysqli_query($con, "SELECT tblposts.id as postid, tblposts.PostImage, tblposts.PostTitle as title, tblposts.PostDetails, tblcategory.CategoryName as category, tblcategory.id as catid, tblsubcategory.SubCategoryId as subcatid, tblsubcategory.Subcategory as subcategory FROM tblposts LEFT JOIN tblcategory ON tblcategory.id = tblposts.CategoryId LEFT JOIN tblsubcategory ON tblsubcategory.SubCategoryId = tblposts.SubCategoryId WHERE tblposts.id = '$postid' AND tblposts.Is_Active = 1");
                while($row = mysqli_fetch_array($query)) {
                ?>
                <!-- Post Edit Form -->
                <form name="addpost" method="post" class="bg-white p-6 rounded-lg shadow-lg">
                    <div class="mb-4">
                        <label for="posttitle" class="block text-gray-700">Post Title</label>
                        <input type="text" class="form-control w-full" id="posttitle" value="<?php echo htmlentities($row['title']); ?>" name="posttitle" placeholder="Enter title" required>
                    </div>

                    <div class="mb-4">
                        <label for="category" class="block text-gray-700">Category</label>
                        <select class="form-control w-full" name="category" id="category" onChange="getSubCat(this.value);" required>
                            <option value="<?php echo htmlentities($row['catid']); ?>"><?php echo htmlentities($row['category']); ?></option>
                            <?php
                            // Fetching active categories
                            $ret = mysqli_query($con, "SELECT id, CategoryName FROM tblcategory WHERE Is_Active = 1");
                            while($result = mysqli_fetch_array($ret)) {
                            ?>
                            <option value="<?php echo htmlentities($result['id']); ?>"><?php echo htmlentities($result['CategoryName']); ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="subcategory" class="block text-gray-700">Sub Category</label>
                        <select class="form-control w-full" name="subcategory" id="subcategory" required>
                            <option value="<?php echo htmlentities($row['subcatid']); ?>"><?php echo htmlentities($row['subcategory']); ?></option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="postdescription" class="block text-gray-700">Post Details</label>
                        <textarea class="summernote w-full" name="postdescription" required><?php echo htmlentities($row['PostDetails']); ?></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Post Image</label>
                        <img src="postimages/<?php echo htmlentities($row['PostImage']); ?>" width="300" class="mb-2" />
                        <br />
                        <a href="change-image.php?pid=<?php echo htmlentities($row['postid']); ?>" class="text-blue-600">Update Image</a>
                    </div>

                    <button type="submit" name="update" class="bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700">Update</button>
                </form>
                <?php } ?>

            </div> <!-- container -->
        </div> <!-- content -->

        <?php include('../includes/footer.php'); ?>
    </div>
    <!-- End Right content -->
</div>
<!-- END wrapper -->

<!-- JavaScript -->
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
   
    <script src="../assets/js/jquery.app.js"></script>
</body>
</html>
<?php } ?>