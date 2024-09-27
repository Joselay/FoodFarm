<?php

define('BASE_URL', '/foodfarm/public/');
define('PROFILE', '/foodfarm/views/profile.php');
define('SIGNOUT', '/foodfarm/views/signout.php');

?>
<script defer src="./public/js/script.js"></script>
<header class="absolute inset-x-0 top-0 z-50">
    <nav class="flex items-center justify-between p-6 lg:px-8" aria-label="Global">
        <div class="flex lg:flex-1">
            <a href="/foodfarm" class="-m-1.5 p-1.5">
                <img class="h-8 w-auto" src="<?php echo BASE_URL; ?>images/logo.svg" alt="">
            </a>
        </div>

        <div class="hidden lg:flex lg:gap-x-12">
            <a href="#" class="text-sm font-semibold leading-6 text-gray-900">Features</a>
            <a href="#" class="text-sm font-semibold leading-6 text-gray-900">Marketplace</a>
            <a href="#" class="text-sm font-semibold leading-6 text-gray-900">Company</a>
        </div>
        <div class="hidden lg:flex lg:flex-1 lg:justify-end items-center gap-6">
            <?php if ($userName): ?>
                <div class="relative">
                    <button type="button" class="-m-1.5 flex items-center p-1.5" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                        <img class="h-8 w-8 rounded-full bg-gray-50" src="<?php echo htmlspecialchars($imageUrl); ?>" alt="">
                        <span class="hidden lg:flex lg:items-center">
                            <span class="ml-4 text-sm font-semibold leading-6 text-gray-900" aria-hidden="true"><?php echo htmlspecialchars($userName); ?></span>
                            <svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    </button>

                    <div id="user-menu" class="absolute right-0 z-10 mt-2.5 w-32 origin-top-right rounded-md bg-white py-2 shadow-lg ring-1 ring-gray-900/5 focus:outline-none opacity-0 pointer-events-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">

                        <a href="<?php echo PROFILE; ?>" class="block px-3 py-1 text-sm leading-6 text-gray-900" role="menuitem" tabindex="-2" id="user-menu-item-2">Profile</a>
                        <a href=" <?php echo SIGNOUT; ?>" class="block px-3 py-1 text-sm leading-6 text-gray-900" role="menuitem" tabindex="-1" id="user-menu-item-1" onclick="signOut()">Sign out</a>

                    </div>
                </div>
            <?php else: ?>
                <a href="./views/signin.php" class="text-sm font-semibold leading-6 text-gray-900">Log in <span aria-hidden="true">&rarr;</span></a>
            <?php endif; ?>
        </div>
    </nav>

</header>