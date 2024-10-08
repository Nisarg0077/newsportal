<?php
session_start();
include('../conn.php');
error_reporting(0);
if(strlen($_SESSION['login'])==0) { 
    header('location:index.php');
} else {
    // Fetch most viewed posts
    $mostViewedQuery = mysqli_query($con, "SELECT PostTitle, viewCounter FROM tblposts WHERE Is_Active=1 ORDER BY viewCounter DESC LIMIT 5");
    $mostViewedPosts = [];
    while ($row = mysqli_fetch_assoc($mostViewedQuery)) {
        $mostViewedPosts[] = $row;
    }
    
    $postTitles = [];
    $viewCounts = [];
    
    foreach ($mostViewedPosts as $post) {
        $postTitles[] = $post['PostTitle'];
        $viewCounts[] = (int)$post['viewCounter'];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News Portal | Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css">
    <script src="../assets/js/modernizr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <?php include('../includes/topheader.php'); ?>

    <div id="wrapper" class="flex flex-col md:flex-row min-h-screen">
        <div id="toggleContent">
            <?php include('../includes/leftsidebar.php'); ?>
        </div>

        <div class="flex-grow p-6">
            <div class="content">
                <div class="container mx-auto">
                    <div class="mb-6">
                        <div class="flex justify-between items-center">
                            <h4 class="text-2xl font-bold">Dashboard</h4>
                            <ol class="breadcrumb flex space-x-1.5 text-sm">
                                <li><a href="../index.php" class="text-gray-600 hover:text-gray-800">NewsPortal /</a></li>
                                <li><a href="#" class="text-gray-600 hover:text-gray-800">Admin /</a></li>
                                <li class="text-gray-500">Dashboard</li>
                            </ol>
                        </div>
                    </div>

                    <!-- Cards Row 1 -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        <a href="./manage-categories.php" class="block bg-white p-6 rounded-lg shadow">
                            <div class="flex justify-between items-center space-x-4">
                                <div>
                                    <p class="text-gray-600 uppercase font-semibold">Categories Listed</p>
                                    <?php 
                                        $query = mysqli_query($con, "SELECT * FROM tblcategory WHERE Is_Active=1");
                                        $countcat = mysqli_num_rows($query);
                                    ?>
                                    <h2 class="text-2xl font-bold"><?php echo htmlentities($countcat); ?></h2>
                                </div>
                                <i class="fa-solid fa-list text-4xl text-gray-600"></i>
                            </div>
                        </a>

                        <a href="manage-subcategories.php" class="block bg-white p-6 rounded-lg shadow">
                            <div class="flex justify-between items-center space-x-4">
                                <div>
                                    <p class="text-gray-600 uppercase font-semibold">Listed Subcategories</p>
                                    <?php 
                                        $query = mysqli_query($con, "SELECT * FROM tblsubcategory WHERE Is_Active=1");
                                        $countsubcat = mysqli_num_rows($query);
                                    ?>
                                    <h2 class="text-2xl font-bold"><?php echo htmlentities($countsubcat); ?></h2>
                                </div>
                                <i class="fa-solid fa-table-list text-4xl text-gray-600"></i>
                            </div>
                        </a>

                        <a href="manage-posts.php" class="block bg-white p-6 rounded-lg shadow">
                            <div class="flex justify-between items-center space-x-4">
                                <div>
                                    <p class="text-gray-600 uppercase font-semibold">Live News</p>
                                    <?php 
                                        $query = mysqli_query($con, "SELECT * FROM tblposts WHERE Is_Active=1");
                                        $countposts = mysqli_num_rows($query);
                                    ?>
                                    <h2 class="text-2xl font-bold"><?php echo htmlentities($countposts); ?></h2>
                                </div>
                                <i class="fa-solid fa-newspaper text-4xl text-gray-600"></i>
                            </div>
                        </a>
                    </div>

                    <!-- Cards Row 2 -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mt-4">
                        <a href="trash-posts.php" class="block bg-white p-6 rounded-lg shadow">
                            <div class="flex justify-between items-center space-x-4">
                                <div>
                                    <p class="text-gray-600 uppercase font-semibold">Trash News</p>
                                    <?php 
                                        $query = mysqli_query($con, "SELECT * FROM tblposts WHERE Is_Active=0");
                                        $countposts = mysqli_num_rows($query);
                                    ?>
                                    <h2 class="text-2xl font-bold"><?php echo htmlentities($countposts); ?></h2>
                                </div>
                                <i class="fa-solid fa-dumpster text-4xl text-gray-600"></i>
                            </div>
                        </a>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow mt-6 text-center" style="height: 500px;">
    <h4 class="text-xl font-bold mb-4">Most Viewed Posts</h4>
    <canvas id="mostViewedPostsChart" style="max-height: 400px;"></canvas>
</div>

<script>
    // Define a color scheme
    const colors = [
        'rgba(75, 192, 192, 0.5)',
        'rgba(255, 99, 132, 0.5)',
        'rgba(255, 206, 86, 0.5)',
        'rgba(54, 162, 235, 0.5)',
        'rgba(153, 102, 255, 0.5)'
    ];

    const ctx = document.getElementById('mostViewedPostsChart').getContext('2d');
    const mostViewedPostsChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($postTitles); ?>,
            datasets: [{
                label: 'View Count',
                data: <?php echo json_encode($viewCounts); ?>,
                backgroundColor: colors,
                borderColor: colors.map(color => color.replace('0.5', '1')), // Use full opacity for borders
                borderWidth: 2,
                hoverBackgroundColor: colors.map(color => color.replace('0.5', '0.7')),
                hoverBorderColor: colors.map(color => color.replace('0.5', '1'))
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(200, 200, 200, 0.5)',
                    },
                    title: {
                        display: true,
                        text: 'Views',
                        font: {
                            size: 14,
                        },
                    },
                },
                x: {
                    grid: {
                        display: false,
                    },
                    title: {
                        display: true,
                        text: 'Posts',
                        font: {
                            size: 14,
                            weight: 'bold', // Makes the title bold
                        },
                    },
                    ticks: {
                        font: {
                            weight: 'bold', // Makes the post names bold
                        },
                    },
                },
            },
            plugins: {
                legend: {
                    labels: {
                        font: {
                            size: 12,
                        },
                    },
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label.bold();
                        }
                    }
                }
            },
        }
    });
</script>


                </div>
            </div>

            
        </div>
    </div>

    <?php include('../includes/footer.php'); ?>
            <script src="../assets/js/jquery.min.js"></script>
            <script src="../assets/js/jquery.core.js"></script>
            <script src="../assets/js/jquery.app.js"></script>
</body>
</html>
<?php } ?>
