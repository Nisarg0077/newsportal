<div class="ml-0 px-4">

  <!-- Search Widget -->
  <div class="bg-white rounded-lg shadow-md p-6 mb-8">
    <h5 class="text-2xl font-bold mb-4">Search</h5>
    <div>
      <form name="search" action="search.php" method="post">
        <div class="flex">
          <input type="text" name="searchtitle" class="form-control w-full px-3 py-2 border rounded-l" placeholder="Search for..." required>
          <button class="bg-gray-300 text-gray-700 px-4 py-2 rounded-r" type="submit">Go!</button>
        </div>
      </form>


      
    </div>
    <div class="relative inline-block text-left mt-5 w-full">
  <div>
    <button type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" id="categories-menu-button" aria-expanded="true" aria-haspopup="true">
      Categories
      <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
      </svg>
    </button>
  </div>

  <div class="w-full origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none hidden" id="categories-menu" role="menu" aria-orientation="vertical" aria-labelledby="categories-menu-button">
    <div class="py-1" role="none">
      <?php 
      $query = mysqli_query($con, "select id, CategoryName from tblcategory");
      while ($row = mysqli_fetch_array($query)) {
      ?>
      <a href="category.php?catid=<?php echo htmlentities($row['id'])?>" class="text-gray-700 block px-4 py-2 text-sm hover:bg-gray-100" role="menuitem"><?php echo htmlentities($row['CategoryName']);?></a>
      <?php } ?>
    </div>
  </div>
</div>
  </div>

  <!-- Categories Widget -->
  

<script>
  document.getElementById('categories-menu-button').addEventListener('click', function() {
    var menu = document.getElementById('categories-menu');
    menu.classList.toggle('hidden');
  });
</script>


  <!-- Recent News Widget -->
  <div class="bg-white rounded-lg shadow-md p-6 mb-8">
    <h5 class="text-2xl font-bold mb-4">Recent News</h5>
    <div>
        <ul class="list-disc pl-5">
            <?php
            $query = mysqli_query($con, "SELECT tblposts.id AS pid, tblposts.PostTitle AS posttitle FROM tblposts LEFT JOIN tblcategory ON tblcategory.id = tblposts.CategoryId LEFT JOIN tblsubcategory ON tblsubcategory.SubCategoryId = tblposts.SubCategoryId ORDER BY tblposts.PostingDate DESC LIMIT 5");
            while ($row = mysqli_fetch_array($query)) {
            ?>
            <li>
                <a href="news-details.php?nid=<?php echo htmlentities($row['pid'])?>" class="text-blue-500 hover:text-blue-700"><?php echo htmlentities($row['posttitle']);?></a>
            </li>
            <?php } ?>
        </ul>
    </div>
</div>



  <!-- Popular News Widget -->
  <div class="bg-white rounded-lg shadow-md p-6 mb-8">
    <h5 class="text-2xl font-bold mb-4">Popular News</h5>
    <div>
      <ul class="list-disc pl-5">
        <?php
        $query1 = mysqli_query($con, "select tblposts.id as pid,tblposts.PostTitle as posttitle from tblposts left join tblcategory on tblcategory.id=tblposts.CategoryId left join tblsubcategory on tblsubcategory.SubCategoryId=tblposts.SubCategoryId order by viewCounter desc limit 5");
        while ($result = mysqli_fetch_array($query1)) {
        ?>
        <li>
          <a href="news-details.php?nid=<?php echo htmlentities($result['pid'])?>" class="text-blue-500 hover:text-blue-700"><?php echo htmlentities($result['posttitle']);?></a>
        </li>
        <?php } ?>
      </ul>
    </div>
  </div>
</div>
