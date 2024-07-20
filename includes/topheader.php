<header class="bg-gray-900 text-white fixed w-full top-0 z-50">
    <div class="container mx-auto flex justify-between items-center p-4">
        <!-- LOGO -->
        <a href="index.html" class="text-lg font-semibold text-blue-600 flex items-center">
            <span>NEWS<span class="font-normal">PORTAL</span></span>
            <i class="mdi mdi-layers ml-2"></i>
        </a>
        <!-- Mobile Menu Button -->
        <button class="md:hidden flex items-center p-2 border rounded text-blue-600 border-blue-600 hover:text-white hover:bg-blue-600" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <i class="mdi mdi-menu text-2xl"></i>
        </button>
    </div>

    <div class="container mx-auto hidden md:flex justify-between items-center" id="navbarResponsive">
        <!-- Navbar-left -->
        <ul class="flex items-center space-x-4 md:space-x-6">
            <li>
                <button class="text-blue-600 hover:text-blue-800 focus:outline-none">
                    <i class="mdi mdi-menu text-2xl"></i>
                </button>
            </li>
        </ul>

        <!-- Right(Notification) -->
        <ul class="flex items-center space-x-4 md:space-x-6 ml-auto">
            <li class="relative">
                <a href="#" class="flex items-center">
                    <img src="assets/images/users/avatar-1.jpg" alt="user-img" class="w-8 h-8 rounded-full">
                </a>
                <ul class="absolute right-0 mt-2 w-48 bg-white shadow-lg rounded-lg py-2 hidden group-hover:block">
                    <li class="px-4 py-2 text-gray-800">
                        <h5>Hi, Admin</h5>
                    </li>
                    <li class="px-4 py-2 hover:bg-gray-200">
                        <a href="change-password.php" class="flex items-center text-gray-600">
                            <i class="ti-settings mr-2"></i> Change Password
                        </a>
                    </li>
                    <li class="px-4 py-2 hover:bg-gray-200">
                        <a href="logout.php" class="flex items-center text-gray-600">
                            <i class="ti-power-off mr-2"></i> Logout
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</header>

<script>
    // Toggle the menu on mobile
    document.querySelector('button[aria-controls="navbarResponsive"]').addEventListener('click', function () {
        document.getElementById('navbarResponsive').classList.toggle('hidden');
    });
</script>
