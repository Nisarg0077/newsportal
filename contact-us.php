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

    <title>News Portal | Contact us</title>

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <link rel="stylesheet" href="https://cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css">
        <script src="../assets/js/modernizr.min.js"></script>
</head>

<body class="bg-gray-100">

    <!-- Navigation -->
    <?php include('includes/header.php');?>

    <!-- Page Content -->
    <div class="container mx-auto px-4 h-screen mt-0 p-0 text-center">

        <?php 
        $pagetype = 'contactus';
        $query = mysqli_query($con, "SELECT PageTitle, Description FROM tblpages WHERE PageName='$pagetype'");
        while($row = mysqli_fetch_array($query)) {
        ?>

        <h1 class="text-4xl font-bold text-gray-800 mt-2 mb-3">
            <?php echo htmlentities($row['PageTitle'])?>
        </h1>
          
        <nav class="bg-gray-200 px-4 py-2 rounded mb-6">
            <ol class="list-reset flex text-gray-700">
                <li><a href="index.php" class="text-blue-600 hover:underline">Home</a></li>
                <li class="mx-2">/</li>
                <li class="font-bold">Contact</li>
            </ol>
        </nav>

        <!-- Intro Content -->
        <div class="bg-white p-6 rounded shadow">
            <p class="text-gray-700">
                <?php echo $row['Description'];?>
            </p>
        </div>

        <?php } ?>
    
    </div>
    <!-- /.container -->

    <!-- Footer -->
    <?php include('includes/footer.php');?>

    <!-- JavaScript (if needed) -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs" defer></script>

</body>

</html>
