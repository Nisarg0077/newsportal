<?php
 session_start();
//Database Configuration File
include('../conn.php');
//error_reporting(0);
if(isset($_POST['login']))
  {
 
    // Getting username/ email and password
    $uname=$_POST['username'];
    $password= md5($_POST['password']);
    // Fetch data from database on the basis of username/email and password
    $q = "SELECT AdminUserName,AdminEmailId,AdminPassword,userType FROM tbladmin WHERE (AdminUserName='$uname' && AdminPassword='$password')";
    $sql =mysqli_query($con,$q);
    $num=mysqli_fetch_array($sql);
    if($num>0)
    {

        $_SESSION['login']=$_POST['username'];
        $_SESSION['utype']=$num['userType'];
        echo "<script type='text/javascript'> document.location = '../Admin/admin.php'; </script>";
    }else{
        echo "<script>alert('Invalid Details');</script>";
    }
    
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
<div class="w-full max-w-xs">
    <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" action="" method="POST">
        <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
                Username
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="username" type="text" required="" name="username" placeholder="Username" autocomplete="off">
        </div>
        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                Password
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="password" type="password" name="password" required="" placeholder="Password" autocomplete="off">
            <div class="flex items-center space-x-1 mt-2 border-1 rounded shadow border-back py-2 px-3 mt-4">
                <svg width="20%" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-800">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                </svg>
                <a href="../index.php" class="text-black " style="text-decoration: none;">Back Home</a>
            </div>
        </div>
        <div class="flex items-center justify-between">
            <input class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit" name="login" value="Sign In">
                
        </div>
    </form>
</div>

</body>
</html>
