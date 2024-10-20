<?php
require "./utils/language.php";

?>

<script src="https://cdn.tailwindcss.com"></script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Kantumruy+Pro:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">

<div class="relative hidden z-[200]" id="command-palette" role="dialog" aria-modal="true">
  <div class="fixed inset-0 bg-gray-500 bg-opacity-25 transition-opacity" aria-hidden="true"></div>
  <div class="fixed inset-0 z-10 w-screen overflow-y-auto p-4 sm:p-6 md:p-20">
    <div class="mx-auto max-w-2xl transform divide-y divide-gray-500 divide-opacity-10 overflow-hidden rounded-xl bg-white bg-opacity-80 shadow-2xl ring-1 ring-black ring-opacity-5 backdrop-blur backdrop-filter transition-all mt-[5rem]">
      <div class="relative">
        <svg class="pointer-events-none absolute left-4 top-3.5 h-5 w-5 text-gray-900 text-opacity-40" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
          <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
        </svg>
        <input type="text" class="h-12 w-full border-0 bg-transparent pl-11 pr-4 text-gray-900 outline-none sm:text-sm" placeholder="Search...">
      </div>
      <ul id="command-options" class="max-h-80 scroll-py-2 divide-y divide-gray-500 divide-opacity-10 overflow-y-auto">
        <li class="p-2">
          <ul class="text-sm text-gray-700">
            <a href="http://localhost/foodfarm/views/profile.php">
              <li class="hover:bg-gray-900 hover:bg-opacity-5 hover:text-gray-900 group flex cursor-default select-none items-center rounded-md px-3 py-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>

                <span class="ml-3 flex-auto truncate">
                  <?= $translations['profile'] ?>
                </span>
                <span class="ml-3 flex-none text-xs font-semibold text-gray-500"><kbd class="font-sans">⌘</kbd><kbd class="font-sans">B</kbd></span>
              </li>
            </a>
            <a href="http://localhost/foodfarm/views/orders.php">
              <li class="hover:bg-gray-900 hover:bg-opacity-5 hover:text-gray-900 group flex cursor-default select-none items-center rounded-md px-3 py-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                </svg>
                <span class="ml-3 flex-auto truncate">
                  <?= $translations['orders'] ?>
                </span>
                <span class="ml-3 flex-none text-xs font-semibold text-gray-500"><kbd class="font-sans">⌘</kbd><kbd class="font-sans">A</kbd></span>
              </li>
            </a>

            <a href="http://localhost/foodfarm/views/cart.php">
              <li class="hover:bg-gray-900 hover:bg-opacity-5 hover:text-gray-900 group flex cursor-default select-none items-center rounded-md px-3 py-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                </svg>

                <span class="ml-3 flex-auto truncate">
                  <?= $translations['cart'] ?>
                </span>
                <span class="ml-3 flex-none text-xs font-semibold text-gray-500"><kbd class="font-sans">⌘</kbd><kbd class="font-sans">N</kbd></span>
              </li>
            </a>

            <a href="http://localhost/foodfarm/views/profile.php">
              <li class="hover:bg-gray-900 hover:bg-opacity-5 hover:text-gray-900 group flex cursor-default select-none items-center rounded-md px-3 py-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                </svg>
                <span class="ml-3 flex-auto truncate">
                  <?= $translations['sign_out'] ?>
                </span>
                <span class="ml-3 flex-none text-xs font-semibold text-gray-500"><kbd class="font-sans">⌘</kbd><kbd class="font-sans">F</kbd></span>
              </li>
            </a>

          </ul>
        </li>
      </ul>
    </div>
  </div>
</div>
<script>
  const commandPalette = document.getElementById('command-palette');
  const commandOptions = document.getElementById('command-options');
  const options = commandOptions.querySelectorAll('li');
  let selectedIndex = -1;

  document.addEventListener('keydown', (event) => {
    if (event.ctrlKey && event.key === 'k') {
      event.preventDefault();
      commandPalette.style.display = 'block';
      document.querySelector('input[type="text"]').focus();
    }
    if (event.key === 'Escape') {
      commandPalette.style.display = 'none';
      selectedIndex = -1;
    }

    if (commandPalette.style.display === 'block') {
      if (event.key === 'ArrowDown') {
        event.preventDefault();
        if (selectedIndex < options.length - 1) {
          selectedIndex++;
        }
        updateSelection();
      } else if (event.key === 'ArrowUp') {
        event.preventDefault();
        if (selectedIndex > 0) {
          selectedIndex--;
        }
        updateSelection();
      }

      if (event.key === 'Enter') {
        event.preventDefault();
        if (selectedIndex >= 0 && selectedIndex < options.length) {
          const selectedOption = options[selectedIndex].textContent;
          console.log('Selected:', selectedOption);
          commandPalette.style.display = 'none';
          selectedIndex = -1;
        }
      }
    }
  });

  function updateSelection() {
    options.forEach((option, index) => {
      if (index === selectedIndex) {
        option.classList.add('bg-gray-900', 'bg-opacity-5', 'text-gray-900');
      } else {
        option.classList.remove('bg-gray-900', 'bg-opacity-5', 'text-gray-900');
      }
    });
  }
</script>