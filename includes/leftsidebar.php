<!-- Sidebar -->
<div   class="left side-menu bg-gray-800 text-white h-full z-20  w-64 md:block">
        <div class="sidebar-inner slimscrollleft">
            <div id="sidebar-menu">
                <ul>
                    <li class="has_sub">
                        <a href="../Admin/admin.php" class="block py-1.5 px-4 hover:bg-gray-700 flex items-center">
                            <i class="fa-solid fa-gauge mr-3"></i>
                            <span> Dashboard </span>
                        </a>
                    </li>

                    <?php if($_SESSION['utype']=='1'): ?>
                        <li class="has_sub">
                            <a href="javascript:void(0);" class="block py-1.5 px-4 hover:bg-gray-700 flex items-center justify-between">
                                <div class="flex items-center">
                                    <i class="fa-solid fa-list mr-3"></i>
                                    <span> Sub-admins </span>
                                </div>
                                <i class="fas fa-chevron-right ml-auto"></i>
                            </a>
                            <ul class="list-unstyled ml-6 hidden">
                                <li><a href="add-subadmins.php" style="font-size: .9rem;" class="block py-1.5 px-4 hover:bg-gray-700">Add Sub-admin</a></li>
                                <li><a href="manage-subadmins.php" style="font-size: .9rem;" class="block py-1.5 px-4 hover:bg-gray-700">Manage Sub-admin</a></li>
                            </ul>
                        </li>
                    <?php endif; ?>

                    <li class="has_sub">
                        <a href="javascript:void(0);" class="block py-1.5 px-4 hover:bg-gray-700 flex items-center justify-between">
                            <div class="flex items-center">
                                <i class="fa-solid fa-list mr-3"></i>
                                <span> Category </span>
                            </div>
                            <i class="fas fa-chevron-right menu-arrow ml-auto"></i>
                        </a>
                        <ul class="list-unstyled ml-6 hidden">
                            <li><a href="add-category.php" style="font-size: .9rem;" class="block py-1.5 px-4  hover:bg-gray-700">Add Category</a></li>
                            <li><a href="../Admin/manage-categories.php" style="font-size: .9rem;" class="block py-1.5 px-4 hover:bg-gray-700">Manage Category</a></li>
                        </ul>
                    </li>

                    <li class="has_sub">
                        <a href="javascript:void(0);" class="block py-1.5 px-4 hover:bg-gray-700 flex items-center justify-between">
                            <div class="flex items-center">
                                <i class="fa-solid fa-list mr-3"></i>
                                <span> Sub Category </span>
                            </div>
                            <i class="fas fa-chevron-right menu-arrow ml-auto"></i>
                        </a>
                        <ul class="list-unstyled ml-6 hidden">
                            <li><a href="add-subcategory.php" style="font-size: .9rem;" class="block py-1.5 px-4 hover:bg-gray-700">Add Sub Category</a></li>
                            <li><a href="manage-subcategories.php" style="font-size: .9rem;" class="block py-1.5 px-4 hover:bg-gray-700">Manage Sub Category</a></li>
                        </ul>
                    </li>

                    <li class="has_sub">
                        <a href="javascript:void(0);" class="block py-1.5 px-4 hover:bg-gray-700 flex items-center justify-between">
                            <div class="flex items-center">
                                <i class="fa-solid fa-list mr-3"></i>
                                <span> Posts (News) </span>
                            </div>
                            <i class="fas fa-chevron-right menu-arrow ml-auto"></i>
                        </a>
                        <ul class="list-unstyled ml-6 hidden">
                            <li><a href="add-post.php" style="font-size: .9rem;" class="block py-1.5 px-4 hover:bg-gray-700">Add Posts</a></li>
                            <li><a href="manage-posts.php" style="font-size: .9rem;" class="block py-1.5 px-4 hover:bg-gray-700">Manage Posts</a></li>
                            <li><a href="trash-posts.php" style="font-size: .9rem;" class="block py-1.5 px-4 hover:bg-gray-700">Trash Posts</a></li>
                        </ul>
                    </li>

                    <li class="has_sub">
                        <a href="javascript:void(0);" class="block py-1.5 px-4 hover:bg-gray-700 flex items-center justify-between">
                            <div class="flex items-center">
                                <i class="fa-solid fa-list mr-3"></i>
                                <span> Pages </span>
                            </div>
                            <i class="fas fa-chevron-right menu-arrow ml-auto"></i>
                        </a>
                        <ul class="list-unstyled ml-6 hidden">
                            <li><a href="aboutus.php" style="font-size: .9rem;" class="block py-1.5 px-4 hover:bg-gray-700">About us</a></li>
                            <li><a href="contactus.php" style="font-size: .9rem;" class="block py-1.5 px-4 hover:bg-gray-700">Contact us</a></li>
                        </ul>
                    </li>
                    
                    <?php if($_SESSION['utype']=='1'): ?>
                    <li class="has_sub">
                        <a href="javascript:void(0);" class="block py-1.5 px-4 hover:bg-gray-700 flex items-center justify-between">
                            <div class="flex items-center">
                                <i class="fa-solid fa-list mr-3"></i>
                                <span> Comments </span>
                            </div>
                            <i class="fas fa-chevron-right menu-arrow ml-auto"></i>
                        </a>
                        <ul class="list-unstyled ml-6 hidden">
                            <li><a href="unapprove-comment.php" style="font-size: .9rem;" class="block py-1.5 px-4 hover:bg-gray-700">Waiting for Approval</a></li>
                            <li><a href="manage-comments.php" style="font-size: .9rem;" class="block py-1.5 px-4 hover:bg-gray-700">Approved Comments</a></li>
                        </ul>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
            <!-- Sidebar -->
            <div class="clearfix"></div>
        </div>
        <!-- Sidebar -left -->
    </div>