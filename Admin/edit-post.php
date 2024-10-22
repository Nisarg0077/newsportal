<?php
session_start();
include('../conn.php'); // Ensure this uses mysqli_* for modern compatibility

error_reporting(0);

if(strlen($_SESSION['login']) == 0) { 
    header('location:index.php');
    exit;
}

if(isset($_POST['update'])) {
    $posttitle = mysqli_real_escape_string($con, $_POST['posttitle']);
    $catid = intval($_POST['category']);
    $subcatid = intval($_POST['subcategory']);
    $postdetails = mysqli_real_escape_string($con, $_POST['postdescription']); // Use mysqli_real_escape_string for safety
    $lastuptdby = mysqli_real_escape_string($con, $_SESSION['login']);
    $arr = explode(" ", $posttitle);
    $url = implode("-", $arr);
    $status = 1;
    $postid = intval($_GET['pid']);

    // Prepare your update query
    $query = "UPDATE tblposts SET PostTitle='$posttitle', CategoryId='$catid', SubCategoryId='$subcatid', PostDetails='$postdetails', PostUrl='$url', Is_Active='$status', lastUpdatedBy='$lastuptdby' WHERE id='$postid'";

    // Execute the query
    if (mysqli_query($con, $query)) {
        $msg = "Post updated successfully";
    } else {
        $error = "Something went wrong. Please try again: " . mysqli_error($con);
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
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css">
    <script src="../assets/js/modernizr.min.js"></script>
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
                        <li><a href="#" class="text-gray-600">Admin /</a></li>
                        <li><a href="#" class="text-gray-600">Posts /</a></li>
                        <li class="text-gray-500">Edit Post</li>
                    </ol>
                </div>

                <!-- Success/Error Messages -->
                <div class="mb-4">
                    <?php if(isset($msg)): ?>
                    <div class="bg-green-100 text-green-800 p-4 rounded-lg">
                        <strong>Well done!</strong> <?php echo htmlentities($msg); ?>
                    </div>
                    <?php endif; ?>
                    <?php if(isset($error)): ?>
                    <div class="bg-red-100 text-red-800 p-4 rounded-lg">
                        <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                    </div>
                    <?php endif; ?>
                </div>

                <?php
                $postid = intval($_GET['pid']);
                $query = "SELECT tblposts.id as postid, tblposts.PostImage, tblposts.PostTitle as title, tblposts.PostDetails, tblcategory.CategoryName as category, tblcategory.id as catid, tblsubcategory.SubCategoryId as subcatid, tblsubcategory.Subcategory as subcategory FROM tblposts LEFT JOIN tblcategory ON tblcategory.id = tblposts.CategoryId LEFT JOIN tblsubcategory ON tblsubcategory.SubCategoryId = tblposts.SubCategoryId WHERE tblposts.id = ? AND tblposts.Is_Active = 1";
                if ($stmt = $con->prepare($query)) {
                    $stmt->bind_param('i', $postid);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $row = $result->fetch_assoc();
                    $stmt->close();
                } else {
                    $error = "Database query preparation failed.";
                }
                ?>
                <!-- Post Edit Form -->
                <form id="editPostForm" method="post" class="bg-white p-6 rounded-lg shadow-lg">
                    <input type="hidden" name="postid" value="<?php echo htmlentities($row['postid']); ?>">

                    <div class="mb-4">
                        <label for="posttitle" class="block text-gray-700 text-lg font-bold">Post Title</label>
                        <input type="text" class="mt-1 block w-full border border-gray-300 rounded-lg p-2" id="posttitle" name="posttitle" value="<?php echo htmlentities($row['title']); ?>" placeholder="Enter title">
                    </div>

                    <div class="mb-4">
                        <label for="category" class="block text-gray-700 text-lg font-bold">Category</label>
                        <select class="mt-1 block w-full border border-gray-300 rounded-lg p-2" name="category" id="category">
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
                        <label for="subcategory" class="block text-gray-700 text-lg font-bold">Sub Category</label>
                        <select class="mt-1 block w-full border border-gray-300 rounded-lg p-2" name="subcategory" id="subcategory">
                            <option value="<?php echo htmlentities($row['subcatid']); ?>"><?php echo htmlentities($row['subcategory']); ?></option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="postdescription" class="block text-gray-700 text-lg font-bold">Post Details</label>
                        <textarea class="mt-1 block w-full border border-gray-300 rounded-lg p-2" name="postdescription" rows="5"><?php echo htmlentities($row['PostDetails']); ?></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-lg font-bold">Post Image</label>
                        <img src="postimages/<?php echo htmlentities($row['PostImage']); ?>" width="300" class="mb-2" />
                        <br />
                        <a href="change-image.php?pid=<?php echo htmlentities($row['postid']); ?>" class="text-white bg-blue-600 py-2 px-4 rounded">Update Image</a>
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

        // JavaScript validation
        document.getElementById('editPostForm').addEventListener('submit', function(event) {
            var posttitle = document.getElementById('posttitle').value.trim();
            var category = document.getElementById('category').value;
            var subcategory = document.getElementById('subcategory').value;
            var postdescription = document.querySelector('textarea[name="postdescription"]').value.trim();

            if (!posttitle || !category || !subcategory || !postdescription) {
                event.preventDefault(); // Prevent form submission
                alert('Please fill in all fields.');
            }
        });
    </script>

    <!-- jQuery -->
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/jquery.app.js"></script>
</body>
</html>
