<?php 
session_start();
error_reporting(0);
include('./conn.php');

$limit = 10; // Number of posts per page
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Initialize search title
$st = isset($_POST['searchtitle']) ? mysqli_real_escape_string($con, trim($_POST['searchtitle'])) : '';
$_SESSION['searchtitle'] = $st; // Store search title in session

// If no search term is provided, redirect to the main page or show a message
if (empty($st)) {
    echo "<p class='text-red-500'>Please enter a search term.</p>";
    exit; // Stop further execution
}

// Pagination setup
$total_pages_sql = "SELECT COUNT(*) FROM tblposts WHERE PostTitle LIKE '%$st%' AND Is_Active = 1";
$result = mysqli_query($con, $total_pages_sql);
$total_rows = mysqli_fetch_array($result)[0];
$total_pages = ceil($total_rows / $limit);

// Fetch the relevant posts
$query = mysqli_query($con, "SELECT tblposts.id AS pid, tblposts.PostTitle AS posttitle, tblcategory.CategoryName AS category, tblsubcategory.Subcategory AS subcategory, tblposts.PostDetails AS postdetails, tblposts.PostingDate AS postingdate, tblposts.PostUrl AS url, tblposts.PostImage FROM tblposts LEFT JOIN tblcategory ON tblcategory.id = tblposts.CategoryId LEFT JOIN tblsubcategory ON tblsubcategory.SubCategoryId = tblposts.SubCategoryId WHERE tblposts.PostTitle LIKE '%$st%' AND tblposts.Is_Active = 1 LIMIT $offset, $limit");

$rowcount = mysqli_num_rows($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>News Portal | Search Page</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <!-- Navigation -->
    <?php include('./includes/header.php');?>

    <!-- Page Content -->
    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-wrap -mx-4">
            <!-- Blog Entries Column -->
            <div class="w-full md:w-2/3">
                <!-- Blog Post -->
                <?php 
                if($rowcount == 0) {
                    echo "<p class='text-red-500'>No records found for '$st'</p>";
                } else {
                    while ($row = mysqli_fetch_array($query)) {
                ?>
                <div class="relative flex flex-col w-9/12 ml-20 mr-0 rounded break-words border bg-white border-1 border-black mb-4">
                    <img class="w-full rounded-t" src="Admin/postimages/<?php echo htmlentities($row['PostImage']); ?>" alt="<?php echo htmlentities($row['posttitle']); ?>">
                    <div class="flex-auto p-6">
                        <h2 class="mb-3 text-2xl font-bold"><?php echo htmlentities($row['posttitle']); ?></h2>
                        <p>
                            <a class="inline-block p-1 text-center font-semibold text-sm align-baseline leading-none rounded bg-gray-600 text-white" href="category.php?catid=<?php echo htmlentities($row['cid']); ?>"><?php echo htmlentities($row['category']); ?></a>
                            <a class="inline-block p-1 text-center font-semibold text-sm align-baseline leading-none rounded bg-gray-600 text-white"><?php echo htmlentities($row['subcategory']); ?></a>
                        </p>
                        <a href="news-details.php?nid=<?php echo htmlentities($row['pid']); ?>" class="inline-block mt-3 py-1 px-3 text-white bg-blue-900 rounded hover:bg-blue-700">Read More &rarr;</a>
                    </div>
                    <div class="py-3 px-6 bg-gray-200 border-t border-gray-300 text-gray-700">
                        Posted on <?php echo htmlentities($row['postingdate']); ?>
                    </div>
                </div>
                <?php 
                    } 
                ?>
                <div class="flex justify-center mb-8">
                <?php if ($total_rows > $limit): ?>
                    <div class="mt-6 mb-6 flex justify-center items-center">
                        <div class="space-x-2">
                            <?php if ($page > 1): ?>
                                <a href="?page=<?php echo $page - 1; ?>" class="px-3 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400">Previous</a>
                            <?php endif; ?>

                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <a href="?page=<?php echo $i; ?>" class="px-3 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 <?php echo ($page == $i) ? 'bg-gray-400' : ''; ?>"><?php echo $i; ?></a>
                            <?php endfor; ?>

                            <?php if ($page < $total_pages): ?>
                                <a href="?page=<?php echo $page + 1; ?>" class="px-3 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400">Next</a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
                </div>
                <?php 
                } 
                ?>
            </div>

            <!-- Sidebar Widgets Column -->
            <div class="w-full lg:w-1/3 px-4">
                <?php include('./includes/sidebar.php');?>
            </div>
        </div>
    </div>
    <!-- /.container -->

    <!-- Footer -->
    <?php include('./includes/footer.php');?>
</body>
</html>
