<?php 
session_start();
include('./conn.php');
if (empty($_SESSION['token'])) {
 $_SESSION['token'] = bin2hex(random_bytes(32));
}

if(isset($_POST['submit']))
{
  if (!empty($_POST['csrftoken'])) {
    if (hash_equals($_SESSION['token'], $_POST['csrftoken'])) {
      $name=$_POST['name'];
      $email=$_POST['email'];
      $comment=$_POST['comment'];
      $postid=intval($_GET['nid']);
      $st1='0';
      $query=mysqli_query($con,"insert into tblcomments(postId,name,email,comment,status) values('$postid','$name','$email','$comment','$st1')");
      if($query):
        echo "<script>alert('Comment successfully submitted. Comment will be displayed after admin review');</script>";
        unset($_SESSION['token']);
      else :
        echo "<script>alert('Something went wrong. Please try again.');</script>";  
      endif;
    }
  }
}

$postid=intval($_GET['nid']);
$sql = "SELECT viewCounter FROM tblposts WHERE id = '$postid'";
$result = $con->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $visits = $row["viewCounter"];
        $sql = "UPDATE tblposts SET viewCounter = $visits+1 WHERE id ='$postid'";
        $con->query($sql);
    }
} else {
    echo "No results";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>News Portal | Home Page</title>

  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css">

</head>
<body class="bg-gray-100 text-gray-900">


  <?php include('./includes/header.php');?>


  <div class="container mx-auto px-4 py-8">

    <div class="flex flex-wrap -mx-4">

      <div class="w-full lg:w-2/3 px-4">

  
        <?php
        $pid=intval($_GET['nid']);
        $currenturl="http://".$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $query=mysqli_query($con,"select tblposts.PostTitle as posttitle,tblposts.PostImage,tblcategory.CategoryName as category,tblcategory.id as cid,tblsubcategory.Subcategory as subcategory,tblposts.PostDetails as postdetails,tblposts.PostingDate as postingdate,tblposts.PostUrl as url,tblposts.postedBy,tblposts.lastUpdatedBy,tblposts.UpdationDate from tblposts left join tblcategory on tblcategory.id=tblposts.CategoryId left join tblsubcategory on tblsubcategory.SubCategoryId=tblposts.SubCategoryId where tblposts.id='$pid'");
        while ($row=mysqli_fetch_array($query)) {
        ?>

        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
          <h2 class="text-3xl font-bold mb-4"><?php echo htmlentities($row['posttitle']);?></h2>

 
          <a class="inline-block bg-gray-200 text-gray-800 px-3 py-1 rounded-full text-sm font-semibold mr-2 mb-2" href="category.php?catid=<?php echo htmlentities($row['cid'])?>">
            <?php echo htmlentities($row['category']);?>
          </a>

          <a class="inline-block bg-gray-200 text-gray-800 px-3 py-1 rounded-full text-sm font-semibold mr-2 mb-2">
            <?php echo htmlentities($row['subcategory']);?>
          </a>

          <p class="text-gray-600">
            <b>Posted by</b> <?php echo htmlentities($row['postedBy']);?> on <?php echo htmlentities($row['postingdate']);?>
            <?php if($row['lastUpdatedBy']!=''):?>
            | <b>Last Updated by</b> <?php echo htmlentities($row['lastUpdatedBy']);?> on <?php echo htmlentities($row['UpdationDate']);?>
            <?php endif;?>
          </p>

          <p class="mt-2">
            <b>Visits:</b> <?php print $visits; ?>
          </p>
          
          <hr class="my-4">

          <img class="w-full h-auto rounded" src="admin/postimages/<?php echo htmlentities($row['PostImage']);?>" alt="<?php echo htmlentities($row['posttitle']);?>">

          <p class="mt-4"><?php echo $row['postdetails'];?></p>
        </div>
        <?php } ?>

      </div>


      <div class="w-full lg:w-1/3 px-4">
        <?php include('./includes/sidebar.php');?>
      </div>
    </div>


    <div class="flex flex-wrap -mx-4 mt-8">
      <div class="w-full lg:w-2/3 px-4">
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
          <h5 class="text-2xl font-bold mb-4">Leave a Comment:</h5>
          <form name="Comment" method="post">
            <input type="hidden" name="csrftoken" value="<?php echo htmlentities($_SESSION['token']); ?>" />
            <div class="mb-4">
              <input type="text" name="name" class="form-control w-full px-3 py-2 border rounded" placeholder="Enter your fullname" required>
            </div>

            <div class="mb-4">
              <input type="email" name="email" class="form-control w-full px-3 py-2 border rounded" placeholder="Enter your valid email" required>
            </div>

            <div class="mb-4">
              <textarea class="form-control w-full px-3 py-2 border rounded" name="comment" rows="3" placeholder="Comment" required></textarea>
            </div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" name="submit">Submit</button>
          </form>
        </div>

      
        <?php 
        $sts=1;
        $query=mysqli_query($con,"select name,comment,postingDate from tblcomments where postId='$pid' and status='$sts'");
        while ($row=mysqli_fetch_array($query)) {
        ?>
        <div class="media mb-4">
          <img class="w-12 h-12 rounded-full mr-4" src="images/usericon.png" alt="">
          <div class="media-body">
            <h5 class="text-lg font-bold"><?php echo htmlentities($row['name']);?> 
              <br />
              <span class="text-sm text-gray-600"><b>at</b> <?php echo htmlentities($row['postingDate']);?></span>
            </h5>
            <p><?php echo htmlentities($row['comment']);?></p>
          </div>
        </div>
        <?php } ?>
      </div>
    </div>

  </div>

  <?php include('./includes/footer.php');?>

  
</body>
</html>
