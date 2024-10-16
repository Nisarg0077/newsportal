<div class="flex items-center min-w-full justify-between bg-gray-800 px-2">
    <!-- LOGO -->
    <div class="flex justify-start items-center">
        <a href="admin.php" class="text-white text-2xl font-bold flex items-center">
            <span>NEWS<span class="text-yellow-500"> EVERYDAY</span></span>
        </a>
        <button id="toggleButton" class=" p-2 border border-transparent ml-3 rounded hover:bg-gray-800 focus:outline-none">
            <i class="fa-solid fa-bars text-white text-2xl"></i>
        </button>

        
    </div>

    <!-- Right(Notification) -->
    <div class="flex items-center">
        <div class="relative">
            <a href="#" class="flex items-center text-white" id="user-menu-button" aria-expanded="true">
                <img src="../assets/images/users/man-user-circle-icon.png" alt="user-img" class="w-8 h-8 rounded-full">
            </a>

            <!-- Dropdown -->
            <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 hidden" id="user-menu">
                <p class="px-4 py-2 text-gray-700">Hi, Admin</p>
                <a href="logout.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Logout</a>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('user-menu-button').addEventListener('click', function() {
        const userMenu = document.getElementById('user-menu');
        userMenu.classList.toggle('hidden');
    });
</script>