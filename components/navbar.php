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


    <div class="flex h-16 items-center mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 justify-evenly">

        <!-- Mobile menu toggle, controls the 'mobileMenuOpen' state. -->
        <button type="button" class="relative rounded-md bg-white p-2 text-gray-400 lg:hidden">
            <span class="absolute -inset-0.5"></span>
            <span class="sr-only">Open menu</span>
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
        </button>

        <!-- Logo -->
        <div class="flex items-center justify-center gap-[12.5rem]">
            <div class="ml-4 flex lg:ml-0">
                <a href="/foodfarm">
                    <span class="sr-only">Your Company</span>
                    <img class="h-8 w-auto" src="http://localhost/foodfarm/public/images/logo.svg" alt="">
                </a>
            </div>

            <div class="relative mt-2 flex items-center cursor-pointer mb-2 ml-8 max-sm:hidden group">
                <svg class="absolute w-5 h-5 text-gray-500 left-[0.8rem]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>

                <input placeholder="Search..." type="text" name="search" id="search"
                    class="block w-full rounded-md border-0 py-1.5 pr-14 text-gray-900 cursor-pointer px-10 shadow-sm ring-1 outline-none ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6 group-hover:placeholder-gray-700 group-hover:bg-zinc-50"
                    style="caret-color: transparent;"
                    autocomplete="off">

                <div class="absolute inset-y-0 right-0 flex py-1.5 pr-1.5">
                    <kbd class="group-hover:text-gray-700 inline-flex items-center rounded border border-gray-200 px-1 font-sans text-xs text-gray-400">⌘K</kbd>
                </div>
            </div>



            <div class="ml-auto flex items-center">
                <?php if (!($userData)) : ?>
                    <div class="hidden lg:flex lg:flex-1 lg:items-center lg:justify-end lg:space-x-6">
                        <a href="http://localhost/foodfarm/views/signin.php" class="text-sm font-medium text-gray-700 hover:text-green-500">
                            <?= $translations['sign_in']; ?>
                        </a>
                        <span class="h-6 w-px bg-gray-200" aria-hidden="true"></span>
                        <a href="http://localhost/foodfarm/views/signup.php" class="text-sm font-medium text-gray-700 hover:text-green-500">
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

                <?php if ($userData) : ?>
                    <div class="relative ml-6 cursor-pointer text-sm group" id="user-menu-button">
                        <div class="flex items-center justify-center gap-2">
                            <button type="button" class="relative flex max-w-xs items-center rounded-full bg-gray-800 text-sm focus:outline-none" aria-expanded="false" aria-haspopup="true">
                                <span class="absolute -inset-1.5"></span>
                                <img class="h-8 w-8 rounded-full object-cover " src="<?= htmlspecialchars($userData['image_url']) ?>" alt="">
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
</nav>
<script>
    document.getElementById('search').addEventListener('click', function() {
        // Create a keyboard event for Ctrl + K
        const event = new KeyboardEvent('keydown', {
            key: 'k',
            code: 'KeyK',
            ctrlKey: true,
            bubbles: true,
            cancelable: true
        });

        // Dispatch the event
        document.dispatchEvent(event);
    });
</script>