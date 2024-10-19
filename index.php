<?php
require_once "./utils/language.php";
require_once './config/database.php';
require_once './enums/Language.php';

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
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
$languageFile = "./i18n/{$language}.php";
if (file_exists($languageFile)) {
  require_once $languageFile;
} else {
  require_once "./i18n/en-US.php"; // Fallback to English if file doesn't exist
}

// Fetch products
$sql = "SELECT id, name, price, image_url FROM products";
$result = $conn->query($sql);

// Check if user is logged in and get user ID from session
$userId = $_SESSION['user_id'] ?? null;
$userData = null; // Variable to hold user data

// Fetch user information if user is logged in
if ($userId) {
  $userSql = "SELECT id, username, email, image_url FROM users WHERE id = ?";
  $stmt = $conn->prepare($userSql);
  $stmt->bind_param("i", $userId); // Bind the user ID as an integer
  $stmt->execute();
  $userResult = $stmt->get_result();

  if ($userResult->num_rows > 0) {
    $userData = $userResult->fetch_assoc(); // Fetch user data
  } else {
    echo "No user found.";
  }
}


// Close the database connection
$conn->close();
?>

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
  <script src="public/js/script.js"></script>
  <style>
    html {
      scroll-behavior: smooth;
    }

    .blink {
      animation: blink 1s steps(2, start) infinite;
      font-weight: normal;
      /* Ensures cursor matches text styling */
      margin-left: 2px;
      /* Slight space between text and cursor */
    }

    @keyframes blink {

      0%,
      50% {
        opacity: 1;
      }

      51%,
      100% {
        opacity: 0;
      }
    }
  </style>


</head>

<body style="font-family: <?php echo $fontFamily; ?>;" style="font-family: 'Inter';">

  <div class="bg-white">

    <div class="relative z-40 lg:hidden" role="dialog" aria-modal="true">

      <div class="fixed inset-0 bg-black bg-opacity-25" aria-hidden="true"></div>

      <div class="fixed inset-0 z-40 flex">

        <div class="relative flex w-full max-w-xs flex-col overflow-y-auto bg-white pb-12 shadow-xl">
          <div class="flex px-4 pb-2 pt-5">
            <button type="button" class="relative -m-2 inline-flex items-center justify-center rounded-md p-2 text-gray-400">
              <span class="absolute -inset-0.5"></span>
              <span class="sr-only">Close menu</span>
              <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>

          <div class="space-y-6 border-t border-gray-200 px-4 py-6">
            <div class="flow-root">
              <a href="#" class="-m-2 block p-2 font-medium text-gray-900">Sign in</a>
            </div>
            <div class="flow-root">
              <a href="#" class="-m-2 block p-2 font-medium text-gray-900">Create account</a>
            </div>
          </div>

          <div class="border-t border-gray-200 px-4 py-6">
            <a href="#" class="-m-2 flex items-center p-2">
              <img src="https://tailwindui.com/img/flags/flag-canada.svg" alt="" class="block h-auto w-5 flex-shrink-0">
              <span class="ml-3 block text-base font-medium text-gray-900">English</span>
              <span class="sr-only">, change currency</span>
            </a>
          </div>
        </div>
      </div>
    </div>

    <header class="relative overflow-hidden">
      <!-- Top navigation -->
      <?php require "./components/navbar.php"; ?>

      <!-- Hero section -->
      <div class=" pb-80 pt-16 sm:pb-40 sm:pt-24 lg:pb-48 lg:pt-40">
        <div class="relative mx-auto max-w-7xl px-4 sm:static sm:px-6 lg:px-8">
          <div class="sm:max-w-lg flex flex-col gap-8">
            <div class="relative inline-block">
              <h1 id="typing-heading" class="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">
                <span id="text-content"></span><span id="cursor" class="blink">|</span>
              </h1>
            </div>
            <p class="mt-4 text-xl text-gray-500">
              <?= $translations['hero_description'] ?>
            </p>
          </div>
          <div>
            <div class="mt-10">
              <!-- Decorative image grid -->
              <div aria-hidden="true" class="pointer-events-none lg:absolute lg:inset-y-0 lg:mx-auto lg:w-full lg:max-w-7xl">
                <div class="absolute transform sm:left-1/2 sm:top-0 sm:translate-x-8 lg:left-1/2 lg:top-1/2 lg:-translate-y-1/2 lg:translate-x-8">
                  <div class="flex items-center space-x-6 lg:space-x-8">
                    <div class="grid flex-shrink-0 grid-cols-1 gap-y-6 lg:gap-y-8">
                      <div class="h-64 w-44 overflow-hidden rounded-lg sm:opacity-0 lg:opacity-100 image">
                        <img src="public/images/apple.webp" alt="" class="h-full w-full object-cover object-center">
                      </div>
                      <div class="h-64 w-44 overflow-hidden rounded-lg image">
                        <img src="public/images/orange.jpg" alt="" class="h-full w-full object-cover object-center">
                      </div>
                    </div>
                    <div class="grid flex-shrink-0 grid-cols-1 gap-y-6 lg:gap-y-8">
                      <div class="h-64 w-44 overflow-hidden rounded-lg image">
                        <img src="public/images/banana.webp" alt="" class="h-full w-full object-cover object-center">
                      </div>
                      <div class="h-64 w-44 overflow-hidden rounded-lg image">
                        <img src="public/images/greenapple.jpg" alt="" class="h-full w-full object-cover object-center">
                      </div>
                      <div class="h-64 w-44 overflow-hidden rounded-lg image">
                        <img src="public/images/strawberry.jpg" alt="" class="h-full w-full object-cover object-center">
                      </div>
                    </div>
                    <div class="grid flex-shrink-0 grid-cols-1 gap-y-6 lg:gap-y-8">
                      <div class="h-64 w-44 overflow-hidden rounded-lg image">
                        <img src="public/images/cherry.webp" alt="" class="h-full w-full object-cover object-center">
                      </div>
                      <div class="h-64 w-44 overflow-hidden rounded-lg image">
                        <img src="public/images/avocado.webp" alt="" class="h-full w-full object-cover object-center">
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <a href="#products" class="inline-block rounded-md border border-transparent bg-green-600 px-8 py-3 text-center font-medium text-white hover:bg-green-700">
                <?= $translations['get_started']; ?>
              </a>
            </div>
          </div>
        </div>
      </div>
    </header>

    <main>
      <!-- Category section -->
      <section aria-labelledby="category-heading" class="bg-gray-50">
        <div class="mx-auto max-w-7xl px-4 py-24 sm:px-6 sm:py-32 lg:px-8">
          <div class="sm:flex sm:items-baseline sm:justify-between">
            <h2 id="category-heading" class="text-2xl font-bold tracking-tight text-gray-900"> <?= $translations['shop_by_category']; ?></h2>
            <a href="#" class="hidden text-sm font-semibold text-green-600 hover:text-green-500 sm:block">
              <?= $translations['browse_all_categories']; ?>
              <span aria-hidden="true"> &rarr;</span>
            </a>
          </div>

          <div class="mt-6 grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:grid-rows-2 sm:gap-x-6 lg:gap-8">
            <div class="group aspect-h-1 aspect-w-2 overflow-hidden rounded-lg sm:aspect-h-1 sm:aspect-w-1 sm:row-span-2">
              <img src="public/images/fruitbanner.jpg" alt="Two models wearing women's black cotton crewneck tee and off-white cotton crewneck tee." class="object-cover object-center group-hover:opacity-75">
              <div aria-hidden="true" class="bg-gradient-to-b from-transparent to-black opacity-50"></div>

            </div>
            <div class="group aspect-h-1 aspect-w-2 overflow-hidden rounded-lg sm:aspect-none sm:relative sm:h-full">
              <img src="public/images/banner2.png" alt="Wooden shelf with gray and olive drab green baseball caps, next to wooden clothes hanger with sweaters." class="object-cover object-center group-hover:opacity-75 sm:absolute sm:inset-0 sm:h-full sm:w-full">
              <div aria-hidden="true" class="bg-gradient-to-b from-transparent to-black opacity-50 sm:absolute sm:inset-0"></div>
              <div class="flex items-end p-6 sm:absolute sm:inset-0">
                <div>
                  <h3 class="font-semibold text-white">
                    <a href="#">
                      <span class="absolute inset-0"></span>
                      <?= $translations['organic_food'] ?>
                    </a>
                  </h3>
                  <p aria-hidden="true" class="mt-1 text-sm text-white"> <?= $translations['shop_now'] ?></p>
                </div>
              </div>
            </div>
            <div class="group aspect-h-1 aspect-w-2 overflow-hidden rounded-lg sm:aspect-none sm:relative sm:h-full">
              <img src="public/images/banner.png" alt="Walnut desk organizer set with white modular trays, next to porcelain mug on wooden desk." class="object-cover object-center group-hover:opacity-75 sm:absolute sm:inset-0 sm:h-full sm:w-full">
              <div aria-hidden="true" class="bg-gradient-to-b from-transparent to-black opacity-50 sm:absolute sm:inset-0"></div>
              <div class="flex items-end p-6 sm:absolute sm:inset-0">
                <div>
                  <h3 class="font-semibold text-white">
                    <a href="#">
                      <span class="absolute inset-0"></span>
                      <?= $translations['organic_fruit'] ?>
                    </a>
                  </h3>
                  <p aria-hidden="true" class="mt-1 text-sm text-white">
                    <?= $translations['shop_now'] ?>
                  </p>
                </div>
              </div>
            </div>
          </div>

          <div class="mt-6 sm:hidden">
            <a href="#" class="block text-sm font-semibold text-green-600 hover:text-green-500">
              Browse all categories
              <span aria-hidden="true"> &rarr;</span>
            </a>
          </div>
        </div>
      </section>

      <!-- Featured section -->
      <section aria-labelledby="cause-heading">
        <div class="relative bg-gray-800 px-6 py-32 sm:px-12 sm:py-40 lg:px-16">
          <div class="absolute inset-0 overflow-hidden">
            <img src="public/images/fruitfarm.webp" alt="" class="h-full w-full object-cover object-center">
          </div>
          <div aria-hidden="true" class="absolute inset-0 bg-gray-900 bg-opacity-50"></div>
          <div class="relative mx-auto flex max-w-3xl flex-col items-center text-center">
            <h2 id="cause-heading" class="text-3xl font-bold tracking-tight text-white sm:text-4xl">
              <?= $translations['long_term_thinking'] ?>
            </h2>
            <p class="mt-3 text-xl text-white"><?= $translations['long_term_thinking_description'] ?></p>
            <a href="#" class="mt-8 block w-full rounded-md border border-transparent bg-white px-8 py-3 text-base font-medium text-gray-900 hover:bg-gray-100 sm:w-auto">Read our story</a>
          </div>
        </div>
      </section>

      <!-- Favorites section -->
      <section aria-labelledby="favorites-heading" id="products">
        <div class="mx-auto max-w-7xl px-4 py-24 sm:px-6 sm:py-32 lg:px-8">
          <div class="sm:flex sm:items-baseline sm:justify-between">
            <h2 id="favorites-heading" class="text-2xl font-bold tracking-tight text-gray-900"><?= $translations['our_products'] ?> </h2>
            <a href="#" class="hidden text-sm font-semibold text-green-600 hover:text-green-500 sm:block">
              <?= $translations['browse_all_products'] ?>
              <span aria-hidden="true"> &rarr;</span>
            </a>
          </div>

          <div class="mt-6 grid grid-cols-1 gap-y-10 sm:grid-cols-3 sm:gap-x-6 sm:gap-y-8 lg:gap-x-8">
            <?php while ($product = $result->fetch_assoc()): ?>
              <div class="group relative">
                <div class="relative h-96 w-full overflow-hidden rounded-lg sm:aspect-h-3 sm:aspect-w-2 group-hover:opacity-75 sm:h-auto">
                  <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="h-full w-full object-cover object-center">
                  <div class="absolute inset-0 bg-black opacity-5"></div>
                </div>
                <h3 class="mt-4 text-base font-semibold text-gray-900">
                  <a href="./views/single-product.php?id=<?= $product['id'];  ?>">
                    <span class="absolute inset-0"></span>
                    <?php echo htmlspecialchars($product['name']); ?>
                  </a>
                </h3>
                <p class="mt-1 text-sm text-gray-500">$<?php echo number_format($product['price'], 2); ?></p>
              </div>
            <?php endwhile; ?>
          </div>

          <div class="mt-6 sm:hidden">
            <a href="#" class="block text-sm font-semibold text-green-600 hover:text-green-500">
              Browse all favorites
              <span aria-hidden="true"> &rarr;</span>
            </a>
          </div>
        </div>
      </section>

      <!-- CTA section -->

    </main>

    <footer aria-labelledby="footer-heading" class="bg-white">
      <h2 id="footer-heading" class="sr-only">Footer</h2>
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="py-20 xl:grid xl:grid-cols-3 xl:gap-8">
          <div class="grid grid-cols-2 gap-8 xl:col-span-2">
            <div class="space-y-16 md:grid md:grid-cols-2 md:gap-8 md:space-y-0">
              <div>
                <h3 class="text-sm font-medium text-gray-900">Shop</h3>
                <ul role="list" class="mt-6 space-y-6">
                  <li class="text-sm">
                    <a href="#" class="text-gray-500 hover:text-gray-600">Bags</a>
                  </li>
                  <li class="text-sm">
                    <a href="#" class="text-gray-500 hover:text-gray-600">Tees</a>
                  </li>
                  <li class="text-sm">
                    <a href="#" class="text-gray-500 hover:text-gray-600">Objects</a>
                  </li>
                  <li class="text-sm">
                    <a href="#" class="text-gray-500 hover:text-gray-600">Home Goods</a>
                  </li>
                  <li class="text-sm">
                    <a href="#" class="text-gray-500 hover:text-gray-600">Accessories</a>
                  </li>
                </ul>
              </div>
              <div>
                <h3 class="text-sm font-medium text-gray-900">Company</h3>
                <ul role="list" class="mt-6 space-y-6">
                  <li class="text-sm">
                    <a href="#" class="text-gray-500 hover:text-gray-600">Who we are</a>
                  </li>
                  <li class="text-sm">
                    <a href="#" class="text-gray-500 hover:text-gray-600">Sustainability</a>
                  </li>
                  <li class="text-sm">
                    <a href="#" class="text-gray-500 hover:text-gray-600">Press</a>
                  </li>
                  <li class="text-sm">
                    <a href="#" class="text-gray-500 hover:text-gray-600">Careers</a>
                  </li>
                  <li class="text-sm">
                    <a href="#" class="text-gray-500 hover:text-gray-600">Terms &amp; Conditions</a>
                  </li>
                  <li class="text-sm">
                    <a href="#" class="text-gray-500 hover:text-gray-600">Privacy</a>
                  </li>
                </ul>
              </div>
            </div>
            <div class="space-y-16 md:grid md:grid-cols-2 md:gap-8 md:space-y-0">
              <div>
                <h3 class="text-sm font-medium text-gray-900">Account</h3>
                <ul role="list" class="mt-6 space-y-6">
                  <li class="text-sm">
                    <a href="#" class="text-gray-500 hover:text-gray-600">Manage Account</a>
                  </li>
                  <li class="text-sm">
                    <a href="#" class="text-gray-500 hover:text-gray-600">Returns &amp; Exchanges</a>
                  </li>
                  <li class="text-sm">
                    <a href="#" class="text-gray-500 hover:text-gray-600">Redeem a Gift Card</a>
                  </li>
                </ul>
              </div>
              <div>
                <h3 class="text-sm font-medium text-gray-900">Connect</h3>
                <ul role="list" class="mt-6 space-y-6">
                  <li class="text-sm">
                    <a href="#" class="text-gray-500 hover:text-gray-600">Contact Us</a>
                  </li>
                  <li class="text-sm">
                    <a href="#" class="text-gray-500 hover:text-gray-600">Facebook</a>
                  </li>
                  <li class="text-sm">
                    <a href="#" class="text-gray-500 hover:text-gray-600">Instagram</a>
                  </li>
                  <li class="text-sm">
                    <a href="#" class="text-gray-500 hover:text-gray-600">Pinterest</a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="mt-16 md:mt-16 xl:mt-0">
            <h3 class="text-sm font-medium text-gray-900">Sign up for our newsletter</h3>
            <p class="mt-6 text-sm text-gray-500">The latest deals and savings, sent to your inbox weekly.</p>
            <form class="mt-2 flex sm:max-w-md">
              <label for="email-address" class="sr-only">Email address</label>
              <input id="email-address" type="text" autocomplete="email" required class="w-full min-w-0 appearance-none rounded-md border border-gray-300 bg-white px-4 py-2 text-base text-green-500 placeholder-gray-500 shadow-sm focus:border-green-500 focus:outline-none focus:ring-1 focus:ring-green-500">
              <div class="ml-4 flex-shrink-0">
                <button type="submit" class="flex w-full items-center justify-center rounded-md border border-transparent bg-green-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">Sign up</button>
              </div>
            </form>
          </div>
        </div>

        <div class="border-t border-gray-200 py-10">
          <p class="text-sm text-gray-500">Copyright &copy; 2021 Your Company, Inc.</p>
        </div>
      </div>
    </footer>
  </div>
  <!-- Your HTML content -->
  <script>
    // JavaScript to animate dropdown using GSAP
    document.addEventListener("DOMContentLoaded", function() {
      const userMenuButton = document.getElementById("user-menu-button");
      const dropdownMenu = document.getElementById("menu");

      // Function to toggle dropdown visibility with animation
      userMenuButton.addEventListener("click", function() {
        const isHidden = dropdownMenu.classList.contains("hidden");

        if (isHidden) {
          // Remove hidden class for animation
          dropdownMenu.classList.remove("hidden");
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
          // Animate closing the menu
          gsap.to(dropdownMenu, {
            opacity: 0,
            scaleY: 0,
            duration: 0.3,
            onComplete: () => dropdownMenu.classList.add("hidden")
          });
        }
      });

      document.addEventListener("click", function(event) {
        if (!userMenuButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
          gsap.to(dropdownMenu, {
            opacity: 0,
            scaleY: 0,
            duration: 0.3,
            onComplete: () => dropdownMenu.classList.add("hidden")
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



    document.addEventListener("DOMContentLoaded", function() {
      const textContent = document.querySelector("#text-content");
      const cursor = document.querySelector("#cursor");
      const text = "<?php echo addslashes($translations['hero_title']); ?>"; // Use the new translation key

      const typingSpeed = 200; // Speed for typing letters (milliseconds)
      const delayBeforeRestart = 1000; // Delay before restarting after fade-out (milliseconds)
      const fadeDuration = 500; // Cursor fade-out duration (milliseconds)

      function startTypingAnimation() {
        textContent.textContent = ''; // Clear the text content
        cursor.style.opacity = '1'; // Ensure the cursor is visible
        let index = 0;

        // Typing effect
        function typeLetter() {
          if (index < text.length) {
            textContent.textContent += text.charAt(index); // Add next letter
            index++;
            setTimeout(typeLetter, typingSpeed);
          } else {
            // Fade out the cursor after typing finishes
            setTimeout(() => {
              fadeOutCursor();
            }, delayBeforeRestart);
          }
        }

        // Function to fade out the cursor before restarting
        function fadeOutCursor() {
          let opacity = 1;
          const fade = setInterval(() => {
            if (opacity > 0) {
              opacity -= 0.05;
              cursor.style.opacity = opacity.toString();
            } else {
              clearInterval(fade);
              textContent.textContent = ''; // Clear the text for looping
              startTypingAnimation(); // Restart the animation
            }
          }, fadeDuration / 20); // Adjust fade-out steps based on duration
        }

        typeLetter(); // Start typing animation
      }

      startTypingAnimation(); // Start typing and looping
    });
  </script>

</body>

</html>