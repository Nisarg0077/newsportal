<?php 
session_start();
include('../conn.php');
error_reporting(0);
if(strlen($_SESSION['login'])==0)
{ 
    header('location:index.php');
}
else{
if(isset($_POST['update']))
{
    $imgfile=$_FILES["postimage"]["name"];
    // Get the image extension
    $extension = substr($imgfile, strlen($imgfile) - 4, strlen($imgfile));
    // Allowed extensions
    $allowed_extensions = array(".jpg", ".jpeg", ".png", ".gif");
    // Validation for allowed extensions
    if(!in_array($extension, $allowed_extensions))
    {
        echo "<script>alert('Invalid format. Only jpg / jpeg / png / gif format allowed');</script>";
    }
    else
    {
        // Rename the image file
        $imgnewfile = md5($imgfile) . $extension;
        // Move image into directory
        move_uploaded_file($_FILES["postimage"]["tmp_name"], "postimages/" . $imgnewfile);

        $postid = intval($_GET['pid']);
        $query = mysqli_query($con, "UPDATE tblposts SET PostImage='$imgnewfile' WHERE id='$postid'");
        if($query)
        {
            $msg = "Post Feature Image updated";
        }
        else
        {
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

    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css">
    <script src="../assets/js/modernizr.min.js"></script>
</head>
<body class="bg-gray-100">

    <?php include('../includes/topheader.php');?>
    <!-- Begin page -->
    <div id="wrapper" class="flex">


    <div id="toggleContent">
            <?php include('../includes/leftsidebar.php'); ?>
        </div>
       <div class="flex-1 p-6">
            <!-- Start content -->
            <div class="container mx-auto">
                <div class="mb-6">
                    <div class="text-xl font-semibold mb-2">Update Image</div>
                    <ol class="flex space-x-1.5 justify-end text-sm text-gray-500">
                        <li><a href="#" class="text-gray-600">Admin /</a></li>
                        <li><a href="#" class="text-gray-600">Posts /</a></li>
                        <li><a href="#" class="text-gray-600">Edit Posts /</a></li>
                        <li class="text-gray-500">Update Image</li>
                    </ol>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md">
                    <!-- Success Message -->
                    <?php if($msg): ?>
                        <div class="mb-4 p-3 bg-green-100 text-green-800 border border-green-300 rounded">
                            <strong>Well done!</strong> <?php echo htmlentities($msg); ?>
                        </div>
                    <?php endif; ?>

                    <!-- Error Message -->
                    <?php if($error): ?>
                        <div class="mb-4 p-3 bg-red-100 text-red-800 border border-red-300 rounded">
                            <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                        </div>
                    <?php endif; ?>

                    <form name="updateImage" method="post" enctype="multipart/form-data">
                        <?php
                        $postid = intval($_GET['pid']);
                        $query = mysqli_query($con, "SELECT PostImage, PostTitle FROM tblposts WHERE id='$postid' AND Is_Active=1");
                        while($row = mysqli_fetch_array($query))
                        {
                        ?>
                        <div class="mb-6">
                            <label for="posttitle" class="block text-gray-700 font-semibold">Post Title</label>
                            <input type="text" class="mt-1 block w-full border border-gray-300 rounded-lg p-2" id="posttitle" value="<?php echo htmlentities($row['PostTitle']); ?>" name="posttitle" readonly>
                        </div>

                        <div class="mb-6">
                            <h4 class="text-lg font-semibold mb-2">Current Post Image</h4>
                            <img src="postimages/<?php echo htmlentities($row['PostImage']); ?>" class="w-80 h-auto border border-gray-200 rounded-lg" alt="Current Post Image" />
                        </div>

                        <div class="mb-6">
                            <label for="postimage" class="block text-gray-700 font-semibold">New Feature Image</label>
                            <input type="file" class="mt-1 block w-full border border-gray-300 rounded-lg p-2" id="postimage" name="postimage" required>
                        </div>

                        <button type="submit" name="update" class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">Update</button>
                        <?php } ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php include('../includes/footer.php');?>

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
