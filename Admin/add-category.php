<?php
session_start();
include('../conn.php');
error_reporting(0);

if(strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {
    if(isset($_POST['submit'])) {
        $category = $_POST['category'];
        $description = $_POST['description'];
        $status = 1;
        $query = mysqli_query($con, "INSERT INTO tblcategory (CategoryName, Description, Is_Active) VALUES ('$category', '$description', '$status')");
        if($query) {
            $msg = "Category created successfully!";
        } else {
            $error = "Something went wrong. Please try again.";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Newsportal | Add Category</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css">
    <script src="../assets/js/modernizr.min.js"></script>
</head>

<body class="min-h-screen bg-gray-100">

        <?php include('../includes/topheader.php'); ?>
        <!-- Begin page -->
        <div id="wrapper" class="flex flex-row min-h-screen">
            <div id="toggleContent">
                <?php include('../includes/leftsidebar.php'); ?>
            </div>

            <div class="flex-grow">
                <!-- Start content -->
                <div class="container mx-auto px-4 py-6">

                    <div class="mb-4 flex justify-between items-center py-4">
                        <h1 class="text-2xl font-semibold mb-2">Add Category</h1>
                        <ol class="flex space-x-4 text-sm text-gray-500">
                            <li><a href="#" class="hover:text-gray-900">Admin /</a></li>
                            <li><a href="#" class="hover:text-gray-900">Category /</a></li>
                            <li class="text-gray-900">Add Category</li>
                        </ol>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h4 class="text-xl font-semibold mb-4">Add Category</h4>

                        <!-- Success Message -->
                        <?php if($msg){ ?>
                        <div class="mb-4 p-3 rounded bg-green-200 text-green-800 border border-green-300">
                            <strong>Well done!</strong> <?php echo htmlentities($msg); ?>
                        </div>
                        <?php } ?>

                        <!-- Error Message -->
                        <?php if($error){ ?>
                        <div class="mb-4 p-3 rounded bg-red-200 text-red-800 border border-red-300">
                            <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                        </div>
                        <?php } ?>

                        <form class="space-y-6" name="category" method="post" onsubmit="return validateForm();">
                            <div class="flex flex-col space-y-4">

                                <div class="flex flex-col">
                                    <label class="text-gray-700 text-lg font-medium">Category</label>
                                    <input type="text" class="w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-500" name="category" id="Category">
                                    <span id="category-error" class="text-sm text-red-500 mt-1 hidden">Category is required.</span>
                                </div>
                                <div class="flex flex-col">
                                    <label class="text-gray-700 text-lg font-medium">Category Description</label>
                                    <textarea class="w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-500" rows="5" name="description" id="description"></textarea>
                                    <span id="description-error" class="text-sm text-red-500 mt-1 hidden">Description is required.</span>
                                </div>
                                <div class="flex justify-end">
                                    <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-lg shadow-md hover:bg-blue-700 focus:ring focus:ring-blue-200 focus:ring-opacity-50" name="submit">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div> <!-- container -->
            </div> <!-- content -->
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
        function validateForm() {
            const category = document.getElementById('Category').value.trim();
            const description = document.getElementById('description').value.trim();
            let valid = true;

            if(category === "") {
                document.getElementById('category-error').classList.remove('hidden');
                valid = false;
            } else {
                document.getElementById('category-error').classList.add('hidden');
            }

            if(description === "") {
                document.getElementById('description-error').classList.remove('hidden');
                valid = false;
            } else {
                document.getElementById('description-error').classList.add('hidden');
            }

            return valid;
        }

        document.getElementById('user-menu-button').addEventListener('click', function() {
            const userMenu = document.getElementById('user-menu');
            userMenu.classList.toggle('hidden');
        });

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
