<?php
$BASE_NAME = basename($_SERVER['REQUEST_URI']) === 'foodfarm' ? 'index.php' : basename($_SERVER['REQUEST_URI']);

$_SESSION['language'] = $_SESSION['language'] !== null ? $_SESSION['language'] : Language::English->value;

// Check if the language is being changed
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['language'])) {
    $language = $_POST['language'];
    $_SESSION['language'] = $language; // Update the session with the new language
    header("Location: " . $_SERVER['PHP_SELF']); // Redirect to refresh the page
    exit();
}

// Get the current language from the session or default to English
$language = $_SESSION['language'] ?? Language::English->value; // Using the enum for default language

// Load the corresponding language file
$languageFile = "http://localhost/foodfarm/i18n/{$language}.php";
if (file_exists($languageFile)) {
    require_once $languageFile;
}

?>


<nav aria-label="Top" class="relative z-20 bg-white bg-opacity-90 backdrop-blur-xl backdrop-filter">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center">
            <!-- Mobile menu toggle, controls the 'mobileMenuOpen' state. -->
            <button type="button" class="relative rounded-md bg-white p-2 text-gray-400 lg:hidden">
                <span class="absolute -inset-0.5"></span>
                <span class="sr-only">Open menu</span>
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>

            <!-- Logo -->
            <div class="ml-4 flex lg:ml-0">
                <a href="/foodfarm">
                    <span class="sr-only">Your Company</span>
                    <img class="h-8 w-auto" src="http://localhost/foodfarm/public/images/logo.svg" alt="">
                </a>
            </div>

            <!-- Flyout menus -->


            <div class="ml-auto flex items-center">
                <?php if (!($userData)) : ?>
                    <div class="hidden lg:flex lg:flex-1 lg:items-center lg:justify-end lg:space-x-6">
                        <a href="./views/signin.php" class="text-sm font-medium text-gray-700 hover:text-green-500">
                            <?= $translations['sign_in']; ?>
                        </a>
                        <span class="h-6 w-px bg-gray-200" aria-hidden="true"></span>
                        <a href="./views/signup.php" class="text-sm font-medium text-gray-700 hover:text-green-500">
                            <?= $translations['create_account_title'] ?>
                        </a>
                    </div>
                <?php endif; ?>



                <div class="hidden lg:ml-8 lg:flex">
                    <form method="POST" action="<?= $BASE_NAME; ?>">
                        <input type="hidden" name="language" value="<?php echo $_SESSION['language'] === Language::English->value ? Language::Khmer->value : Language::English->value; ?>">
                        <button type="submit" class="flex items-center text-gray-700 hover:text-gray-800">
                            <img src="http://localhost/foodfarm/public/images/<?php echo $_SESSION['language'] === Language::Khmer->value ? 'khmer.webp' : 'english.svg'; ?>" class="w-8 h-6" alt="">
                            <span class="ml-3 block text-sm font-medium hover:text-green-500">
                                <?= $_SESSION['language'] === Language::English->value ? 'EN' : 'KH'; ?>
                            </span>
                            <span class="sr-only">, change language</span>
                        </button>
                    </form>
                </div>


                <div class="flex relative lg:ml-6 items-center justify-center cursor-pointer">
                    <a href="#" class="p-2 text-gray-400 hover:text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                        </svg>
                    </a>
                    <div class="absolute w-4 h-4 top-[5px] right-[2px] rounded-full flex items-center justify-center text-sm">
                        <span class=" rounded-full h-full text-center block w-full text-xs  font-medium text-gray-700 group-hover:text-gray-800 bg-green-500 text-white">0</span>
                    </div>
                </div>

                <!-- Cart -->
                <div class="ml-4 flow-root lg:ml-6 relative cursor-pointer">
                    <a href="#" class="group -m-2 flex items-center p-2">
                        <svg class="h-6 w-6 flex-shrink-0 text-gray-400 group-hover:text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                        </svg>
                    </a>
                    <div class="absolute w-4 h-4 top-[-3px] right-[-5px] rounded-full flex items-center justify-center text-sm">
                        <span class=" rounded-full h-full text-center block w-full text-xs  font-medium text-gray-700 group-hover:text-gray-800 bg-green-500 text-white">0</span>
                    </div>
                </div>

                <?php if ($userData) : ?>
                    <div class="relative ml-6 cursor-pointer text-sm group" id="user-menu-button">
                        <div class="flex items-center justify-center gap-2">
                            <button type="button" class="relative flex max-w-xs items-center rounded-full bg-gray-800 text-sm focus:outline-none " aria-expanded="false" aria-haspopup="true">
                                <span class="absolute -inset-1.5"></span>
                                <span class="sr-only">Open user menu</span>
                                <img class="h-8 w-8 rounded-full" src="<?= htmlspecialchars($userData['image_url']) ?>" alt="">

                            </button>
                            <span class="font-medium ml-1 group-hover:text-gray-600"><?= $userData['username'] ?></span>
                            <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                            </svg>
                        </div>

                        <!-- Dropdown menu -->
                        <div id="menu" class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg hidden" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                            <a href="http://localhost/foodfarm/views/profile.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-zinc-50" role="menuitem" tabindex="-1" id="user-menu-item-0">
                                <?= $translations['your_profile']; ?>
                            </a>
                            <a href="http://localhost/foodfarm/views/orders.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-zinc-50" role="menuitem" tabindex="-1" id="user-menu-item-1"> <?= $translations['your_orders']; ?>
                            </a>
                            <a href="http://localhost/foodfarm/views/signout.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-zinc-50" role="menuitem" tabindex="-1" id="user-menu-item-2"> <?= $translations['sign_out']; ?>
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>