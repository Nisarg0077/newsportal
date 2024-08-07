<?php 
session_start();
include('../conn.php');
error_reporting(0);

if(strlen($_SESSION['login']) == 0) { 
    header('location:index.php');
    exit;
} 

if(isset($_POST['update'])) {
    $posttitle = $_POST['posttitle'];
    $catid = $_POST['category'];
    $subcatid = $_POST['subcategory'];
    $postdetails = addslashes($_POST['postdescription']);
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

    <script>
        async function getSubCat(val) {
            const response = await fetch('get_subcategory.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({ 'catid': val })
            });
            const data = await response.text();
            document.getElementById('subcategory').innerHTML = data;
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
                $row = mysqli_fetch_array($query);
                ?>
                <!-- Post Edit Form -->
                <form name="addpost" method="post" class="bg-white p-6 rounded-lg shadow-lg">
                    <input type="hidden" name="postid" value="<?php echo htmlentities($row['postid']); ?>">

                    <div class="mb-4">
                        <label for="posttitle" class="block text-gray-700">Post Title</label>
                        <input type="text" class="mt-1 block w-full border border-gray-300 rounded-lg p-2" id="posttitle" name="posttitle" value="<?php echo htmlentities($row['title']); ?>" placeholder="Enter title" required>
                    </div>

                    <div class="mb-4">
                        <label for="category" class="block text-gray-700">Category</label>
                        <select class="mt-1 block w-full border border-gray-300 rounded-lg p-2" name="category" id="category" onChange="getSubCat(this.value);" required>
                            <option value="<?php echo htmlentities($row['catid']); ?>"><?php echo htmlentities($row['category']); ?></option>
                            <?php
                            $ret = mysqli_query($con, "SELECT id, CategoryName FROM tblcategory WHERE Is_Active = 1");
                            while($result = mysqli_fetch_array($ret)) {
                            ?>
                            <option value="<?php echo htmlentities($result['id']); ?>"><?php echo htmlentities($result['CategoryName']); ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="subcategory" class="block text-gray-700">Sub Category</label>
                        <select class="mt-1 block w-full border border-gray-300 rounded-lg p-2" name="subcategory" id="subcategory" required>
                            <option value="<?php echo htmlentities($row['subcatid']); ?>"><?php echo htmlentities($row['subcategory']); ?></option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="postdescription" class="block text-gray-700">Post Details</label>
                        <textarea class="mt-1 block w-full border border-gray-300 rounded-lg p-2" name="postdescription" rows="5" required><?php echo htmlentities($row['PostDetails']); ?></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Post Image</label>
                        <img src="postimages/<?php echo htmlentities($row['PostImage']); ?>" width="300" class="mb-2" />
                        <br />
                        <a href="change-image.php?pid=<?php echo htmlentities($row['postid']); ?>" class="text-blue-600">Update Image</a>
                    </div>

                    <div class="flex justify-end space-x-4">
                        <button type="submit" name="update" class="bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700">Update</button>
                        <a href="post-list.php" class="bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700">Discard</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include('../includes/footer.php'); ?>
</div>
</body>
</html>
