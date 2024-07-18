<?php
session_start();
include('../conn.php');
error_reporting(0);
if(strlen($_SESSION['login'])==0)
  { 
header('location:index.php');
}
else{
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
admin page.
this will be updated.

    <div>
        <?php
            include "../conn.php";
            
            
            



            // if(isset($_POST['btn1'])){
            //     $sql = 'SELECT * FROM tbladmin';

            //     $r = mysqli_query($con, $sql);
            //     echo "<table border='2px'>";             
            //     echo "<tr>
            //     <td>
            //         Admin Username
            //     </td>
            //     <td>
            //         Admin Password
            //     </td>
                
            //     </tr>";             
                
            //     while($row = mysqli_fetch_array($r)){
                    
            //         echo "<tr>";
            //         echo "<td>";
            //         echo $row['AdminUserName'];         
            //         echo "</td>";
            //         echo "<td>";
            //         echo $row['AdminPassword'];         
            //         echo "</td>";                       
            //         echo "</tr>";                        
            //     }
            //     echo "</table>";
            // }
        ?>
    </div>
</body>
</html><?php } ?>