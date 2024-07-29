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
    <link href="css/modern-business.css" rel="stylesheet">
</head>

<body>
    <?php include('./includes/header.php'); ?>
    <div class="container mx-auto p-4">
        <?php
        $pagetype = 'aboutus';
        $query = mysqli_query($con, "SELECT PageTitle, Description FROM tblpages WHERE PageName='$pagetype'");
        while ($row = mysqli_fetch_array($query)) {
        ?>
            <h1 class="mt-4 mb-3 text-4xl font-bold"><?php echo htmlentities($row['PageTitle']) ?>
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

    <!-- jQuery and JavaScript files -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"></script>
</body>

</html>
