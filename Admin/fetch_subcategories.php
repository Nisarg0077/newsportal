<?php
include('../conn.php');

// Check if category ID is passed
if (isset($_POST['category_id'])) {
    $category_id = $_POST['category_id'];

    // Fetch subcategories based on the selected category
    $query = mysqli_query($con, "SELECT SubCategoryId, Subcategory FROM tblsubcategory WHERE CategoryId = '$category_id' AND Is_Active = 1");

    $subcategories = [];
    while ($row = mysqli_fetch_assoc($query)) {
        $subcategories[] = $row;
    }

    // Return the subcategories in JSON format
    echo json_encode($subcategories);
}
?>
