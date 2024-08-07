<?php 
session_start();
include('../conn.php');
error_reporting(0);
if(strlen($_SESSION['login'])==0) { 
    header('location:index.php');
} else {
    if($_GET['action'] == 'restore') {
        $postid = intval($_GET['pid']);
        $query = mysqli_query($con, "UPDATE tblposts SET Is_Active=1 WHERE id='$postid'");
        if($query) {
            $msg = "Post restored successfully ";
        } else {
            $error = "Something went wrong. Please try again.";    
        } 
    }

    if($_GET['presid']) {
        $id = intval($_GET['presid']);
        $query = mysqli_query($con, "DELETE FROM tblposts WHERE id='$id'");
        $delmsg = "Post deleted forever";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <title>Newsportal | Manage Posts</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css">
    <script src="../assets/js/modernizr.min.js"></script>
   
</head>

<body class="bg-gray-100">
    <?php include('../includes/topheader.php'); ?>
    <div id="wrapper" class="flex flex-row min-h-screen">
        <div id="toggleContent">
            <?php include('../includes/leftsidebar.php'); ?>
        </div>
        <div class="flex-1 p-6 w-10/12 mx-auto">
            <div class="content">
                <div class="mb-6">
                    <div class="text-xl font-semibold mb-2">Trashed Posts</div>
                    <ol class="flex space-x-1.5 justify-end text-sm text-gray-500">
                        <li><a href="#" class="hover:text-gray-900">Admin</a></li>
                        <li><a href="#" class="hover:text-gray-900">Posts</a></li>
                        <li class="text-gray-900">Trashed Posts</li>
                    </ol>
                </div>
                <div class="mb-6">
                    <?php if($delmsg){ ?>
                        <div class="mb-4 p-3 rounded bg-red-200 text-red-800 border border-red-300">
                            <strong>Oh snap!</strong> <?php echo htmlentities($delmsg); ?>
                        </div>
                    <?php } ?>
                </div>
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead class="bg-blue-500 text-white">
                            <tr>
                                <th class="border border-gray-200 px-4 py-2">Title</th>
                                <th class="border border-gray-200 px-4 py-2">Category</th>
                                <th class="border border-gray-200 px-4 py-2">Subcategory</th>
                                <th class="border border-gray-200 px-4 py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = mysqli_query($con, "SELECT tblposts.id AS postid, tblposts.PostTitle AS title, tblcategory.CategoryName AS category, tblsubcategory.Subcategory AS subcategory FROM tblposts LEFT JOIN tblcategory ON tblcategory.id = tblposts.CategoryId LEFT JOIN tblsubcategory ON tblsubcategory.SubCategoryId = tblposts.SubCategoryId WHERE tblposts.Is_Active = 0");
                            $rowcount = mysqli_num_rows($query);
                            if($rowcount == 0) {
                            ?>
                            <tr>
                                <td colspan="4" class="text-center py-4 text-red-600">No record found</td>
                            </tr>
                            <?php 
                            } else {
                                while($row = mysqli_fetch_array($query)) {
                            ?>
                            <tr>
                                <td class="border border-gray-200 px-4 py-2"><?php echo htmlentities($row['title']); ?></td>
                                <td class="border border-gray-200 px-4 py-2"><?php echo htmlentities($row['category']); ?></td>
                                <td class="border border-gray-200 px-4 py-2"><?php echo htmlentities($row['subcategory']); ?></td>
                                <td class="border border-gray-200 px-4 py-2">
                                    <a href="trash-posts.php?pid=<?php echo htmlentities($row['postid']); ?>&&action=restore" class="text-blue-500 hover:text-blue-700"><i class="fa fa-undo" title="Restore this Post"></i></a>
                                    <a href="trash-posts.php?presid=<?php echo htmlentities($row['postid']); ?>&&action=perdel" class="text-red-500 hover:text-red-700 ml-2"><i class="fa fa-trash" title="Permanently delete this post"></i></a>
                                </td>
                            </tr>
                            <?php } }?>
                        </tbody>
                    </table>
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

        <script>
            var resizefunc = [];
        </script>

        <script src="../assets/js/jquery.min.js"></script>
        <script src="../assets/js/jquery.app.js"></script>
 
</body>
</html>
<?php } ?>
