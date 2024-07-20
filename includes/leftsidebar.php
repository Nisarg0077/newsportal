<div class="left side-menu bg-gray-800 text-white min-h-screen w-64">
    <div class="sidebar-inner slimscrollleft">
        <!-- Sidemenu -->
        <div id="sidebar-menu">
            <ul>
                <li class="menu-title text-lg font-semibold p-4">Navigation</li>

                <li class="has_sub">
                    <a href="dashboard.php" class="block py-2.5 px-4 hover:bg-gray-700 flex items-center">
                        <i class="mdi mdi-view-dashboard mr-3"></i>
                        <span> Dashboard </span>
                    </a>
                </li>

                <?php if ($_SESSION['utype'] == '1'): ?>
                    <li class="has_sub">
                        <a href="javascript:void(0);" class="block py-2.5 px-4 hover:bg-gray-700 flex items-center">
                            <i class="mdi mdi-format-list-bulleted mr-3"></i>
                            <span> Sub-admins </span>
                            <span class="menu-arrow ml-auto"></span>
                        </a>
                        <ul class="list-unstyled ml-6">
                            <li><a href="add-subadmins.php" class="block py-2.5 px-4 hover:bg-gray-700">Add Sub-admin</a></li>
                            <li><a href="manage-subadmins.php" class="block py-2.5 px-4 hover:bg-gray-700">Manage Sub-admin</a></li>
                        </ul>
                    </li>
                <?php endif; ?>

                <li class="has_sub">
                    <a href="javascript:void(0);" class="block py-2.5 px-4 hover:bg-gray-700 flex items-center">
                        <i class="mdi mdi-format-list-bulleted mr-3"></i>
                        <span> Category </span>
                        <span class="menu-arrow ml-auto"></span>
                    </a>
                    <ul class="list-unstyled ml-6">
                        <li><a href="add-category.php" class="block py-2.5 px-4 hover:bg-gray-700">Add Category</a></li>
                        <li><a href="manage-categories.php" class="block py-2.5 px-4 hover:bg-gray-700">Manage Category</a></li>
                    </ul>
                </li>

                <li class="has_sub">
                    <a href="javascript:void(0);" class="block py-2.5 px-4 hover:bg-gray-700 flex items-center">
                        <i class="mdi mdi-format-list-bulleted mr-3"></i>
                        <span> Sub Category </span>
                        <span class="menu-arrow ml-auto"></span>
                    </a>
                    <ul class="list-unstyled ml-6">
                        <li><a href="add-subcategory.php" class="block py-2.5 px-4 hover:bg-gray-700">Add Sub Category</a></li>
                        <li><a href="manage-subcategories.php" class="block py-2.5 px-4 hover:bg-gray-700">Manage Sub Category</a></li>
                    </ul>
                </li>

                <li class="has_sub">
                    <a href="javascript:void(0);" class="block py-2.5 px-4 hover:bg-gray-700 flex items-center">
                        <i class="mdi mdi-format-list-bulleted mr-3"></i>
                        <span> Posts (News) </span>
                        <span class="menu-arrow ml-auto"></span>
                    </a>
                    <ul class="list-unstyled ml-6">
                        <li><a href="add-post.php" class="block py-2.5 px-4 hover:bg-gray-700">Add Posts</a></li>
                        <li><a href="manage-posts.php" class="block py-2.5 px-4 hover:bg-gray-700">Manage Posts</a></li>
                        <li><a href="trash-posts.php" class="block py-2.5 px-4 hover:bg-gray-700">Trash Posts</a></li>
                    </ul>
                </li>

                <li class="has_sub">
                    <a href="javascript:void(0);" class="block py-2.5 px-4 hover:bg-gray-700 flex items-center">
                        <i class="mdi mdi-format-list-bulleted mr-3"></i>
                        <span> Pages </span>
                        <span class="menu-arrow ml-auto"></span>
                    </a>
                    <ul class="list-unstyled ml-6">
                        <li><a href="aboutus.php" class="block py-2.5 px-4 hover:bg-gray-700">About us</a></li>
                        <li><a href="contactus.php" class="block py-2.5 px-4 hover:bg-gray-700">Contact us</a></li>
                    </ul>
                </li>

                <li class="has_sub">
                    <a href="javascript:void(0);" class="block py-2.5 px-4 hover:bg-gray-700 flex items-center">
                        <i class="mdi mdi-format-list-bulleted mr-3"></i>
                        <span> Comments </span>
                        <span class="menu-arrow ml-auto"></span>
                    </a>
                    <ul class="list-unstyled ml-6">
                        <li><a href="unapprove-comment.php" class="block py-2.5 px-4 hover:bg-gray-700">Waiting for Approval</a></li>
                        <li><a href="manage-comments.php" class="block py-2.5 px-4 hover:bg-gray-700">Approved Comments</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
        <div class="clearfix"></div>
    </div>
    <!-- Sidebar -left -->
</div>
