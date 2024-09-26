<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: ./signin.php");
  exit();
}

$userName = $_SESSION['user_username'];
$imageUrl = $_SESSION['user_image_url'];

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$servername = "localhost";
$username = "jose";
$password = "jose";
$dbname = "jose";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
  die("Product not found.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
  if ($product['stock_quantity'] > 0) {
    $updateSql = "UPDATE products SET stock_quantity = stock_quantity - 1 WHERE id = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("i", $id);
    $updateStmt->execute();

    if ($updateStmt->affected_rows > 0) {
      $_SESSION['toast_message'] = "Product added successfully!";
      header("Location: " . $_SERVER['REQUEST_URI']);
      exit();
    } else {
      echo "Error updating stock quantity.";
    }

    $updateStmt->close();
  } else {
    echo "Product is out of stock.";
  }
}

$stmt->close();
$conn->close();
?>

<?php if (isset($_SESSION['toast_message'])): ?>
  <div id="toast" class="z-[100] w-[22rem] fixed top-0 left-[40%] mt-4">
    <div class="flex w-full max-w-sm py-5 px-6 bg-white rounded-xl border border-gray-200 shadow-sm mb-4 gap-4" role="alert">
      <div class="inline-flex space-x-3">
        <span class="bg-green-50 w-9 h-9 rounded-full flex-shrink-0 flex justify-center items-center">
          <svg class="w-5 h-5 text-green-600" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M5 10L8 13L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
        </span>
        <div class="flex flex-col">
          <span class="font-semibold text-green-600">Success!</span>
          <span class="text-sm text-gray-500"><?= $_SESSION['toast_message']; ?></span>
        </div>
      </div>
    </div>
  </div>
  <?php unset($_SESSION['toast_message']);
  ?>
<?php endif; ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $product ? $product['name'] : 'Product Not Found'; ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link rel="icon" href="../public/images/apple.svg" type="image/icon type">

  <link
    href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
    rel="stylesheet" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
</head>
<style>
  html {
    scroll-behavior: smooth;
  }
</style>

<body style="font-family: 'Inter';" class="h-screen w-screen grid place-items-center">
  <header class="absolute inset-x-0 top-0 z-50">
    <nav class="flex items-center justify-between p-6 lg:px-8" aria-label="Global">
      <div class="flex lg:flex-1">
        <a href="/foodfarm" class="-m-1.5 p-1.5">
          <span class="sr-only">Your Company</span>
          <img class="h-8 w-auto" src="../public/images/logo.svg" alt="">
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

  </header>

  <div class="bg-white">
    <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:grid lg:max-w-7xl lg:grid-cols-2 lg:gap-x-8 lg:px-8">
      <div class="lg:max-w-lg lg:self-end">


        <div class="mt-4">
          <h1 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
            <?php echo $product ? $product['name'] : 'Product Not Found'; ?>
          </h1>
        </div>

        <section aria-labelledby="information-heading" class="mt-4">
          <h2 id="information-heading" class="sr-only">Product information</h2>

          <div class="flex items-center">
            <p class="text-lg text-gray-900 sm:text-xl">
              $<?php echo $product ? $product['price'] : '0.00'; ?>
            </p>

            <div class="ml-4 border-l border-gray-300 pl-4">
              <h2 class="sr-only">Stocks</h2>
              <div class="flex items-center">
                <div>
                  <div class="flex items-center">
                    <!-- Active: "text-yellow-400", Default: "text-gray-300" -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                      <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                    </svg>

                  </div>
                </div>
                <p class="ml-2 text-sm text-gray-500">
                  <?php echo $product ? $product['stock_quantity'] : '0.00'; ?>

                  stocks</p>
              </div>
            </div>
          </div>

          <div class="mt-4 space-y-6">
            <p class="text-base text-gray-500">
              <?php echo $product ? $product['description'] : ''; ?>
            </p>
          </div>

          <?php
          if ($product['stock_quantity'] > 0) {
            echo ' <div class="mt-6 flex items-center">
            <svg class="h-5 w-5 flex-shrink-0 text-green-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
              <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
            </svg>
            <p class="ml-2 text-sm text-gray-500">In stock and ready to ship</p>
          </div>';
          } else {
            echo ' <div class="mt-6 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="red" class="size-5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>

            <p class="ml-2 text-sm text-gray-500">Out of stock</p>
          </div>';
          }
          ?>

        </section>
      </div>

      <div class="mt-10 lg:col-start-2 lg:row-span-2 lg:mt-0 lg:self-center">
        <div class="aspect-h-1 aspect-w-1 overflow-hidden rounded-lg">
          <img src="<?php echo $product ? $product['image_url'] : ''; ?>" alt="Model wearing light green backpack with black canvas straps and front zipper pouch." class="h-full w-full object-cover object-center">
        </div>
      </div>

      <div class="mt-10 lg:col-start-1 lg:row-start-2 lg:max-w-lg lg:self-start">
        <section aria-labelledby="options-heading">
          <h2 id="options-heading" class="sr-only">Product options</h2>

          <form method="POST">
            <?php

            if ($product['stock_quantity'] > 0) {
              echo ' <div class="mt-10">
              <button type="submit" name="add_to_cart" class="flex w-full items-center justify-center rounded-md border border-transparent bg-green-600 px-8 py-3 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 focus:ring-offset-gray-50">Purchase</button>
            </div>';
            } else {
              echo ' <div class="mt-10">
              <button disabled type="submit" class="flex w-full items-center justify-center rounded-md border border-transparent bg-gray-400 px-8 py-3 text-base font-medium cursor-not-allowed text-white focus:outline-none">Purchase</button>
            </div>';
            }
            ?>
          </form>
        </section>
      </div>
    </div>
  </div>
  <script>
    function signOut() {
      window.location.href = './signout.php';
    }
    const userMenuButton = document.getElementById('user-menu-button');
    const userMenu = document.getElementById('user-menu');
    let isOpen = false;

    userMenuButton.addEventListener('click', () => {
      isOpen = !isOpen;
      userMenu.setAttribute('aria-expanded', isOpen);

      if (isOpen) {
        gsap.to(userMenu, {
          duration: 0.2,
          opacity: 1,
          pointerEvents: 'auto',
          ease: 'power1.out'
        });
      } else {
        gsap.to(userMenu, {
          duration: 0.2,
          opacity: 0,
          pointerEvents: 'none',
          ease: 'power1.in'
        });
      }
    });

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
      const productButton = document.querySelector("button[aria-expanded]");
      const flyoutMenu = productButton.nextElementSibling;

      let menuVisible = false;

      function toggleMenu() {
        menuVisible = !menuVisible;

        if (menuVisible) {
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
          gsap.to(flyoutMenu, {
            opacity: 0,
            y: -10,
            duration: 0.3,
            onComplete: () => {
              flyoutMenu.classList.add("hidden");
            }
          });
        }

        productButton.setAttribute("aria-expanded", menuVisible);
      }

      productButton.addEventListener("click", toggleMenu);

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
  <script>
    const toast = document.getElementById('toast');

    gsap.fromTo(toast, {
      autoAlpha: 0,
      y: -50
    }, {
      autoAlpha: 1,
      y: 0,
      duration: 0.5,
      ease: "power2.out",
      onComplete: () => {
        setTimeout(() => {
          gsap.to(toast, {
            autoAlpha: 0,
            y: -50,
            duration: 0.5,
            ease: "power2.in"
          });
        }, 3000);
      }
    });
    let quantity = 1;

    const quantityDisplay = document.getElementById('quantityDisplay');
    const increaseBtn = document.getElementById('increaseBtn');
    const decreaseBtn = document.getElementById('decreaseBtn');

    increaseBtn.addEventListener('click', () => {
      quantity++;
      updateQuantityDisplay();
    });

    decreaseBtn.addEventListener('click', () => {
      if (quantity > 0) {
        quantity--;
        updateQuantityDisplay();
      }
    });

    function updateQuantityDisplay() {
      quantityDisplay.textContent = quantity;
    }
  </script>
</body>

</html>