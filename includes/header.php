<nav class="navbar relative flex items-center justify-between py-4 px-6 bg-gray-900 text-white shadow-md">
    <div class="container mx-auto flex items-center justify-between">
        <!-- Logo -->
        <a href="index.php" class="flex items-center text-2">
            <!-- <img src="" alt="Logo" class="h-10" > -->
             News Everyday
        </a>

        <!-- Mobile Menu Button -->
        <button class="md:hidden flex items-center p-2 border border-transparent rounded hover:bg-gray-800 focus:outline-none" type="button" aria-controls="navbarResponsive" aria-expanded="false">
            <i class="mdi mdi-menu text-white text-2xl"></i>
        </button>

        <!-- Navbar Links for Desktop -->
        <div class="hidden md:flex md:items-center md:space-x-6">
            <ul class="flex list-none mb-0">
                <li>
                    <a href="index.php" class="block py-2 px-4 rounded hover:bg-gray-700 transition duration-300">Home</a>
                </li>
                <li>
                    <a href="about-us.php" class="block py-2 px-4 rounded hover:bg-gray-700 transition duration-300">About</a>
                </li>
                <li>
                    <a href="index.php" class="block py-2 px-4 rounded hover:bg-gray-700 transition duration-300">News</a>
                </li>
                <li>
                    <a href="contact-us.php" class="block py-2 px-4 rounded hover:bg-gray-700 transition duration-300">Contact Us</a>
                </li>
                <li>
                    <a href="../../ProjectNews/Admin/LogIn.php" class="block py-2 px-4 rounded hover:bg-gray-700 transition duration-300">Admin</a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Mobile Menu Dropdown -->
    <div class="md:hidden">
        <div id="navbarResponsive" class="absolute top-16 left-0 w-full bg-gray-900 text-white shadow-lg hidden">
            <ul class="flex flex-col items-center py-4">
                <li>
                    <a href="index.php" class="block py-2 px-4 hover:bg-gray-700 transition duration-300 w-full text-center">Home</a>
                </li>
                <li>
                    <a href="about-us.php" class="block py-2 px-4 hover:bg-gray-700 transition duration-300 w-full text-center">About</a>
                </li>
                <li>
                    <a href="index.php" class="block py-2 px-4 hover:bg-gray-700 transition duration-300 w-full text-center">News</a>
                </li>
                <li>
                    <a href="contact-us.php" class="block py-2 px-4 hover:bg-gray-700 transition duration-300 w-full text-center">Contact Us</a>
                </li>
                <li>
                    <a href="admin/" class="block py-2 px-4 hover:bg-gray-700 transition duration-300 w-full text-center">Admin</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<script>
    document.querySelector('button[aria-controls="navbarResponsive"]').addEventListener('click', function () {
        const menu = document.getElementById('navbarResponsive');
        menu.classList.toggle('hidden');
    });
</script>
