<?php
session_start();
include('../conn.php');
error_reporting(0);
if(strlen($_SESSION['login'])==0) { 
    header('location:index.php');
} else {

    // Code for Forever deletion
    if($_GET['action']=='del' && $_GET['rid']) {
        $id = intval($_GET['rid']);
        $query = mysqli_query($con, "DELETE FROM tbladmin WHERE id='$id' AND userType=0");
        echo "<script>alert('Sub-admin details deleted.');</script>";
        echo "<script type='text/javascript'> document.location = 'manage-subadmins.php'; </script>";
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Subadmins</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css">
    <script src="../assets/js/modernizr.min.js"></script>
</head>

<body class="bg-gray-100">

    <?php include('../includes/topheader.php'); ?>

    <div id="wrapper" class="flex min-h-screen">

        <div id="toggleContent">
            <?php include('../includes/leftsidebar.php'); ?>
        </div>

        <div class="flex-1 p-6">
            <div class="container mx-auto">
                <div class="mb-6">
                    <div class="text-xl font-semibold mb-2">Manage Sub-admins</div>
                    <ol class="flex space-x-1.5 justify-end text-sm text-gray-500">
                        <li><a href="./admin.php" class="hover:text-gray-900">Admin /</a></li>
                        <li><a href="" class="hover:text-gray-900">Sub-admins /</a></li>
                        <li class="text-gray-900">Manage Sub-admins</li>
                    </ol>
                </div>

                <!-- Messages -->
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

                <div class="mb-4">
                    <a href="add-subadmins.php">
                        <button class="bg-green-500 text-white px-4 py-2 rounded shadow-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">
                            Add <i class="mdi mdi-plus-circle-outline"></i>
                        </button>
                    </a>
                </div>

                <div class="bg-white shadow overflow-hidden">
                <table class="min-w-full bg-white border border-gray-200">
    <thead class="bg-blue-500 text-white">
        <tr>
            <th class="border border-gray-200 px-4 py-2">#</th>
            <th class="border border-gray-200 px-4 py-2">Username</th>
            <th class="border border-gray-200 px-4 py-2">Email</th>
            <th class="border border-gray-200 px-4 py-2">Posting Date</th>
            <th class="border border-gray-200 px-4 py-2">Last Update</th>
            <th class="border border-gray-200 px-4 py-2">Action</th>
        </tr>
    </thead>
    <tbody class="bg-white">
        <?php 
        $query = mysqli_query($con, "SELECT * FROM tbladmin WHERE userType=0");
        $cnt = 1;
        while($row = mysqli_fetch_array($query)) {
        ?>
        <tr>
            <td class="border border-gray-200 px-4 py-2"><?php echo htmlentities($cnt);?></td>
            <td class="border border-gray-200 px-4 py-2"><?php echo htmlentities($row['AdminUserName']);?></td>
            <td class="border border-gray-200 px-4 py-2"><?php echo htmlentities($row['AdminEmailId']);?></td>
            <td class="border border-gray-200 px-4 py-2"><?php echo htmlentities($row['CreationDate']);?></td>
            <td class="border border-gray-200 px-4 py-2"><?php echo htmlentities($row['UpdationDate']);?></td>
            <td class="border border-gray-200 px-4 py-2">
                <a href="edit-subadmin.php?said=<?php echo htmlentities($row['id']);?>" class="text-blue-500 hover:text-blue-700">
                    <i class="fa fa-pencil"></i>
                </a> 
                &nbsp;
                <a href="manage-subadmins.php?rid=<?php echo htmlentities($row['id']);?>&&action=del" class="text-red-500 hover:text-red-700">
                    <i class="fa fa-trash"></i>
                </a>
            </td>
        </tr>
        <?php
        $cnt++;
        } 
        ?>
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

        <!-- jQuery  -->
        <script src="../assets/js/jquery.min.js"></script>
 
        <script src="../assets/js/jquery.app.js"></script>
   
</body>
</html>
<?php } ?>
