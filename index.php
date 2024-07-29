<?php 
  session_start();
  include('./conn.php');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css">
    <title>News Everyday</title>
  </head>

  <body>

    <!-- Navigation -->
    
    <?php include('./includes/header.php');?>
    

    <!-- Page Content -->
    <div class=" w-9/12 container mx-auto sm:px-4">


     
      <div class="flex flex-wrap " style="margin-top: 4%">

        <!-- Blog Entries Column -->
        <div class="md:w-2/3 pr-4 pl-4">

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

              $sqlcmd = "select tblposts.id as pid,tblposts.PostTitle as posttitle,tblposts.PostImage,tblcategory.CategoryName as category,tblcategory.id as cid,tblsubcategory.Subcategory as subcategory,tblposts.PostDetails as postdetails,tblposts.PostingDate as postingdate,tblposts.PostUrl as url from tblposts left join tblcategory on tblcategory.id=tblposts.CategoryId left join  tblsubcategory on  tblsubcategory.SubCategoryId=tblposts.SubCategoryId where tblposts.Is_Active=1 order by tblposts.id desc  LIMIT $offset, $no_of_records_per_page";
              $query=mysqli_query($con,$sqlcmd);

              while ($row=mysqli_fetch_array($query)) {
          ?>

          <div class="relative flex flex-col min-w-0 rounded break-words border bg-white border-1 border-black mb-4">
          <img class="w-full rounded rounded-t" src="Admin/postimages/<?php echo htmlentities($row['PostImage'])?>" alt="<?php echo htmlentities($row['posttitle']);?>">
            <div class="flex-auto p-6">
              <h2 class="mb-3"><?php echo htmlentities($row['posttitle']);?></h2>
                 <p><!--category-->
                  <a class="inline-block p-1 text-center font-semibold text-sm align-baseline leading-none rounded bg-gray-600 text-decoration-none link-light" href="category.php?catid=<?php echo htmlentities($row['cid'])?>" style="color:#fff"><?php echo htmlentities($row['category']);?></a>
                  <!--Subcategory--->
                  <a class="inline-block p-1 text-center font-semibold text-sm align-baseline leading-none rounded bg-gray-600 text-decoration-none link-light"  style="color:#fff"><?php echo htmlentities($row['subcategory']);?></a></p>
       
              <a href="news-details.php?nid=<?php echo htmlentities($row['pid'])?>" class="inline-block align-middle text-center select-none border font-normal whitespace-no-wrap rounded py-1 px-3 leading-normal no-underline bg-blue-900 text-white hover:bg-blue-900">Read More &rarr;</a>
            </div>
            <div class="py-3 px-6 bg-gray-200 border-t-1 border-gray-300 text-gray-700">
              Posted on <?php echo htmlentities($row['postingdate']);?>
           
            </div>
          </div>
<?php } 
?>
       

      

          <!-- Pagination -->


    <ul class="flex list-reset pl-0 rounded justify-center mb-4">
        <li class="page-item"><a href="?pageno=1"  class="relative block py-2 px-3 -ml-px leading-normal text-blue bg-white border border-gray-200 no-underline hover:text-blue-800 hover:bg-gray-200">First</a></li>
        <li class="<?php if($pageno <= 1){ echo 'opacity-75'; } ?> page-item">
            <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>" class="relative block py-2 px-3 -ml-px leading-normal text-blue bg-white border border-gray-200 no-underline hover:text-blue-800 hover:bg-gray-200">Prev</a>
        </li>
        <li class="<?php if($pageno >= $total_pages){ echo 'opacity-75'; } ?> page-item">
            <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?> " class="relative block py-2 px-3 -ml-px leading-normal text-blue bg-white border border-gray-200 no-underline hover:text-blue-800 hover:bg-gray-200">Next</a>
        </li>
        <li class="page-item"><a href="?pageno=<?php echo $total_pages; ?>" class="relative block py-2 px-3 -ml-px leading-normal text-blue bg-white border border-gray-200 no-underline hover:text-blue-800 hover:bg-gray-200">Last</a></li>
    </ul>

        </div>

        <!-- Sidebar Widgets Column -->
      <?php //include('includes/sidebar.php');?>
      </div>
      <!-- /.row -->

    </div>
    <!-- /.container -->

    <!-- Footer -->
      <?php include('includes/footer.php');?>


    <!-- Bootstrap core JavaScript -->
     <script src="vendor/jquery/jquery.min.js"></script>
                  
 
    <script src="https://cdn.tailwindcss.com"></script>

  </body>

</html>
