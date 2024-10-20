<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: ./views/signin.php");
  exit();
}

require "../config/database.php";
require_once "../utils/language.php";
require_once "../enums/Language.php";
require "../utils/dd.php";




if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['language'])) {
  $_SESSION['language'] = $_POST['language'];
}

$userName = $_SESSION['user_username'];
$userEmail = $_SESSION['user_email'];
$imageUrl = $_SESSION['user_image_url'];
$userId = $_SESSION['user_id'];
$language = $_SESSION['language'] ?? 'en-US';


$sql = "SELECT balance FROM users WHERE id = $userId";
$result = mysqli_query($conn, $sql);

if ($result) {
  $row = mysqli_fetch_assoc($result);
  $userBalance = $row['balance'];
} else {
  echo "Error fetching balance: " . mysqli_error($conn);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (!empty($_POST['new_username']) && $_POST['new_username'] !== $userName) {
    $newUsername = mysqli_real_escape_string($conn, $_POST['new_username']);
    $sql = "UPDATE users SET username = '$newUsername' WHERE id = $userId";
    if (mysqli_query($conn, $sql)) {
      $_SESSION['user_username'] = $newUsername;
    } else {
      echo "Error updating username: " . mysqli_error($conn);
    }
  }

  if (!empty($_POST['new_email']) && $_POST['new_email'] !== $userEmail) {
    $newEmail = mysqli_real_escape_string($conn, $_POST['new_email']);
    $sql = "UPDATE users SET email = '$newEmail' WHERE id = $userId";
    if (mysqli_query($conn, $sql)) {
      $_SESSION['user_email'] = $newEmail;
    } else {
      echo "Error updating email: " . mysqli_error($conn);
    }
  }

  if (!empty($_POST['new_password'])) {
    $newPassword = password_hash($_POST['new_password'], PASSWORD_BCRYPT);
    $sql = "UPDATE users SET password = '$newPassword' WHERE id = $userId";
    if (!mysqli_query($conn, $sql)) {
      echo "Error updating password: " . mysqli_error($conn);
    }
  }
}
require_once "../utils/language.php";
require_once '../config/database.php';
require_once '../enums/Language.php';

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}


if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['language'])) {
  $language = $_POST['language'];
  $_SESSION['language'] = $language;
  header("Location: " . $_SERVER['PHP_SELF']);
  exit();
}

$language = $_SESSION['language'] ?? Language::English->value;

$languageFile = "../i18n/{$language}.php";
if (file_exists($languageFile)) {
  require_once $languageFile;
} else {
  require_once "../i18n/en-US.php";
}

$sql = "SELECT id, name, price, image_url FROM products";
$result = $conn->query($sql);

$userId = $_SESSION['user_id'] ?? null;
$userData = null;

if ($userId) {
  $userSql = "SELECT id, username, email, image_url FROM users WHERE id = ?";
  $stmt = $conn->prepare($userSql);
  $stmt->bind_param("i", $userId);
  $stmt->execute();
  $userResult = $stmt->get_result();

  if ($userResult->num_rows > 0) {
    $userData = $userResult->fetch_assoc();
  } else {
    echo "No user found.";
  }
}

mysqli_close($conn);
?>



<!DOCTYPE html>
<html class="h-full" lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Profile Details</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
    rel="stylesheet" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="../public/js/script.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>

</head>


<body style="font-family: <?php echo $fontFamily; ?>;" style="font-family: 'Inter';">
  <?php require "../components/navbar.php"; ?>

  <div class="mx-auto max-w-7xl pt-16 lg:flex lg:gap-x-16 lg:px-8">
    <h1 class="sr-only">General Settings</h1>

    <aside class="flex overflow-x-auto border-b border-gray-900/5 py-4 lg:block lg:w-64 lg:flex-none lg:border-0 lg:py-20">
      <nav class="flex-none px-4 sm:px-6 lg:px-0">
        <ul role="list" class="flex gap-x-3 gap-y-1 whitespace-nowrap lg:flex-col">
          <li>
            <a href="#" class="group flex gap-x-3 rounded-md bg-gray-50 py-2 pl-2 pr-3 text-sm font-semibold leading-6 text-green-600">
              <svg class="h-6 w-6 shrink-0 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
              <?= $translations['profile'] ?>
            </a>
          </li>
          <li>
            <a href="./orders.php" class="group flex gap-x-3 rounded-md py-2 pl-2 pr-3 text-sm font-semibold leading-6 text-gray-700 hover:bg-gray-50 hover:text-green-600">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
              </svg>

              <?= $translations['orders'] ?>

            </a>
          </li>
        </ul>
      </nav>
    </aside>

    <main class="px-4 py-16 sm:px-6 lg:flex-auto lg:px-0 lg:py-20">
      <div class="mx-auto max-w-2xl space-y-16 sm:space-y-20 lg:mx-0 lg:max-w-none">
        <div class="pt-6 sm:flex  gap-8 items-center justify-center">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="size-14 stroke-green-600">
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
          </svg>

          <div class="text-gray-900 text-6xl font-bold tracking-wide" id="balance-display"><?= number_format($userBalance, 2); ?> $</div>
        </div>


        <div>
          <h2 class="text-base font-semibold leading-7 text-gray-900">
            <?= $translations['profile'] ?>
          </h2>
          <p class="mt-1 text-sm leading-6 text-gray-500"> <?= $translations['profile_description'] ?>
          </p>

          <dl class="mt-6 space-y-6 divide-y divide-gray-100 border-t border-gray-200 text-sm leading-6">
            <div class="pt-6 sm:flex">
              <dt class="font-medium text-gray-900 sm:w-64 sm:flex-none sm:pr-6">
                <?= $translations['username'] ?>

              </dt>
              <dd class="mt-1 flex justify-between gap-x-6 sm:mt-0 sm:flex-auto">
                <div class="text-gray-900" id="username-display"><?= $userName; ?></div>
                <form id="update-form" method="POST">
                  <input type="text" name="new_username" id="username-input" class="hidden border border-gray-300 p-2" value="<?= $userName; ?>" />
                </form>
                <button type="button" class="font-semibold text-green-600 hover:text-green-500" onclick="toggleEdit(this)"><?= $translations['update'] ?></button>
                <button type="submit" form="update-form" class="hidden font-semibold text-blue-600 hover:text-blue-500" id="save-btn"><?= $translations['save'] ?></button>
              </dd>
            </div>

            <div class="pt-6 sm:flex">
              <dt class="font-medium text-gray-900 sm:w-64 sm:flex-none sm:pr-6">
                <?= $translations['email_address'] ?>
              </dt>
              <dd class="mt-1 flex justify-between gap-x-6 sm:mt-0 sm:flex-auto">
                <div class="text-gray-900" id="email-display"><?= $userEmail; ?></div>
                <form id="email-update-form" method="POST">
                  <input type="text" name="new_email" id="email-input" class="hidden border border-gray-300 p-2" value="<?= $userEmail; ?>" />
                </form>
                <button type="button" class="font-semibold text-green-600 hover:text-green-500" onclick="toggleEmailEdit(this)"><?= $translations['update'] ?></button>
                <button type="submit" form="email-update-form" class="hidden font-semibold text-blue-600 hover:text-blue-500" id="email-save-btn"><?= $translations['save'] ?></button>
              </dd>
            </div>
            <div class="pt-6 sm:flex">
              <dt class="font-medium text-gray-900 sm:w-64 sm:flex-none sm:pr-6">
                <?= $translations['password'] ?>

              </dt>
              <dd class="mt-1 flex justify-between gap-x-6 sm:mt-0 sm:flex-auto">
                <div class="text-gray-900" id="password-display">●●●●●●●●●●</div>
                <form id="password-update-form" method="POST">
                  <input type="password" name="new_password" id="password-input" class="hidden border border-gray-300 p-2" placeholder="Enter new password" />
                </form>
                <button type="button" class="font-semibold text-green-600 hover:text-green-500" onclick="togglePasswordEdit(this)">
                  <?= $translations['update'] ?>

                </button>
                <button type="submit" form="password-update-form" class="hidden font-semibold text-blue-600 hover:text-blue-500" id="password-save-btn"><?= $translations['save'] ?></button>
              </dd>
            </div>

          </dl>
        </div>
    </main>
  </div>

  <script>
    function toggleEdit(button) {
      const display = document.getElementById('username-display');
      const input = document.getElementById('username-input');
      const saveBtn = document.getElementById('save-btn');

      display.classList.toggle('hidden');
      input.classList.toggle('hidden');
      saveBtn.classList.toggle('hidden');
      button.classList.toggle('hidden');
    }

    function toggleEmailEdit(button) {
      const display = document.getElementById('email-display');
      const input = document.getElementById('email-input');
      const saveBtn = document.getElementById('email-save-btn');

      display.classList.toggle('hidden');
      input.classList.toggle('hidden');
      saveBtn.classList.toggle('hidden');
      button.classList.toggle('hidden');
    }

    function togglePasswordEdit(button) {
      const display = document.getElementById('password-display');
      const input = document.getElementById('password-input');
      const saveBtn = document.getElementById('password-save-btn');

      display.classList.toggle('hidden');
      input.classList.toggle('hidden');
      saveBtn.classList.toggle('hidden');
      button.classList.toggle('hidden');
    }
    document.addEventListener("DOMContentLoaded", function() {
      const userMenuButton = document.getElementById("user-menu-button");
      const dropdownMenu = document.getElementById("menu");

      userMenuButton.addEventListener("click", function() {
        const isHidden = dropdownMenu.classList.contains("hidden");

        if (isHidden) {
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
      const text = "<?php echo addslashes($translations['hero_title']); ?>";

      const typingSpeed = 200;
      const delayBeforeRestart = 1000;
      const fadeDuration = 500;

      function startTypingAnimation() {
        textContent.textContent = '';
        cursor.style.opacity = '1';
        let index = 0;

        function typeLetter() {
          if (index < text.length) {
            textContent.textContent += text.charAt(index);
            index++;
            setTimeout(typeLetter, typingSpeed);
          } else {
            setTimeout(() => {
              fadeOutCursor();
            }, delayBeforeRestart);
          }
        }

        function fadeOutCursor() {
          let opacity = 1;
          const fade = setInterval(() => {
            if (opacity > 0) {
              opacity -= 0.05;
              cursor.style.opacity = opacity.toString();
            } else {
              clearInterval(fade);
              textContent.textContent = '';
              startTypingAnimation();
            }
          }, fadeDuration / 20);
        }

        typeLetter();
      }

      startTypingAnimation();
    });
  </script>
</body>

</html>