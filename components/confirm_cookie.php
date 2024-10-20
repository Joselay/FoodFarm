<?php
require "./utils/dd.php";

// Load the language file based on the current session's language
$languageFile = "http://localhost/foodfarm/i18n/{$_SESSION['language']}.php"; // Adjust path as necessary
if (file_exists($languageFile)) {
    $translations = require $languageFile;
}

// Fetch the cookie policy translation and create the link
$cookiePolicyText = $translations['cookie_policy'];
$cookiePolicyLink = '<a href="#" class="font-semibold text-green-600">' . $cookiePolicyText . '</a>';



// Fetch the confirm cookie message
$confirmCookieMessage = str_replace('{cookie_policy}', $cookiePolicyLink, $translations['confirm_cookie']);
?>

<!DOCTYPE html>
<html lang="<?= $_SESSION['language'] === Language::Khmer->value ? 'km' : 'en'; ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Kantumruy+Pro:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
</head>

<body style="font-family: 'Inter';">
    <div id="banner" class="pointer-events-none fixed inset-x-0 bottom-0 px-6 pb-6 z-[100]">
        <div class="pointer-events-auto ml-auto max-w-xl rounded-xl bg-white p-6 shadow-lg ring-1 ring-gray-900/10">
            <p class="text-sm leading-6 text-gray-900"><?= $confirmCookieMessage; ?></p>
            <div class="mt-4 flex items-center gap-x-5">
                <button id="accept" type="button" class="rounded-md bg-gray-900 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-900">Accept all</button>
                <button type="button" class="text-sm font-semibold leading-6 text-gray-900">Reject all</button>
            </div>
        </div>
    </div>
</body>

<script>
    // Animate the banner in when the page loads
    gsap.from("#banner", {
        y: 100,
        opacity: 0,
        duration: 0.5,
        ease: "power3.out"
    });

    const accept = document.querySelector('#accept');
    const banner = document.querySelector('#banner');

    accept.addEventListener('click', () => {
        // Animate the banner out
        gsap.to(banner, {
            y: 100,
            opacity: 0,
            duration: 0.2,
            ease: "power3.in",
            onComplete: () => {
                banner.classList.add('hidden'); // Hide the element after the animation
            }
        });
    });
</script>

</html>