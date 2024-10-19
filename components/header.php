<?php
define('BASE_URL', '/foodfarm/public/');
define('PROFILE', '/foodfarm/views/profile.php');
define('SIGNOUT', '/foodfarm/views/signout.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the language is being changed
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['language'])) {
    $language = $_POST['language'];
    $_SESSION['language'] = $language; // Update the session with the new language
    header("Location: " . $_SERVER['PHP_SELF']); // Redirect to refresh the page
    exit();
}
require "../utils/language.php";

// Get the current language from the session or default to English
$language = $_SESSION['language'] ?? Language::English->value; // Using the enum for default language

// Load the corresponding language file
$languageFile = "../i18n/{$language}.php";
if (file_exists($languageFile)) {
    require_once $languageFile;
} else {
    require_once "../i18n/en-US.php";
}


?>

<script defer src="./public/js/script.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
<header class="absolute inset-x-0 top-0 z-50">
    <nav class="flex items-center justify-between p-6 lg:px-8" aria-label="Global">
        <div class="flex lg:flex-1">
            <a href="/foodfarm" class="-m-1.5 p-1.5">
                <img class="h-8 w-auto" src="<?php echo BASE_URL; ?>images/logo.svg" alt="">
            </a>
        </div>
        <div class="flex justify-center items-center gap-6">
            <div class="flex justify-center items-center gap-6">
                <div class="hidden lg:flex">
                    <form method="POST" action="<?php echo htmlspecialchars($params); ?>">
                        <input type="hidden" name="language" value="<?php echo $language === 'en-US' ? 'km-KH' : 'en-US'; ?>">
                        <button type="submit" class="flex items-center text-gray-700 hover:text-gray-800">
                            <img src="../public/images/<?php echo $language === 'km-KH' ? 'khmer.webp' : 'english.svg'; ?>" class="w-8 h-6" alt="">
                            <span class="ml-2 block text-sm font-medium hover:text-green-500">
                                <?php echo htmlspecialchars($language === 'en-US' ? "EN" : "KH"); ?>
                            </span>
                            <span class="sr-only">, change language</span>
                        </button>
                    </form>
                </div>

                <!-- Cart -->
                <div class="flow-root">
                    <a href="#" class="group -m-2 flex items-center p-2">
                        <svg class="h-6 w-6 flex-shrink-0 text-gray-400 group-hover:text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                        </svg>
                        <span class="ml-2 text-sm font-medium text-gray-700 group-hover:text-gray-800">0</span>
                        <span class="sr-only">items in cart, view bag</span>
                    </a>
                </div>
            </div>

            <div class="hidden lg:flex lg:flex-1 lg:justify-end items-center gap-6">
                <?php if (isset($userName)): ?>
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

                        <div id="user-menu" class="menu absolute right-0 z-10 mt-2.5 w-32 origin-top-right rounded-md bg-white py-2 shadow-lg ring-1 ring-gray-900/5 focus:outline-none opacity-0 pointer-events-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                            <a href="<?php echo SIGNOUT; ?>" class="block px-3 py-1 text-sm leading-6 text-gray-900 hover:bg-zinc-50" role="menuitem" tabindex="-1" id="user-menu-item-1" onclick="signOut()">
                                <?php echo $translations['sign_out']; ?>
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="./views/signin.php" class="text-sm font-semibold leading-6 text-gray-900">Log in <span aria-hidden="true">&rarr;</span></a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
</header>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const userMenuButton = document.getElementById("user-menu-button");
        const dropdownMenu = document.getElementById("user-menu");

        userMenuButton.addEventListener("click", function() {
            const isHidden = dropdownMenu.classList.contains("opacity-0");

            if (isHidden) {
                dropdownMenu.classList.remove("opacity-0", "pointer-events-none");
                gsap.fromTo(dropdownMenu, {
                    opacity: 0,
                    scaleY: 0
                }, {
                    opacity: 1,
                    scaleY: 1,
                    duration: 0.3,
                    transformOrigin: "top",
                    ease: "power2.out"
                });
            } else {
                gsap.to(dropdownMenu, {
                    opacity: 0,
                    scaleY: 0,
                    duration: 0.3,
                    onComplete: () => dropdownMenu.classList.add("opacity-0", "pointer-events-none")
                });
            }
        });

        document.addEventListener("click", function(event) {
            if (!userMenuButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
                gsap.to(dropdownMenu, {
                    opacity: 0,
                    scaleY: 0,
                    duration: 0.3,
                    onComplete: () => dropdownMenu.classList.add("opacity-0", "pointer-events-none")
                });
            }
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        const images = document.querySelectorAll('.image');

        images.forEach((image, index) => {
            gsap.fromTo(image, {
                opacity: 0,
                scale: 0
            }, {
                opacity: 1,
                scale: 1,
                duration: 0.8,
            });
        });
    });

    function signOut() {
        document.cookie = 'user=; Max-Age=0; path=/';
        window.location.href = './views/signup.php';
    }
</script>