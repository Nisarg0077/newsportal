<?php 
session_start();
error_reporting(0);
include('./conn.php');

// Get the current page number
$pageno = isset($_GET['pageno']) ? intval($_GET['pageno']) : 1;

// Set number of records per page (show only 4 news at a time)
$no_of_records_per_page = 4;
$offset = ($pageno - 1) * $no_of_records_per_page;

if ($_GET['catid'] != '') {
    $_SESSION['catid'] = intval($_GET['catid']);
}

// Query to get the total number of posts
$total_pages_sql = "SELECT COUNT(*) FROM tblposts WHERE tblposts.CategoryId = '".$_SESSION['catid']."' AND tblposts.Is_Active = 1";
$result = mysqli_query($con, $total_pages_sql);
$total_rows = mysqli_fetch_array($result)[0];
$total_pages = ceil($total_rows / $no_of_records_per_page);

// Query to fetch posts for the current page
$query = mysqli_query($con, "SELECT tblposts.id as pid, tblposts.PostTitle as posttitle, tblposts.PostImage, tblcategory.CategoryName as category, tblsubcategory.Subcategory as subcategory, tblposts.PostDetails as postdetails, tblposts.PostingDate as postingdate, tblposts.PostUrl as url FROM tblposts LEFT JOIN tblcategory ON tblcategory.id = tblposts.CategoryId LEFT JOIN tblsubcategory ON tblsubcategory.SubCategoryId = tblposts.SubCategoryId WHERE tblposts.CategoryId = '".$_SESSION['catid']."' AND tblposts.Is_Active = 1 ORDER BY tblposts.id DESC LIMIT $offset, $no_of_records_per_page");

$rowcount = mysqli_num_rows($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>News Portal | Category Page</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">

    <!-- Navigation -->
    <?php include('includes/header.php'); ?>

    <!-- Page Content -->
    <div class="container mx-auto mt-8">
        <div class="flex flex-wrap -mx-4">
            <!-- Blog Entries Column -->
            <div class="w-full md:w-2/3 px-4">
                <?php 
                if ($rowcount > 0) {
                    while ($row = mysqli_fetch_array($query)) {
                ?>
                
                <div class="relative flex flex-col w-9/12 ml-20 mr-0 rounded break-words border bg-white border-1 border-black mb-4">
                    <img class="w-full w-9/12 h-4/6 rounded-t" src="Admin/postimages/<?php echo htmlentities($row['PostImage']);?>" alt="<?php echo htmlentities($row['posttitle']);?>">
                    <div class="flex-auto p-6">
                      <h2 class="mb-3 text-2xl font-bold"><?php echo htmlentities($row['posttitle']);?></h2>
                      <p>
                        <a class="inline-block p-1 text-center font-semibold text-sm align-baseline leading-none rounded bg-gray-600 text-white" href="category.php?catid=<?php echo htmlentities($row['cid'])?>"><?php echo htmlentities($row['category']);?></a>
                        <a class="inline-block p-1 text-center font-semibold text-sm align-baseline leading-none rounded bg-gray-600 text-white"><?php echo htmlentities($row['subcategory']);?></a>
                      </p>
                      <a href="news-details.php?nid=<?php echo htmlentities($row['pid']);?>" class="inline-block mt-3 py-1 px-3 text-white bg-blue-900 rounded hover:bg-blue-700">Read More &rarr;</a>
                    </div>
                    <div class="py-3 px-6 bg-gray-200 border-t border-gray-300 text-gray-700">
                      Posted on <?php echo htmlentities($row['postingdate']);?>
                    </div>
                </div>
                
                <?php } ?>

                <!-- Pagination -->
<?php if ($total_pages > 1): ?>
    <ul class="flex justify-center mt-4 mb-4 space-x-1">
    <li class="page-item <?php if ($pageno == 1) echo 'opacity-50 cursor-not-allowed'; ?>">
        <a href="<?php if ($pageno > 1) echo "?pageno=1"; else echo '#'; ?>" class="block py-2 px-3 leading-normal text-blue-700 bg-white border border-gray-200 hover:text-blue-800 hover:bg-gray-200">First</a>
    </li>
    <li class="page-item <?php if ($pageno <= 1) echo 'opacity-50 cursor-not-allowed'; ?>">
        <a href="<?php if ($pageno > 1) echo "?pageno=" . ($pageno - 1); else echo '#'; ?>" class="block py-2 px-3 leading-normal text-blue-700 bg-white border border-gray-200 hover:text-blue-800 hover:bg-gray-200">Prev</a>
    </li>
    
    <!-- Dynamic page numbers -->
    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <li class="page-item <?php if ($i == $pageno) echo 'font-bold'; ?>">
            <a href="?pageno=<?php echo $i; ?>" class="block py-2 px-3 leading-normal text-blue-700 bg-white border border-gray-200 hover:text-blue-800 hover:bg-gray-200 <?php if ($i == $pageno) echo 'bg-yellow-600 text-white'; ?>"><?php echo $i; ?></a>
        </li>
    <?php endfor; ?>
    
    <li class="page-item <?php if ($pageno >= $total_pages) echo 'opacity-50 cursor-not-allowed'; ?>">
        <a href="<?php if ($pageno < $total_pages) echo "?pageno=" . ($pageno + 1); else echo '#'; ?>" class="block py-2 px-3 leading-normal text-blue-700 bg-white border border-gray-200 hover:text-blue-800 hover:bg-gray-200">Next</a>
    </li>
    <li class="page-item <?php if ($pageno == $total_pages) echo 'opacity-50 cursor-not-allowed'; ?>">
        <a href="<?php echo ($pageno < $total_pages) ? "?pageno=$total_pages" : '#'; ?>" class="block py-2 px-3 leading-normal text-blue-700 bg-white border border-gray-200 hover:text-blue-800 hover:bg-gray-200">Last</a>
    </li>
</ul>

<?php endif; } else { ?>
    <p class="text-center">No posts found in this category.</p>
<?php } ?>
            </div>

            <!-- Sidebar Widgets Column -->
            <div class="w-full md:w-1/3 px-4">
                <?php include('includes/sidebar.php'); ?>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include('includes/footer.php'); ?>

</body>

</html>
