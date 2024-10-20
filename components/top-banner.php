<!DOCTYPE html>
<html lang="en">

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

<body>
    <div id="top-banner" class="flex items-center gap-x-6 bg-green-600 px-6 py-2.5 sm:px-3.5 sm:before:flex-1">
        <p class="text-sm leading-6 text-white">
            <a href="#">
                <strong class="font-semibold">FoodFarm 2024</strong><svg viewBox="0 0 2 2" class="mx-2 inline h-0.5 w-0.5 fill-current" aria-hidden="true">
                    <circle cx="1" cy="1" r="1" />
                </svg>Discover the freshest fruits and embrace a sustainable lifestyle.

                <span aria-hidden="true">🚀</span>
            </a>
        </p>
        <div class="flex flex-1 justify-end">
            <button id="close" type="button" class="-m-3 p-3 focus-visible:outline-offset-[-4px]">
                <span class="sr-only">Dismiss</span>
                <svg class="h-5 w-5 text-white hover:text-gray-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                </svg>
            </button>
        </div>
    </div>

    <script>
        const close = document.querySelector('#close');
        const topBanner = document.querySelector('#top-banner');

        close.addEventListener('click', () => {
            gsap.fromTo(topBanner, {
                opacity: 1,
                y: 0
            }, {
                opacity: 0,
                y: -100,
                duration: 0.5,
                ease: "power3.in",
                onComplete: () => {
                    topBanner.classList.add('hidden');
                }
            });
        });
    </script>

</body>

</html>