<?php 
  session_start();
  include('./conn.php');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="./images/logoNE.png">

    <title>News Everyday</title>
  </head>

  <body class="bg-gray-100">

    <!-- Navigation -->
    <?php include('./includes/header.php');?>

    <!-- Page Content -->
    <div class="container mx-auto px-4">

      <div class="flex flex-wrap mt-8">

        <!-- Blog Entries Column -->
        <div class="w-full md:w-2/3 lg:w-3/4 mx-auto">

          <!-- Blog Post -->
          <?php 
            if (isset($_GET['pageno'])) {
                $pageno = $_GET['pageno'];
            } else {
                $pageno = 1;
            }
              $no_of_records_per_page = 8;
              $offset = ($pageno-1) * $no_of_records_per_page;

              $total_pages_sql = "SELECT COUNT(*) FROM tblposts";
              $result = mysqli_query($con,$total_pages_sql);
              $total_rows = mysqli_fetch_array($result)[0];
              $total_pages = ceil($total_rows / $no_of_records_per_page);

              $sqlcmd = "SELECT tblposts.id as pid, tblposts.PostTitle as posttitle, tblposts.PostImage, tblcategory.CategoryName as category, tblcategory.id as cid, tblsubcategory.Subcategory as subcategory, tblposts.PostDetails as postdetails, tblposts.PostingDate as postingdate, tblposts.PostUrl as url 
                         FROM tblposts 
                         LEFT JOIN tblcategory ON tblcategory.id = tblposts.CategoryId 
                         LEFT JOIN tblsubcategory ON tblsubcategory.SubCategoryId = tblposts.SubCategoryId 
                         WHERE tblposts.Is_Active = 1 
                         ORDER BY tblposts.id DESC  
                         LIMIT $offset, $no_of_records_per_page";
              $query = mysqli_query($con, $sqlcmd);

              while ($row = mysqli_fetch_array($query)) {
          ?>

          <div class="relative flex flex-col w-full max-w-3xl mx-auto rounded break-words border bg-white border-1 border-black mb-4">
            <img class="w-full rounded-t" src="Admin/postimages/<?php echo htmlentities($row['PostImage']);?>" alt="<?php echo htmlentities($row['posttitle']);?>">
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
          <ul class="flex justify-center mt-4 mb-4 space-x-1">
            <li class="page-item">
              <a href="?pageno=1" class="block py-2 px-3 leading-normal text-blue-700 bg-white border border-gray-200 hover:text-blue-800 hover:bg-gray-200">First</a>
            </li>
            <li class="<?php if ($pageno <= 1) { echo 'opacity-50 cursor-not-allowed'; } ?> page-item">
              <a href="<?php if ($pageno > 1) { echo "?pageno=" . ($pageno - 1); } else { echo '#'; } ?>" class="block py-2 px-3 leading-normal text-blue-700 bg-white border border-gray-200 hover:text-blue-800 hover:bg-gray-200">Prev</a>
            </li>
            <li class="<?php if ($pageno >= $total_pages) { echo 'opacity-50 cursor-not-allowed'; } ?> page-item">
              <a href="<?php if ($pageno < $total_pages) { echo "?pageno=" . ($pageno + 1); } else { echo '#'; } ?>" class="block py-2 px-3 leading-normal text-blue-700 bg-white border border-gray-200 hover:text-blue-800 hover:bg-gray-200">Next</a>
            </li>
            <li class="page-item">
              <a href="?pageno=<?php echo $total_pages; ?>" class="block py-2 px-3 leading-normal text-blue-700 bg-white border border-gray-200 hover:text-blue-800 hover:bg-gray-200">Last</a>
            </li>
          </ul>

        </div>

        <!-- Sidebar Widgets Column -->
        <div class="w-full md:w-1/3 lg:w-1/4 px-4">
          <?php include('./includes/sidebar.php');?>
        </div>

      </div>
      <!-- /.row -->

    </div>
    <!-- /.container -->

    <!-- Footer -->
    <?php include('./includes/footer.php');?>

    <!-- Tailwind CSS -->
    

  </body>
</html>
