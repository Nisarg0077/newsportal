<?php
session_start();
include('../conn.php');
error_reporting(0);
if(strlen($_SESSION['login'])==0)
  { 
header('location:index.php');
}
else{
if( $_GET['disid'])
{
	$id=intval($_GET['disid']);
	$query=mysqli_query($con,"update tblcomments set status='0' where id='$id'");
	$msg="Comment unapprove ";
}
// Code for restore
if($_GET['appid'])
{
	$id=intval($_GET['appid']);
	$query=mysqli_query($con,"update tblcomments set status='1' where id='$id'");
	$msg="Comment approved";
}

// Code for deletion
if($_GET['action']=='del' && $_GET['rid'])
{
	$id=intval($_GET['rid']);
	$query=mysqli_query($con,"delete from  tblcomments  where id='$id'");
	$delmsg="Comment deleted forever";
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Manage Categories</title>
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css">
    <script src="../assets/js/modernizr.min.js"></script>
    </head>
    <body class="bg-gray-100">

    <?php include('../includes/topheader.php'); ?>
 
    <div id="wrapper" class="flex flex-row min-h-screen">
     
        <div id="toggleContent" class="w-64 bg-white shadow-md">
            <?php include('../includes/leftsidebar.php'); ?>
        </div>

        <div class="content-page flex-1 p-6">
         
                <div class="container mx-auto">

                    <div class="mb-4">
                        <div class="page-title-box">
                            <h4 class="text-xl font-semibold mb-2">Manage Unapproved Comments</h4>
                            <ol class="flex space-x-1.5 justify-end text-sm text-gray-500">
                                <li><a href="#" class="hover:text-gray-900">Admin /</a></li>
                                <li><a href="#" class="hover:text-gray-900">Comments /</a></li>
                                <li class="text-gray-900">Unapprove Comments</li>
                            </ol>
                        </div>
                    </div>

                    <!-- Messages Section -->
                    <div class="mb-4">
                            <?php if($msg){ ?>
                            <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                                <strong>Well done!</strong> <?php echo htmlentities($msg); ?>
                            </div>
                            <?php } ?>

                            <?php if($delmsg){ ?>
                            <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                                <strong>Oh snap!</strong> <?php echo htmlentities($delmsg); ?>
                            </div>
                            <?php } ?>
                    </div>

                    <!-- Comments Table -->
                    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
    <table class="min-w-full bg-white border border-gray-200">
        <thead>
            <tr class="bg-blue-600 text-white">
                <th class="px-4 py-3 text-left text-sm font-semibold border border-gray-300">#</th>
                <th class="px-4 py-3 text-left text-sm font-semibold border border-gray-300">Name</th>
                <th class="px-4 py-3 text-left text-sm font-semibold border border-gray-300">Email Id</th>
                <th class="px-4 py-3 text-left text-sm font-semibold border border-gray-300">Comment</th>
                <th class="px-4 py-3 text-left text-sm font-semibold border border-gray-300">Status</th>
                <th class="px-4 py-3 text-left text-sm font-semibold border border-gray-300">Post / News</th>
                <th class="px-4 py-3 text-left text-sm font-semibold border border-gray-300">Posting Date</th>
                <th class="px-4 py-3 text-left text-sm font-semibold border border-gray-300">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            <?php 
            $query = mysqli_query($con,"Select tblcomments.id, tblcomments.name,tblcomments.email,tblcomments.postingDate,tblcomments.comment,tblposts.id as postid,tblposts.PostTitle from tblcomments join tblposts on tblposts.id=tblcomments.postId where tblcomments.status=0");
            $cnt = 1;
            $rowcount = mysqli_num_rows($query);
                            if($rowcount == 0) {
                            ?>
                            <tr>
                                <td colspan="8" class="text-center py-4 text-red-600">No record found</td>
                            </tr>
                            <?php 
                            } else {
            while($row = mysqli_fetch_array($query)) {
            ?>

            
            <tr class="hover:bg-gray-50">
                <th scope="row" class="px-4 py-2 border border-gray-300"><?php echo htmlentities($cnt);?></th>
                <td class="px-4 py-2 border border-gray-300"><?php echo htmlentities($row['name']);?></td>
                <td class="px-4 py-2 border border-gray-300"><?php echo htmlentities($row['email']);?></td>
                <td class="px-4 py-2 border border-gray-300"><?php echo htmlentities($row['comment']);?></td>
                <td class="px-4 py-2 border border-gray-300">
                    <?php $st = $row['status'];
                    echo $st == '0' ? 'Waiting for approval' : 'Approved';
                    ?>
                </td>
                <td class="px-4 py-2 border border-gray-300">
                    <a href="edit-post.php?pid=<?php echo htmlentities($row['postid']);?>" class="text-blue-600 hover:underline"><?php echo htmlentities($row['PostTitle']);?></a>
                </td>
                <td class="px-4 py-2 border border-gray-300"><?php echo htmlentities($row['postingDate']);?></td>
                <td class="px-4 py-2 border border-gray-300 flex space-x-4">
                    <?php if($st == 0) { ?>
                        <a href="unapprove-comment.php?appid=<?php echo htmlentities($row['id']);?>" title="Approve this comment" class="text-blue-600 hover:text-blue-800">
                            <i class="fa-solid fa-arrows-rotate"></i>
                        </a>
                    <?php } ?>
                    <a href="unapprove-comment.php?rid=<?php echo htmlentities($row['id']);?>&&action=del" class="text-red-600 hover:text-red-800">
                        <i class="fa fa-trash"></i>
                    </a>
                </td>
            </tr>
            <?php $cnt++; } }?>
        </tbody>
    </table>
</div>

                </div> <!-- container -->
            </div> <!-- content -->
        </div>
    </div> <!-- wrapper -->
        <?php include('../includes/footer.php');?>
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
</html><?php }?>
