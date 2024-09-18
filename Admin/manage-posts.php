<?php 
session_start();
include('../conn.php');
error_reporting(0);

if(strlen($_SESSION['login'])==0) { 
    header('location:index.php');
} else {

if($_GET['action']=='del') {
    $postid = intval($_GET['pid']);
    $query = mysqli_query($con, "UPDATE tblposts SET Is_Active=0 WHERE id='$postid'");
    if($query) {
        $msg = "Post deleted ";
    } else {
        $error = "Something went wrong. Please try again.";    
    } 
}

// Fetch categories for the dropdown
$categoryQuery = mysqli_query($con, "SELECT id, CategoryName FROM tblcategory WHERE Is_Active = 1");
$categories = [];
while($catRow = mysqli_fetch_assoc($categoryQuery)) {
    $categories[] = $catRow;
}

// Handle search and filter
$searchTitle = $_GET['searchTitle'] ?? '';
$filterCategory = $_GET['filterCategory'] ?? '';

// Pagination variables
$limit = 10; // Number of posts per page
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Adjusted query with search, filter, and pagination
$query = mysqli_query($con, "SELECT tblposts.id AS postid, tblposts.PostTitle AS title, tblposts.PostingDate AS PostingDate, tblcategory.CategoryName AS category, tblsubcategory.Subcategory AS subcategory FROM tblposts LEFT JOIN tblcategory ON tblcategory.id = tblposts.CategoryId LEFT JOIN tblsubcategory ON tblsubcategory.SubCategoryId = tblposts.SubCategoryId WHERE tblposts.Is_Active = 1 AND (tblposts.PostTitle LIKE '%$searchTitle%') AND (tblposts.CategoryId = '$filterCategory' OR '$filterCategory' = '') LIMIT $limit OFFSET $offset");
$totalPostsQuery = mysqli_query($con, "SELECT COUNT(*) AS total FROM tblposts WHERE Is_Active = 1 AND (PostTitle LIKE '%$searchTitle%') AND (CategoryId = '$filterCategory' OR '$filterCategory' = '')");
$totalPosts = mysqli_fetch_assoc($totalPostsQuery)['total'];
$totalPages = ceil($totalPosts / $limit);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
    <meta name="author" content="Coderthemes">

    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <!-- App title -->
    <title>Newsportal | Manage Posts</title>

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css">
    <script src="../assets/js/modernizr.min.js"></script>
</head>

<body class="bg-gray-100">

<?php include('../includes/topheader.php'); ?>
    <!-- Begin page -->
    <div id="wrapper" class="flex flex-row min-h-screen mb-0">
        
        <!-- Top Bar Start -->

        <!-- Left Sidebar Start -->
        <div id="toggleContent">
            <?php include('../includes/leftsidebar.php'); ?>
        </div>

        <!-- Right Content Start -->
        <div class="flex-1 p-6 w-full mx-auto">
            <div class="content">
                <!-- Breadcrumb -->
                <div class="mb-6">
                    <div class="text-xl font-semibold mb-2">Manage Posts</div>
                    <ol class="flex space-x-1.5 justify-end text-sm text-gray-500">
                        <li><a href="./admin.php" class="hover:text-gray-900">Admin /</a></li>
                        <li><a href="./manage-posts.php" class="hover:text-gray-900">Posts /</a></li>
                        <li class="text-gray-900">Manage Post</li>
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

                <!-- Add Post Button -->
                <div class="mb-6">
                    <a href="add-post.php">
                        <button class="bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-400">
                            Add <i class="fa fa-plus-circle"></i>
                        </button>
                    </a>
                </div>

                <!-- Search and Filter -->
                <div class="flex mb-6 space-x-4">
                    <form method="GET" action="manage-posts.php" class="flex space-x-4">
                        <input type="text" name="searchTitle" placeholder="Search by title..." value="<?php echo htmlentities($searchTitle); ?>" class="px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">

                        <select name="filterCategory" onchange="this.form.submit()" class="px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">All Categories</option>
                            <?php foreach($categories as $category) { ?>
                                <option value="<?php echo $category['id']; ?>" <?php echo ($filterCategory == $category['id']) ? 'selected' : ''; ?>>
                                    <?php echo htmlentities($category['CategoryName']); ?>
                                </option>
                            <?php } ?>
                        </select>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Search</button>
                    </form>
                </div>

                <!-- Posts Table -->
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead class="bg-blue-500 text-white">
                            <tr>
                                <th class="border border-gray-200 px-4 py-2">Title</th>
                                <th class="border border-gray-200 px-4 py-2">Category</th>
                                <th class="border border-gray-200 px-4 py-2">Subcategory</th>
                                <th class="border border-gray-200 px-4 py-2">Posting Date</th>
                                <th class="border border-gray-200 px-4 py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $rowcount = mysqli_num_rows($query);
                            if($rowcount == 0) {
                            ?>
                            <tr>
                                <td colspan="5" class="text-center py-4 text-red-600">No record found</td>
                            </tr>
                            <?php 
                            } else {
                                while($row = mysqli_fetch_array($query)) {
                            ?>
                            <tr>
                                <td class="border border-gray-200 px-4 py-2"><?php echo htmlentities($row['title']); ?></td>
                                <td class="border border-gray-200 px-4 py-2"><?php echo htmlentities($row['category']); ?></td>
                                <td class="border border-gray-200 px-4 py-2"><?php echo htmlentities($row['subcategory']); ?></td>
                                <td class="border border-gray-200 text-sm px-4 py-2"><?php echo htmlentities(strval($row['PostingDate'])) ?></td>
                                <td class="border border-gray-200 px-4 py-2">
                                    <a href="edit-post.php?pid=<?php echo htmlentities($row['postid']); ?>" class="text-blue-500 hover:text-blue-700"><i class="fa fa-pencil"></i></a>
                                    <a href="manage-posts.php?pid=<?php echo htmlentities($row['postid']); ?>&&action=del" onclick="return confirm('Do you really want to delete?')" class="text-red-500 hover:text-red-700 ml-2"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php } }?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-6 flex justify-center items-center">
                    <div class="space-x-2">
                        <?php if($page > 1) { ?>
                            <a href="?searchTitle=<?php echo $searchTitle; ?>&filterCategory=<?php echo $filterCategory; ?>&page=<?php echo $page - 1; ?>" class="px-3 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400">Previous</a>
                        <?php } ?>
                        <?php for($i = 1; $i <= $totalPages; $i++) { ?>
                            <a href="?searchTitle=<?php echo $searchTitle; ?>&filterCategory=<?php echo $filterCategory; ?>&page=<?php echo $i; ?>" class="px-3 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 <?php echo ($page == $i) ? 'bg-gray-400' : ''; ?>"><?php echo $i; ?></a>
                        <?php } ?>
                        <?php if($page < $totalPages) { ?>
                            <a href="?searchTitle=<?php echo $searchTitle; ?>&filterCategory=<?php echo $filterCategory; ?>&page=<?php echo $page + 1; ?>" class="px-3 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400">Next</a>
                        <?php } ?>
                    </div>
                </div>

                
            </div> <!-- content -->
        </div> <!-- Right Content -->
        
        <!-- Footer -->
        
    </div> <!-- wrapper -->
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
