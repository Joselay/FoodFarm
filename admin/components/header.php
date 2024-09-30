<?php
require_once "../utils/dd.php";

$current_page = basename($_SERVER['REQUEST_URI'], ".php");

?>

<header class="sticky inset-x-0 top-0 z-50">
    <nav
        class="flex items-center justify-between p-6 lg:px-8"
        aria-label="Global">
        <div class="flex lg:flex-1">
            <a href="/foodfarm/admin" class="-m-1.5 p-1.5">
                <img
                    class="h-8 w-auto"
                    src="../public/images/logo.svg"
                    alt="" />
            </a>
        </div>
        <div class="hidden lg:flex lg:gap-x-12">
            <?php
            $current_page = basename($_SERVER['REQUEST_URI'], ".php");
            ?>

            <a href="./products.php" class="text-sm font-semibold leading-6 <?php echo $current_page === 'products' ? 'text-green-500' : 'text-gray-900'; ?> hover:text-green-500">Products</a>
            <a href="./users.php" class="text-sm font-semibold leading-6 <?php echo $current_page === 'users' ? 'text-green-500' : 'text-gray-900'; ?> hover:text-green-500">Users</a>
            <a href="./orders.php" class="text-sm font-semibold leading-6 <?php echo $current_page === 'orders' ? 'text-green-500' : 'text-gray-900'; ?> hover:text-green-500">Orders</a>

        </div>
        <div class="hidden lg:flex lg:flex-1 lg:justify-end justify-center items-center gap-2">
            <img class="inline-block h-8 w-8 rounded-full object-cover" src="https://cdn.oneesports.gg/cdn-data/2023/04/Anime_DemonSlayer_Muzan_3-450x253.jpg" alt="">
            <span class="text-sm">Admin</span>
        </div>
    </nav>

</header>