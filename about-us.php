<?php
include('./conn.php');
?>
<!DOCTYPE html>
<html lang="en">
    
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        
        <title>News Portal | About us</title>
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <link rel="stylesheet" href="https://cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css">
        <script src="../assets/js/modernizr.min.js"></script>
</head>

<body class="h-screen">
    <?php include('./includes/header.php'); ?>
    <div class="container mx-auto px-4 h-screen mt-0 p-0">
        <?php
        $pagetype = 'aboutus';
        $query = mysqli_query($con, "SELECT PageTitle, Description FROM tblpages WHERE PageName='$pagetype'");
        while ($row = mysqli_fetch_array($query)) {
        ?>
            <h1 class="mt-2 mb-3 text-4xl font-bold text-center"><?php echo htmlentities($row['PageTitle']) ?>
            </h1>

            <nav class="text-gray-700">
                <ol class="list-reset flex">
                    <li><a href="index.php" class="text-blue-600 hover:text-blue-800">Home</a></li>
                    <li class="mx-2">/</li>
                    <li class="text-gray-500">About</li>
                </ol>
            </nav>

            <!-- Intro Content -->
            <div class="row mt-4">
                <div class="col-lg-12 ">
                    <?php echo ($row['Description']); ?>
                </div>
            </div>
            <!-- /.row -->
        <?php } ?>
    </div>
    <!-- /.container -->

    <!-- Footer -->
    <?php include('includes/footer.php'); ?>

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