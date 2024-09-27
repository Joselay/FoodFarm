<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ./views/signin.php");
    exit();
}

// Retrieve the username from the session
$userName = $_SESSION['user_username']; // Use the same variable name as the one you refer to later
$imageUrl = $_SESSION['user_image_url'];


?>


<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>


<div class="bg-white">
    <header class="absolute inset-x-0 top-0 z-50">
        <nav class="flex items-center justify-between p-6 lg:px-8" aria-label="Global">
            <div class="flex lg:flex-1">
                <a href="#" class="-m-1.5 p-1.5">
                    <span class="sr-only">Your Company</span>
                    <img class="h-8 w-auto" src="./public/images/logo.svg" alt="">
                </a>
            </div>
            <div class="flex lg:hidden">
                <button type="button" class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700">
                    <span class="sr-only">Open main menu</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
            </div>
            <div class="hidden lg:flex lg:gap-x-12">
                <div class="relative">
                    <button
                        type="button"
                        class="flex items-center gap-x-1 text-sm font-semibold leading-6 text-gray-900"
                        aria-expanded="false">
                        Products
                        <svg
                            class="h-5 w-5 flex-none text-gray-400"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                            aria-hidden="true">
                            <path
                                fill-rule="evenodd"
                                d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>

                    <div
                        class="absolute -left-8 top-full z-10 mt-3 w-screen max-w-md overflow-hidden rounded-3xl bg-white shadow-lg ring-1 ring-gray-900/5 hidden">
                        <div class="p-4">
                            <div
                                class="group relative flex gap-x-6 rounded-lg p-4 text-sm leading-6 hover:bg-gray-50">
                                <div
                                    class="mt-1 flex h-11 w-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                    <svg
                                        class="h-6 w-6 text-gray-600 group-hover:text-green-600"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                        aria-hidden="true">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M4 6h16M4 12h16M4 18h16" />
                                    </svg>

                                </div>
                                <div class="flex-auto">
                                    <a href="#" class="block font-semibold text-gray-900">
                                        Categories
                                        <span class="absolute inset-0"></span>
                                    </a>
                                    <p class="mt-1 text-gray-600">
                                        Find products by specific categories.
                                    </p>
                                </div>
                            </div>
                            <div
                                class="group relative flex gap-x-6 rounded-lg p-4 text-sm leading-6 hover:bg-gray-50">
                                <div
                                    class="mt-1 flex h-11 w-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                    <svg
                                        class="h-6 w-6 text-gray-600 group-hover:text-green-600"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                        aria-hidden="true">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M15.172 7.172a4 4 0 00-5.656 0l-2.828 2.828a4 4 0 005.656 5.656l2.828-2.828a4 4 0 000-5.656zM21 12c0 4.418-3.582 8-8 8-4.418 0-8-3.582-8-8 0-4.418 3.582-8 8-8 4.418 0 8 3.582 8 8z" />
                                    </svg>


                                </div>
                                <div class="flex-auto">
                                    <a href="#" class="block font-semibold text-gray-900">
                                        Popular Products
                                        <span class="absolute inset-0"></span>
                                    </a>
                                    <p class="mt-1 text-gray-600">
                                        Shop our best-selling items today!


                                    </p>
                                </div>
                            </div>
                            <div
                                class="group relative flex gap-x-6 rounded-lg p-4 text-sm leading-6 hover:bg-gray-50">
                                <div
                                    class="mt-1 flex h-11 w-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                    <svg
                                        class="h-6 w-6 text-gray-600 group-hover:text-green-600"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                        aria-hidden="true">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M12 6v6l4 2M5 12l7-7 7 7-7 7-7-7z" />
                                    </svg>

                                </div>
                                <div class="flex-auto">
                                    <a href="#" class="block font-semibold text-gray-900">
                                        New Arrivals
                                        <span class="absolute inset-0"></span>
                                    </a>
                                    <p class="mt-1 text-gray-600">
                                        Explore the latest products available.


                                    </p>
                                </div>
                            </div>
                            <div
                                class="group relative flex gap-x-6 rounded-lg p-4 text-sm leading-6 hover:bg-gray-50">
                                <div
                                    class="mt-1 flex h-11 w-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                    <svg
                                        class="h-6 w-6 text-gray-600 group-hover:text-green-600"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                        aria-hidden="true">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M12 6v6l4 2M4 6l8-4 8 4v8l-8 4-8-4V6z" />
                                    </svg>

                                </div>
                                <div class="flex-auto">
                                    <a href="#" class="block font-semibold text-gray-900">
                                        Special Offers
                                        <span class="absolute inset-0"></span>
                                    </a>
                                    <p class="mt-1 text-gray-600">
                                        Grab exclusive deals and discounts now!

                                    </p>
                                </div>
                            </div>

                        </div>
                        <div
                            class="grid grid-cols-2 divide-x divide-gray-900/5 bg-gray-50">
                            <a
                                href="#"
                                class="flex items-center justify-center gap-x-2.5 p-3 text-sm font-semibold leading-6 text-gray-900 hover:bg-gray-100">
                                <svg
                                    class="h-5 w-5 flex-none text-gray-400"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                    aria-hidden="true">
                                    <path
                                        fill-rule="evenodd"
                                        d="M2 10a8 8 0 1116 0 8 8 0 01-16 0zm6.39-2.908a.75.75 0 01.766.027l3.5 2.25a.75.75 0 010 1.262l-3.5 2.25A.75.75 0 018 12.25v-4.5a.75.75 0 01.39-.658z"
                                        clip-rule="evenodd" />
                                </svg>
                                Watch demo
                            </a>
                            <a
                                href="#"
                                class="flex items-center justify-center gap-x-2.5 p-3 text-sm font-semibold leading-6 text-gray-900 hover:bg-gray-100">
                                <svg
                                    class="h-5 w-5 flex-none text-gray-400"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                    aria-hidden="true">
                                    <path
                                        fill-rule="evenodd"
                                        d="M2 3.5A1.5 1.5 0 013.5 2h1.148a1.5 1.5 0 011.465 1.175l.716 3.223a1.5 1.5 0 01-1.052 1.767l-.933.267c-.41.117-.643.555-.48.95a11.542 11.542 0 006.254 6.254c.395.163.833-.07.95-.48l.267-.933a1.5 1.5 0 011.767-1.052l3.223.716A1.5 1.5 0 0118 15.352V16.5a1.5 1.5 0 01-1.5 1.5H15c-1.149 0-2.263-.15-3.326-.43A13.022 13.022 0 012.43 8.326 13.019 13.019 0 012 5V3.5z"
                                        clip-rule="evenodd" />
                                </svg>
                                Contact sales
                            </a>
                        </div>
                    </div>
                </div>
                <a href="#" class="text-sm font-semibold leading-6 text-gray-900">Features</a>
                <a href="#" class="text-sm font-semibold leading-6 text-gray-900">Marketplace</a>
                <a href="#" class="text-sm font-semibold leading-6 text-gray-900">Company</a>

            </div>

            <div class="hidden lg:flex lg:flex-1 lg:justify-end items-center gap-6">
                <?php if ($userName): ?>
                    <div class="relative">
                        <button type="button" class="-m-1.5 flex items-center p-1.5" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                            <span class="sr-only">Open user menu</span>
                            <img class="h-8 w-8 rounded-full bg-gray-50" src="<?php echo htmlspecialchars($imageUrl); ?>" alt="">
                            <span class="hidden lg:flex lg:items-center">
                                <span class="ml-4 text-sm font-semibold leading-6 text-gray-900" aria-hidden="true"><?php echo htmlspecialchars($userName); ?></span>
                                <svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </button>
                        <div id="user-menu" class="absolute right-0 z-10 mt-2.5 w-32 origin-top-right rounded-md bg-white py-2 shadow-lg ring-1 ring-gray-900/5 focus:outline-none opacity-0 pointer-events-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">

                            <a href="#" class="block px-3 py-1 text-sm leading-6 text-gray-900" role="menuitem" tabindex="-1" id="user-menu-item-1" onclick="signOut()">Sign out</a>

                        </div>
                    </div>
                <?php else: ?>
                    <a href="./views/signin.php" class="text-sm font-semibold leading-6 text-gray-900">Log in <span aria-hidden="true">&rarr;</span></a>
                <?php endif; ?>
            </div>
        </nav>
        <!-- Mobile menu, show/hide based on menu open state. -->
        <div class="lg:hidden" role="dialog" aria-modal="true">
            <!-- Background backdrop, show/hide based on slide-over state. -->
            <div class="fixed inset-0 z-50"></div>
            <div class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-white px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
                <div class="flex items-center justify-between">
                    <a href="#" class="-m-1.5 p-1.5">
                        <span class="sr-only">Your Company</span>
                        <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=green&shade=600" alt="">
                    </a>
                    <button type="button" class="-m-2.5 rounded-md p-2.5 text-gray-700">
                        <span class="sr-only">Close menu</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="mt-6 flow-root">
                    <div class="-my-6 divide-y divide-gray-500/10">
                        <div class="space-y-2 py-6">
                            <a href="#" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">Product</a>
                            <a href="#" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">Features</a>
                            <a href="#" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">Marketplace</a>
                            <a href="#" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">Company</a>
                        </div>
                        <div class="py-6">
                            <a href="#" class="-mx-3 block rounded-lg px-3 py-2.5 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">Log in</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="relative isolate px-6 pt-14 lg:px-8">
        <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80" aria-hidden="true">
            <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
        </div>
        <div class="mx-auto max-w-2xl py-32 sm:py-48 lg:py-56">
            <div class="hidden sm:mb-8 sm:flex sm:justify-center">
                <div class="relative rounded-full px-3 py-1 text-sm leading-6 text-gray-600 ring-1 ring-gray-900/10 hover:ring-gray-900/20">
                    Announcing our next round of funding. <a href="#" class="font-semibold text-green-600"><span class="absolute inset-0" aria-hidden="true"></span>Read more <span aria-hidden="true">&rarr;</span></a>
                </div>
            </div>
            <div class="text-center">
                <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">Fresh and Organic from the Farm</h1>
                <p class="mt-6 text-lg leading-8 text-gray-600">Discover a world of wholesome goodness at FoodFarm. We bring you the freshest, organically grown produce.</p>
                <div class="mt-10 flex items-center justify-center gap-x-6">
                    <a href="#products" class="rounded-md bg-green-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">Get started</a>
                    <a href="#" class="text-sm font-semibold leading-6 text-gray-900">Learn more <span aria-hidden="true">→</span></a>
                </div>
            </div>
        </div>
        <div class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]" aria-hidden="true">
            <div class="relative left-[calc(50%+3rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%+36rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
        </div>
    </div>
</div>
<script>
    function signOut() {
        // Redirect to signout.php which will handle session destruction
        window.location.href = './views/signout.php';
    }
    const userMenuButton = document.getElementById('user-menu-button');
    const userMenu = document.getElementById('user-menu');
    let isOpen = false;

    userMenuButton.addEventListener('click', () => {
        isOpen = !isOpen;
        userMenu.setAttribute('aria-expanded', isOpen);

        if (isOpen) {
            // Show menu with GSAP animation
            gsap.to(userMenu, {
                duration: 0.2,
                opacity: 1,
                pointerEvents: 'auto',
                ease: 'power1.out'
            });
        } else {
            // Hide menu with GSAP animation
            gsap.to(userMenu, {
                duration: 0.2,
                opacity: 0,
                pointerEvents: 'none',
                ease: 'power1.in'
            });
        }
    });

    // Optional: Close the menu if clicking outside of it
    document.addEventListener('click', (event) => {
        if (isOpen && !userMenuButton.contains(event.target) && !userMenu.contains(event.target)) {
            isOpen = false;
            gsap.to(userMenu, {
                duration: 0.3,
                opacity: 0,
                pointerEvents: 'none',
                ease: 'power1.in'
            });
            userMenuButton.setAttribute('aria-expanded', 'false');
        }
    });
    document.addEventListener("DOMContentLoaded", function() {
        // Select the button and the flyout menu
        const productButton = document.querySelector("button[aria-expanded]");
        const flyoutMenu = productButton.nextElementSibling;

        // Set initial state
        let menuVisible = false;

        // Toggle function to show/hide the flyout with animation
        function toggleMenu() {
            menuVisible = !menuVisible;

            if (menuVisible) {
                // Show the menu with animation
                flyoutMenu.classList.remove("hidden");
                gsap.fromTo(flyoutMenu, {
                    opacity: 0,
                    y: -10
                }, {
                    opacity: 1,
                    y: 0,
                    duration: 0.3
                });
            } else {
                // Hide the menu with animation
                gsap.to(flyoutMenu, {
                    opacity: 0,
                    y: -10,
                    duration: 0.3,
                    onComplete: () => {
                        flyoutMenu.classList.add("hidden");
                    }
                });
            }

            // Update aria-expanded attribute
            productButton.setAttribute("aria-expanded", menuVisible);
        }

        // Add click event listener to the product button
        productButton.addEventListener("click", toggleMenu);

        // Optional: close the menu when clicking outside of it
        document.addEventListener("click", function(event) {
            if (
                !productButton.contains(event.target) &&
                !flyoutMenu.contains(event.target)
            ) {
                if (menuVisible) {
                    toggleMenu();
                }
            }
        });
    });
</script>