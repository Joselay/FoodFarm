<?php
require "../utils/dd.php";

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ./views/signin.php");
    exit();
}


require_once "../utils/language.php";
require_once "../enums/Language.php";
require "../config/database.php";


// Language handling
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['language'])) {
    $_SESSION['language'] = $_POST['language'];
}



$userId = $_SESSION['user_id'];
$userName = $_SESSION['user_username'];
$userEmail = $_SESSION['user_email'];
$imageUrl = $_SESSION['user_image_url'];
$language = $_SESSION['language'] ?? 'en-US';


$sql = "
    SELECT o.id AS order_id, 
           o.quantity, 
           o.total_price, 
           o.status, 
           o.order_date AS created_at, 
           p.name AS product_name, 
           p.price AS item_price, 
           p.image_url
    FROM orders o
    LEFT JOIN products p ON o.product_id = p.id
    WHERE o.user_id = ?
    ORDER BY o.order_date DESC
";


$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $userId);
$stmt->execute();
$result = $stmt->get_result();


if (!$result) {
    echo "Error fetching orders: " . mysqli_error($conn);
    exit();
}

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

// Get the current language from the session or default to English
$language = $_SESSION['language'] ?? Language::English->value; // Using the enum for default language

// Load the corresponding language file
$languageFile = "../i18n/{$language}.php";
if (file_exists($languageFile)) {
    require_once $languageFile;
} else {
    require_once "../i18n/en-US.php"; // Fallback to English if file doesn't exist
}


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

?>

<!DOCTYPE html>
<html class="h-full" lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profile Details</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../public/js/script.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
</head>

<body style="font-family: <?php echo $fontFamily; ?>;" style="font-family: 'Inter';">
    <?php require "../components/navbar.php"; ?>

    <div class="mx-auto max-w-7xl pt-16 lg:flex lg:gap-x-16 lg:px-8">
        <aside class="flex overflow-x-auto border-b border-gray-900/5 py-4 lg:block lg:w-64 lg:flex-none lg:border-0 lg:py-20">
            <nav class="flex-none px-4 sm:px-6 lg:px-0">
                <ul role="list" class="flex gap-x-3 gap-y-1 whitespace-nowrap lg:flex-col">
                    <li>
                        <a href="./profile.php" class="group flex gap-x-3 rounded-md py-2 pl-2 pr-3 text-sm font-semibold leading-6 text-gray-700 hover:bg-gray-50 hover:text-green-600">
                            <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <?= $translations['profile'] ?>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="group flex gap-x-3 rounded-md bg-gray-50 py-2 pl-2 pr-3 text-sm font-semibold leading-6 text-green-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                            </svg>
                            <?= $translations['orders'] ?>

                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <main class="px-4 py-16 sm:px-6 lg:flex-auto lg:px-0 lg:py-20">
            <div class="mx-auto max-w-2xl space-y-16 sm:space-y-20 lg:mx-0 lg:max-w-none">
                <div class="px-4 sm:px-6 lg:px-8">
                    <div class="sm:flex sm:items-center">
                        <div class="sm:flex-auto">
                            <h1 class="text-2xl font-bold leading-6 text-gray-900">
                                <?= $translations['orders'] ?>
                            </h1>
                        </div>
                    </div>
                    <div class="mt-8 flow-root">
                        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                <table class="min-w-full divide-y divide-gray-300">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0"><?= $translations['order_id'] ?></th>
                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"><?= $translations['product'] ?></th>
                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"><?= $translations['unit_price'] ?></th>
                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"><?= $translations['quantity'] ?></th>
                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"><?= $translations['total_amount'] ?></th>
                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"><?= $translations['status'] ?></th>
                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"><?= $translations['created_at'] ?></th>
                                        </tr>
                                    </thead>

                                    <tbody class="divide-y divide-gray-200 bg-white">
                                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                            <tr>
                                                <td class="whitespace-nowrap py-5 pl-4 pr-3 text-sm sm:pl-0">
                                                    <div class="font-medium text-gray-900"><?= htmlspecialchars($row['order_id']) ?></div>
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500">
                                                    <div class="flex items-center">
                                                        <img src="<?= htmlspecialchars($row['image_url']) ?>" alt="<?= htmlspecialchars($row['product_name']) ?>" class="w-10 h-10 mr-2 object-cover">
                                                        <span><?= htmlspecialchars($row['product_name']) ?></span>
                                                    </div>
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500">
                                                    $<?= number_format($row['item_price'], 2) ?>
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500">
                                                    <?= htmlspecialchars($row['quantity']) ?>
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500">
                                                    <div class="text-gray-900">$<?= number_format($row['total_price'], 2) ?></div>
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500">
                                                    <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium 
                <?= $row['status'] == 'shipped' ? 'bg-green-100 text-green-800' : ($row['status'] == 'pending' ? 'bg-yellow-100 text-yellow-800' : ($row['status'] == 'cancelled' ? 'bg-red-100 text-red-800' : ($row['status'] == 'delivered' ? 'bg-blue-100 text-blue-800' : ($row['status'] == 'refunded' ? 'bg-gray-100 text-gray-800' : '')))) ?>">
                                                        <?= htmlspecialchars($translations[$row['status']]) ?>
                                                    </span>
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500"><?= htmlspecialchars($row['created_at']) ?></td>
                                            </tr>
                                        <?php endwhile; ?>


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
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