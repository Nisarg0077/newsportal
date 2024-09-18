<?php
session_start();
include('../conn.php');
error_reporting(0);
if(strlen($_SESSION['login'])==0) { 
    header('location:index.php');
} else {
    if ($_GET['disid']) {
        $id = intval($_GET['disid']);
        $query = mysqli_query($con, "UPDATE tblcomments SET status='0' WHERE id='$id'");
        $msg = "Comment unapproved";
    }

    if ($_GET['appid']) {
        $id = intval($_GET['appid']);
        $query = mysqli_query($con, "UPDATE tblcomments SET status='1' WHERE id='$id'");
        $msg = "Comment approved";
    }

    if ($_GET['action'] == 'del' && $_GET['rid']) {
        $id = intval($_GET['rid']);
        $query = mysqli_query($con, "DELETE FROM tblcomments WHERE id='$id'");
        $delmsg = "Comment deleted forever";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Comments</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css">
    <script src="../assets/js/modernizr.min.js"></script>
</head>
<body class="bg-gray-100">

    <?php include('../includes/topheader.php'); ?>
    <!-- Begin page -->
    <div id="wrapper" class="flex flex-row min-h-screen">

    <div id="toggleContent">
            <?php include('../includes/leftsidebar.php'); ?>
        </div>
        <div class="flex-1 p-4">
            <div class="container mx-auto">

                <div class="mb-4">
                    <h4 class="text-xl font-semibold mb-2">Manage Approved Comments</h4>
                    <ol class="flex space-x-1.5 justify-end text-sm text-gray-500">
                        <li><a href="#" class="hover:text-gray-900">Admin /</a></li>
                        <li><a href="#" class="hover:text-gray-900">Comments /</a></li>
                        <li class="text-gray-900">Approved Comments</li>
                    </ol>
                </div>

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

                <div class="bg-white shadow-md rounded-lg ">
                    <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-300">
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
                                $query = mysqli_query($con, "SELECT tblcomments.id, tblcomments.name, tblcomments.email, tblcomments.postingDate, tblcomments.comment, tblposts.id as postid, tblposts.PostTitle FROM tblcomments JOIN tblposts ON tblposts.id = tblcomments.postId WHERE tblcomments.status=1");
                                $cnt = 1;
                                while($row = mysqli_fetch_array($query)) {
                                ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-2 border text-sm border-gray-300"><?php echo htmlentities($cnt); ?></td>
                                    <td class="px-2  border text-sm border-gray-300"><?php echo htmlentities($row['name']); ?></td>
                                    <td class="px-2  border text-sm border-gray-300"><?php echo htmlentities($row['email']); ?></td>
                                    <td class="px-2  border text-sm border-gray-300">
                                        <?php echo htmlentities($row['comment']); ?>
                                    </td>
                                    <td class="px-2 py-2 border text-sm border-gray-300">
                                        <?php $st = $row['status'];
                                        if($st == '0') {
                                            echo "Waiting for approval";
                                        } else {
                                            echo "Approved";
                                        }
                                        ?>
                                    </td>
                                    <td class="px-2  border text-sm border-gray-300"><a href="edit-post.php?pid=<?php echo htmlentities($row['postid']); ?>" class="text-blue-600 hover:underline"><?php echo htmlentities($row['PostTitle']); ?></a></td>
                                    <td class="px-2  border text-sm border-gray-300"><?php echo htmlentities($row['postingDate']); ?></td>
                                    <td class="px-2 flex space-x-4">
                                        <?php if($st == 0) { ?>
                                            <a href="manage-comments.php?disid=<?php echo htmlentities($row['id']); ?>" title="Disapprove this comment" class="text-blue-600 hover:text-blue-800">
                                                <i class="fa-solid fa-arrows-rotate"></i>
                                            </a>
                                        <?php } else { ?>
                                            <a href="manage-comments.php?appid=<?php echo htmlentities($row['id']); ?>" title="Approve this comment" class="text-blue-600 hover:text-blue-800">
                                                <i class="fa-solid fa-arrows-rotate"></i>
                                            </a>
                                        <?php } ?>
                                        <a href="manage-comments.php?rid=<?php echo htmlentities($row['id']); ?>&&action=del" class="text-red-600 hover:text-red-800">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php $cnt++; } ?>
                            </tbody>
                        </table>

                    </div>
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
