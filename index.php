<?php 
  session_start();
  include('./conn.php');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="./images/logoNE.png">

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />

    <title>News Everyday</title>

    <style>
    .swiper-pagination-bullet {
    background-color: lightyellow;
    opacity: 0.8;
  }
  
  .swiper-pagination-bullet-active {
    background-color: orange; /* Optional: to distinguish the active bullet */
  }
    /* Adjustments for responsiveness */
    @media (min-width: 640px) { /* sm */
      .swiper-slide img {
        height: 250px;
      }
    }
    @media (min-width: 768px) { /* md */
      .swiper-slide img {
        height: 300px;
      }
    }
    @media (min-width: 1024px) { /* lg */
      .swiper-slide img {
        height: 350px;
      }
    }
  </style>
  </head>

  <body class="bg-gray-100">

    <!-- Navigation -->
    <?php include('./includes/header.php');?>

    <div class="container px-2 mt-8">
    <div class="swiper-container  w-full overflow-x-hidden px-4 relative">
  <div class="swiper-wrapper w-full">
    <?php 
      $slider_sql = "SELECT id, PostTitle, PostImage FROM tblposts WHERE Is_Active = 1 ORDER BY PostingDate DESC LIMIT 5";
      $slider_query = mysqli_query($con, $slider_sql);

      while ($slider_row = mysqli_fetch_array($slider_query)) {
    ?>
    <div class="swiper-slide relative flex items-center justify-center">
      <img src="Admin/postimages/<?php echo htmlentities($slider_row['PostImage']);?>" alt="<?php echo htmlentities($slider_row['PostTitle']);?>" class="w-full h-64 sm:h-80 md:h-96 lg:h-80 object-cover rounded-lg shadow-lg">
      <div class="absolute inset-0 bg-black bg-opacity-50 flex items-end p-4 rounded-lg">
        <div class="text-white">
          <h3 class="text-lg sm:text-xl md:text-2xl font-bold mb-2"><?php echo htmlentities($slider_row['PostTitle']);?></h3>
          <a href="news-details.php?nid=<?php echo htmlentities($slider_row['id']);?>" class="inline-block py-2 px-4 bg-blue-600 hover:bg-blue-800 text-white rounded-lg shadow-lg transition-colors duration-300">Read More &rarr;</a>
        </div>
      </div>
    </div>
    <?php } ?>
  </div>

  <!-- Add Pagination -->
  <div class="swiper-pagination absolute bottom-0 w-full flex justify-center"></div>
  
  <!-- Add Navigation -->
  <div class="swiper-button-prev absolute left-0 top-1/2 transform -translate-y-1/2 text-yellow-500"></div>
  <div class="swiper-button-next absolute right-0 top-1/2 transform -translate-y-1/2 text-yellow-500"></div>
</div>

    

<!-- Page Content -->
<div class="container mx-auto px-4 mt-8">
  <div class="flex flex-wrap">

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

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>

  <!-- Initialize Swiper -->
  <script>
  var swiper = new Swiper('.swiper-container', {
    slidesPerView: 1,
    spaceBetween: 10,
    loop: true,
    autoplay: {
      delay: 2800,
      disableOnInteraction: false,
    },
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
  });
</script>

</body>
</html>
