<?php 
session_start();
include('../conn.php');
error_reporting(0);

if(strlen($_SESSION['login']) == 0) { 
    header('location:index.php');
} else {
    if(isset($_POST['update'])) {
        $pagetype = 'contactus';
        $pagetitle = $_POST['pagetitle'];
        $pagedetails = $_POST['pagedescription'];

        $query = mysqli_query($con, "UPDATE tblpages SET PageTitle='$pagetitle', Description='$pagedetails' WHERE PageName='$pagetype'");
        $msg = $query ? "Contact us page successfully updated" : "Something went wrong. Please try again.";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Newsportal | Contact us Page</title>
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote.min.css">
</head>

<body class="bg-gray-100">

    <?php include('../includes/topheader.php'); ?>

    <div id="wrapper" class="flex min-h-screen">
        <?php include('../includes/leftsidebar.php'); ?>

        <div class="flex-grow container mx-auto p-6">
            <div class="mb-6">
                <h1 class="text-xl font-semibold">Contact us Page</h1>
                <ol class="flex space-x-1.5 text-sm text-gray-500">
                    <li><a href="./admin.php" class="hover:text-gray-900">Pages /</a></li>
                    <li>Contact us</li>
                </ol>
            </div>

            <?php if(isset($msg)){ ?>
            <div class="mb-6 bg-<?php echo $query ? 'green' : 'red'; ?>-100 text-<?php echo $query ? 'green' : 'red'; ?>-700 p-4 rounded-lg shadow-md">
                <strong><?php echo $query ? 'Well done!' : 'Oh snap!'; ?></strong> <?php echo htmlentities($msg); ?>
            </div>
            <?php } ?>

            <?php 
            $query = mysqli_query($con, "SELECT PageTitle, Description FROM tblpages WHERE PageName='$pagetype'");
            $row = mysqli_fetch_array($query);
            ?>

            <div class="bg-white p-6 rounded-lg shadow-md">
                <form method="post">
                    <div class="mb-6">
                        <label for="pagetitle" class="block text-gray-700 text-sm font-bold mb-2">Page Title</label>
                        <input type="text" id="pagetitle" name="pagetitle" class="w-full p-2 border rounded focus:shadow-outline" value="<?php echo htmlentities($row['PageTitle'])?>" required>
                    </div>

                    <div class="mb-6">
                        <label for="pagedescription" class="block text-gray-700 text-sm font-bold mb-2">Page Details</label>
                        <textarea id="pagedescription" name="pagedescription" class="summernote w-full p-2 border rounded focus:shadow-outline" required><?php echo htmlentities($row['Description'])?></textarea>
                    </div>

                    <button type="submit" name="update" class="bg-green-500 hover:bg-green-700 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline">Update and Post</button>
                </form>
            </div>

        </div>
    </div>

    <?php include('../includes/footer.php'); ?>

    <!-- jQuery and Summernote scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.summernote').summernote({
                height: 240
            });
        });
    </script>
</body>
</html>
<?php } ?>
