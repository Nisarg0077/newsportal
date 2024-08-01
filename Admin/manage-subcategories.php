<?php
session_start();
include('../conn.php');
error_reporting(0);
if(strlen($_SESSION['login'])==0) { 
    header('location:index.php');
} else {
    if($_REQUEST['action']=='del' && $_REQUEST['scid']) {
        $id=intval($_REQUEST['scid']);
        $query=mysqli_query($con,"update tblsubcategory set Is_Active='0' where SubCategoryId='$id'");
        $msg="Category deleted ";
    }
    if($_REQUEST['resid']) {
        $id=intval($_REQUEST['resid']);
        $query=mysqli_query($con,"update tblsubcategory set Is_Active='1' where SubCategoryId='$id'");
        $msg="Category restored successfully";
    }
    if($_REQUEST['action']=='perdel' && $_REQUEST['scid']) {
        $id=intval($_GET['scid']);
        $query=mysqli_query($con,"delete from tblsubcategory where SubCategoryId='$id'");
        $delmsg="Category deleted forever";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage SubCategories</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css">
    <!-- <script src="../assets/js/modernizr.min.js"></script> -->
</head>
<body class="bg-gray-100 min-w-full sm:min-w-full">
    <?php include('../includes/topheader.php'); ?>
    <div id="wrapper" class="flex flex-row min-h-screen">
        <div id="toggleContent">
            <?php include('../includes/leftsidebar.php'); ?>
        </div>
        <div class="content-page w-10/12">
            <div class="content">
                <div class="container mx-auto p-6">
                    <div class="row mb-6">
                        <div class="col-xs-12">
                            <div class="mb-6">
                                <div class="text-xl font-semibold mb-2">Manage SubCategory</div>
                                <ol class="flex space-x-1.5 justify-end text-sm text-gray-500">
                                    <li><a href="./admin.php" class="hover:text-gray-900">Admin /</a></li>
                                    <li><a href="#" class="hover:text-gray-900">SubCategory /</a></li>
                                    <li class="text-gray-900">Manage SubCategory</li>
                                </ol>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-6">
                        <div class="col-sm-6">
                            <?php if($msg){ ?>
                                <div class="mb-4 p-3 rounded bg-green-200 text-green-800 border border-green-300">
                                    <strong>Well done!</strong> <?php echo htmlentities($msg); ?>
                                </div>
                            <?php } ?>
                            <?php if($delmsg){ ?>
                                <div class="mb-4 p-3 rounded bg-red-200 text-red-800 border border-red-300">
                                    <strong>Oh snap!</strong> <?php echo htmlentities($delmsg); ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="row mb-6">
                        <div class="col-md-12">
                            <div class="demo-box mt-5">
                                <div class="mb-4">
                                    <a href="add-subcategory.php">
                                        <button id="addToTable" class="btn btn-success waves-effect waves-light bg-green-500 text-white py-2 px-4 rounded">Add <i class="mdi mdi-plus-circle-outline"></i></button>
                                    </a>
                                </div>
                                <div class="table-responsive">
                                    <table class="min-w-full bg-white border border-gray-200">
                                        <thead class="bg-blue-500 text-white">
                                            <tr>
                                                <th class="border border-gray-200 px-4 py-2">#</th>
                                                <th class="border border-gray-200 px-4 py-2">Category</th>
                                                <th class="border border-gray-200 px-4 py-2">Sub Category</th>
                                                <th class="border border-gray-200 px-4 py-2">Description</th>
                                                <th class="border border-gray-200 px-4 py-2">Posting Date</th>
                                                <th class="border border-gray-200 px-4 py-2">Last Update Date</th>
                                                <th class="border border-gray-200 px-4 py-2">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $query=mysqli_query($con,"Select tblcategory.CategoryName as catname,tblsubcategory.Subcategory as subcatname,tblsubcategory.SubCatDescription as SubCatDescription,tblsubcategory.PostingDate as subcatpostingdate,tblsubcategory.UpdationDate as subcatupdationdate,tblsubcategory.SubCategoryId as subcatid from tblsubcategory join tblcategory on tblsubcategory.CategoryId=tblcategory.id where tblsubcategory.Is_Active=1");
                                            $cnt=1;
                                            $rowcount=mysqli_num_rows($query);
                                            if($rowcount==0) {
                                            ?>
                                                <tr>
                                                    <td colspan="7" class="text-center py-4 text-red-600">No record found</td>
                                                </tr>
                                            <?php 
                                            } else {
                                                while($row=mysqli_fetch_array($query)) {
                                            ?>
                                                <tr>
                                                    <th scope="row" class="border border-gray-200 px-4 py-2"><?php echo htmlentities($cnt);?></th>
                                                    <td class="border border-gray-200 px-4 py-2"><?php echo htmlentities($row['catname']);?></td>
                                                    <td class="border border-gray-200 px-4 py-2"><?php echo htmlentities($row['subcatname']);?></td>
                                                    <td class="border border-gray-200 px-4 py-2"><?php echo htmlentities($row['SubCatDescription']);?></td>
                                                    <td class="border border-gray-200 px-4 py-2"><?php echo htmlentities($row['subcatpostingdate']);?></td>
                                                    <td class="border border-gray-200 px-4 py-2"><?php echo htmlentities($row['subcatupdationdate']);?></td>
                                                    <td class="border border-gray-200 px-4 py-2">
                                                        <a href="edit-subcategory.php?scid=<?php echo htmlentities($row['subcatid']);?>" class="text-blue-500"><i class="fa fa-pencil"></i></a>
                                                        &nbsp;<a href="manage-subcategories.php?scid=<?php echo htmlentities($row['subcatid']);?>&&action=del" class="text-red-500"><i class="fa fa-trash"></i></a>
                                                    </td>
                                                </tr>
                                            <?php
                                                    $cnt++;
                                                }
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-6">
                        <div class="col-md-12">
                            <div class="demo-box mt-5">
                                <div class="mb-4">
                                    <h4 class="text-xl font-semibold"><i class="fa fa-trash"></i> Deleted SubCategories</h4>
                                </div>
                                <div class="table-responsive">
                                    <table class="min-w-full bg-white border border-gray-200">
                                        <thead class="bg-red-500 text-white">
                                            <tr>
                                                <th class="border border-gray-200 px-4 py-2">#</th>
                                                <th class="border border-gray-200 px-4 py-2">Category</th>
                                                <th class="border border-gray-200 px-4 py-2">Sub Category</th>
                                                <th class="border border-gray-200 px-4 py-2">Description</th>
                                                <th class="border border-gray-200 px-4 py-2">Posting Date</th>
                                                <th class="border border-gray-200 px-4 py-2">Last Update Date</th>
                                                <th class="border border-gray-200 px-4 py-2">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $query=mysqli_query($con,"Select tblcategory.CategoryName as catname,tblsubcategory.Subcategory as subcatname,tblsubcategory.SubCatDescription as SubCatDescription,tblsubcategory.PostingDate as subcatpostingdate,tblsubcategory.UpdationDate as subcatupdationdate,tblsubcategory.SubCategoryId as subcatid from tblsubcategory join tblcategory on tblsubcategory.CategoryId=tblcategory.id where tblsubcategory.Is_Active=0");
                                            $cnt=1;
                                            $rowcount=mysqli_num_rows($query);
                                            if($rowcount==0) {
                                            ?>
                                                <tr>
                                                    <td colspan="7" class="text-center py-4 text-red-600">No record found</td>
                                                </tr>
                                            <?php 
                                            } else {
                                                while($row=mysqli_fetch_array($query)) {
                                            ?>
                                                <tr>
                                                    <th scope="row" class="border border-gray-200 px-4 py-2"><?php echo htmlentities($cnt);?></th>
                                                    <td class="border border-gray-200 px-4 py-2"><?php echo htmlentities($row['catname']);?></td>
                                                    <td class="border border-gray-200 px-4 py-2"><?php echo htmlentities($row['subcatname']);?></td>
                                                    <td class="border border-gray-200 px-4 py-2"><?php echo htmlentities($row['SubCatDescription']);?></td>
                                                    <td class="border border-gray-200 px-4 py-2"><?php echo htmlentities($row['subcatpostingdate']);?></td>
                                                    <td class="border border-gray-200 px-4 py-2"><?php echo htmlentities($row['subcatupdationdate']);?></td>
                                                    <td class="border border-gray-200 px-4 py-2">
                                                        <a href="manage-subcategories.php?scid=<?php echo htmlentities($row['subcatid']);?>&&resid=<?php echo htmlentities($row['subcatid']);?>" class="text-blue-500"><i class="fa-solid fa-arrows-rotate"></i></a>
                                                        &nbsp;<a href="manage-subcategories.php?scid=<?php echo htmlentities($row['subcatid']);?>&&action=perdel" class="text-red-500"><i class="fa fa-trash"></i></a>
                                                    </td>
                                                </tr>
                                            <?php
                                                    $cnt++;
                                                }
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
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
