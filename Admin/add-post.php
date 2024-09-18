<?php 
session_start();
include('../conn.php');

$msg = "";
$error = "";
if(strlen($_SESSION['login']) == 0) { 
    header('location:index.php');
    exit;
}

// For adding post  
if(isset($_POST['submit'])) {
    $posttitle = $_POST['posttitle'];
    $catid = $_POST['category'];
    $subcatid = $_POST['subcategory'];
    $postdetails = addslashes($_POST['postdescription']);
    $postedby = $_SESSION['login'];
    $arr = explode(" ", $posttitle);
    $url = implode("-", $arr);
    $imgfile = $_FILES["postimage"]["name"];
    $extension = substr($imgfile, strlen($imgfile) - 4, strlen($imgfile));
    $allowed_extensions = array(".jpg", ".jpeg", ".png", ".gif");
    if(!in_array($extension, $allowed_extensions)) {
        echo "<script>alert('Invalid format. Only jpg / jpeg / png / gif format allowed');</script>";
    } else {
        $imgnewfile = md5($imgfile) . $extension;
        if (move_uploaded_file($_FILES["postimage"]["tmp_name"], "postimages/" . $imgnewfile)) {
            $status = 1;
            $query = mysqli_query($con, "INSERT INTO tblposts(PostTitle, CategoryId, SubCategoryId, PostDetails, PostUrl, Is_Active, PostImage, postedBy) VALUES('$posttitle', '$catid', '$subcatid', '$postdetails', '$url', '$status', '$imgnewfile', '$postedby')");
            
            if($query) {
                $msg = "Post successfully added";
            } else {
                $error = "Database query failed: " . mysqli_error($con);
                echo "<pre>$error</pre>"; // Display detailed error
            }
        } else {
            $error = "Failed to upload image.";
        }
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
    <title>Newsportal | Add Post</title>

    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css">
    <script src="../assets/js/modernizr.min.js"></script>
</head>
<body class="min-h-screen bg-gray-100 ">
    <?php include('../includes/topheader.php'); ?>
    
    <div id="wrapper" class="min-h-screen flex">
        <div id="toggleContent">
            <?php include('../includes/leftsidebar.php'); ?>
        </div>

        <div class="content flex-1 p-6">
            <div class="container mx-auto">
                <div class="text-xl font-semibold mb-4">Add Post</div>
                <div class="bg-white p-6 rounded-lg shadow-md">
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

                    <form name="addpost" id="addPostForm" method="post" enctype="multipart/form-data">
                        <div class="mb-4">
                            <label class="block text-gray-700">Post Title</label>
                            <input type="text" class="mt-1 block w-full border border-gray-300 rounded-lg p-2" id="posttitle" name="posttitle" placeholder="Enter title">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700">Category</label>
                            <select class="mt-1 block w-full border border-gray-300 rounded-lg p-2" name="category" id="category" onChange="getSubCat(this.value);">
                                <option value="">Select Category</option>
                                <?php
                                // Fetching active categories
                                $ret = mysqli_query($con, "SELECT id, CategoryName FROM tblcategory WHERE Is_Active=1");
                                while($result = mysqli_fetch_array($ret)) {
                                ?>
                                    <option value="<?php echo htmlentities($result['id']); ?>"><?php echo htmlentities($result['CategoryName']); ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700">Sub Category</label>
                            <select class="w-full p-2 border border-gray-300 rounded" name="subcategory" id="subcategory">
                                <option value="">Select Sub Category</option>
                                <?php
                                $ret = mysqli_query($con, "SELECT SubCategoryId, Subcategory FROM tblsubcategory WHERE Is_Active=1");
                                while ($result = mysqli_fetch_array($ret)) {
                                ?>
                                    <option value="<?php echo htmlentities($result['SubCategoryId']); ?>"><?php echo htmlentities($result['Subcategory']); ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700">Post Details</label>
                            <textarea class="mt-1 block w-full border border-gray-300 rounded-lg p-2" name="postdescription" rows="5"></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700">Feature Image</label>
                            <input type="file" class="mt-1 block w-full border border-gray-300 rounded-lg p-2" id="postimage" name="postimage">
                        </div>

                        <div class="flex justify-end space-x-4">
                            <button type="submit" name="submit" class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">Save and Post</button>
                            <button type="button" class="bg-red-600 text-white py-2 px-4 rounded hover:bg-red-700">Discard</button>
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
        </div>
    </div>

    <script>
        document.getElementById('close-sidebar').addEventListener('click', function() {
            document.getElementById('right-sidebar').classList.add('hidden');
        });
        document.getElementById('toggleButton').addEventListener('click', function() {
            document.getElementById('toggleContent').classList.toggle('hidden');
        });

        document.getElementById('addPostForm').addEventListener('submit', function(event) {
            const posttitle = document.getElementById('posttitle').value.trim();
            const category = document.getElementById('category').value;
            const subcategory = document.getElementById('subcategory').value;
            const postdescription = document.querySelector('textarea[name="postdescription"]').value.trim();
            const postimage = document.getElementById('postimage').files.length;

            if (!posttitle || !category || !subcategory || !postdescription || !postimage) {
                event.preventDefault(); // Prevent form submission
                alert('Please fill in all fields and select an image.');
            }
        });
    </script>

    <!-- jQuery  -->
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/jquery.app.js"></script>
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
