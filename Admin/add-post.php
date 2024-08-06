<?php 
session_start();
include('../conn.php');
error_reporting(0);

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
        move_uploaded_file($_FILES["postimage"]["tmp_name"], "postimages/" . $imgnewfile);

        $status = 1;
        $query = mysqli_query($con, "INSERT INTO tblposts(PostTitle, CategoryId, SubCategoryId, PostDetails, PostUrl, Is_Active, PostImage, postedBy) VALUES('$posttitle', '$catid', '$subcatid', '$postdetails', '$url', '$status', '$imgnewfile', '$postedby')");
        
        if($query) {
            $msg = "Post successfully added";
        } else {
            $error = "Something went wrong. Please try again.";    
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
    <script>
        function getSubCat(val) {
            $.ajax({
                type: "POST",
                url: "get_subcategory.php",
                data: 'catid=' + val,
                success: function(data) {
                    $("#subcategory").html(data);
                }
            });
        }
    </script>
</head>
<body class="bg-gray-100">
    <?php include('../includes/topheader.php'); ?>
    
    <div id="wrapper" class="flex">
    <div id="toggleContent">
            <?php include('../includes/leftsidebar.php'); ?>
        </div>

        <div class="content flex-1 p-6">
            <div class="container mx-auto">
                <div class="text-xl font-semibold mb-4">Add Post</div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <?php if($msg): ?>
                        <div class="mb-4 p-3 bg-green-100 text-green-800 border border-green-300 rounded">
                            <strong>Well done!</strong> <?php echo htmlentities($msg); ?>
                        </div>
                    <?php endif; ?>

                    <?php if($error): ?>
                        <div class="mb-4 p-3 bg-red-100 text-red-800 border border-red-300 rounded">
                            <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                        </div>
                    <?php endif; ?>

                    <form name="addpost" method="post" enctype="multipart/form-data">
                        <div class="mb-4">
                            <label class="block text-gray-700">Post Title</label>
                            <input type="text" class="mt-1 block w-full border border-gray-300 rounded-lg p-2" id="posttitle" name="posttitle" placeholder="Enter title" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700">Category</label>
                            <select class="mt-1 block w-full border border-gray-300 rounded-lg p-2" name="category" id="category" onChange="getSubCat(this.value);" required>
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
                            <select class="w-full p-2 border border-gray-300 rounded" name="subcategory" required>
                                        <option value="">Select Category</option>
                                        <?php
                                        // Fetching active categories
                                        $ret = mysqli_query($con, "select CategoryId,Subcategory from tblsubcategory where Is_Active=1");
                                        while ($result = mysqli_fetch_array($ret)) {
                                        ?>
                                            <option value="<?php echo htmlentities($result['CategoryId']); ?>"><?php echo htmlentities($result['Subcategory']); ?></option>
                                        <?php } ?>
                                    </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700">Post Details</label>
                            <textarea class="mt-1 block w-full border border-gray-300 rounded-lg p-2" name="postdescription" rows="5" required></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700">Feature Image</label>
                            <input type="file" class="mt-1 block w-full border border-gray-300 rounded-lg p-2" id="postimage" name="postimage" required>
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
