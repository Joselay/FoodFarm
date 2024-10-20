<?php

require_once "../utils/language.php";
require_once '../config/database.php';
require_once '../enums/Language.php';
require_once '../utils/dd.php';
$params = "";
if (isset($_GET['id'])) {
    $params = $_SERVER['PHP_SELF'] . "?id=" . $_GET['id'];
    $_SESSION['params'] = $params;
    $id = $_GET['id'];

    $sql = "SELECT * FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();


    $limit_sql = "SELECT * FROM products LIMIT 5";
    $limit_stmt = $conn->prepare($limit_sql);
    $limit_stmt->execute();
    $limit_result = $limit_stmt->get_result();
    $limit_product = $limit_result->fetch_assoc();

    while ($limit_product = $limit_result->fetch_assoc()) {
        $limit_products[] = $limit_product;
    }


    $reviews_sql = "SELECT * FROM reviews WHERE product_id = $id";
    $reviews_stmt = $conn->prepare($reviews_sql);
    $reviews_stmt->execute();
    $reviews_result = $reviews_stmt->get_result();
    $reviews_product = $reviews_result->fetch_assoc();




    if (!$product) {
        header("HTTP/1.0 404 Not Found");
        header("Location: /foodfarm/views/404.php");
        exit();
    }
} else {
    header("Location: /foodfarm");
    exit();
}
shuffle($limit_products);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['user_id'])) {
    $userName = $_SESSION['user_username'];
    $userEmail = $_SESSION['user_email'];
    $imageUrl = $_SESSION['user_image_url'];
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;


$_SESSION['product_id'] = $product['id'];


$_SESSION['language'] = $_SESSION['language'] !== null ? $_SESSION['language'] : Language::English->value;

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

$reviews_sql = "
    SELECT reviews.*, users.username AS username, users.image_url AS user_image 
    FROM reviews 
    JOIN users ON reviews.user_id = users.id 
    WHERE reviews.product_id = " . $id;

$reviews_result = $conn->query($reviews_sql);
$reviews_count = $reviews_result->num_rows;
$see_all_reviews = $language === Language::English->value ? "See all {reviews_count} reviews" : "មើលការវាយតម្លៃទាំងអស់ {reviews_count}";
$reviews_dynamic = str_replace("{reviews_count}", $reviews_count, $see_all_reviews);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $quantityChoice = intval($_POST['quantity-choice']);
    $productPrice = floatval($_POST['product_price']);
    $stockQuantity = intval($_POST['stock_quantity']);

    $totalPrice = $quantityChoice * $productPrice;

    if ($quantityChoice > $stockQuantity) {
        echo "Not enough stock available!";
        exit();
    }

    $userId = $_SESSION['user_id'];
    $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity, total_price) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiid", $userId, $productId, $quantityChoice, $totalPrice);
    $stmt->execute();

    $newStockQuantity = $stockQuantity - $quantityChoice;
    $updateStmt = $conn->prepare("UPDATE products SET stock_quantity = ? WHERE id = ?");
    $updateStmt->bind_param("ii", $newStockQuantity, $productId);
    $updateStmt->execute();

    header("Location: success.php");
    exit();
}

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
    </style>
</head>

<body style="font-family:<?= $fontFamily ?>">

    <div class="bg-white">
        <header class="relative bg-white">
            <?= require "../components/navbar.php"; ?>
        </header>


        <main class="mx-auto mt-8 max-w-2xl px-4 pb-16 sm:px-6 sm:pb-24 lg:max-w-7xl lg:px-8">
            <div class="lg:grid lg:auto-rows-min lg:grid-cols-12 lg:gap-x-8">
                <div class="lg:col-span-5 lg:col-start-8">
                    <div class="flex justify-between">
                        <h1 class="text-xl font-medium text-gray-900">
                            <?= $product['name'] ?>
                        </h1>
                        <p class="text-xl font-medium text-gray-900">$
                            <?= $product['price'] ?>
                        </p>
                    </div>
                    <div class="mt-4">
                        <h2 class="sr-only">Reviews</h2>
                        <div class="flex items-center">
                            <p class="text-sm text-gray-700">
                                3.9
                                <span class="sr-only"> out of 5 stars</span>
                            </p>
                            <div class="ml-1 flex items-center">
                                <svg class="h-5 w-5 flex-shrink-0 text-yellow-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd" />
                                </svg>
                                <svg class="h-5 w-5 flex-shrink-0 text-yellow-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd" />
                                </svg>
                                <svg class="h-5 w-5 flex-shrink-0 text-yellow-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd" />
                                </svg>
                                <svg class="h-5 w-5 flex-shrink-0 text-yellow-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd" />
                                </svg>
                                <svg class="h-5 w-5 flex-shrink-0 text-gray-200" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div aria-hidden="true" class="ml-4 text-sm text-gray-300">·</div>
                            <div class="ml-4 flex">
                                <a href="#recently-review" class="text-sm font-medium text-green-600 hover:text-green-500">
                                    <?= $reviews_dynamic ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 lg:col-span-7 lg:col-start-1 lg:row-span-3 lg:row-start-1 lg:mt-0">
                    <h2 class="sr-only">Images</h2>

                    <div class="grid grid-cols-1 lg:grid-cols-2 lg:grid-rows-3 lg:gap-8">
                        <img src="<?= $product['image_url'] ?>" alt="Back of women&#039;s Basic Tee in black." class="rounded-lg lg:col-span-2 lg:row-span-2">

                    </div>
                </div>

                <div class="mt-8 lg:col-span-5">
                    <form method="POST" action="./checkout.php?id=<?= $id ?>">
                        <button type="submit" class="mt-8 flex w-full items-center justify-center rounded-md border border-transparent bg-green-600 px-8 py-3 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                            <?= $translations['add_to_cart'] ?>
                        </button>
                    </form>


                    <div class="mt-10">
                        <h2 class="text-md font-medium text-gray-900">
                            <?= $translations['description'] ?>
                        </h2>

                        <div class="prose text-sm leading-6 prose-sm mt-4 text-gray-500">
                            <p>The Basic tee is an honest new take on a classic. The tee uses super soft, pre-shrunk cotton for true comfort and a dependable fit. They are hand cut and sewn locally, with a special dye technique that gives each tee it's own look.</p>
                            <p>Looking to stock your closet? The Basic tee also comes in a 3-pack or 5-pack at a bundle discount.</p>
                        </div>
                    </div>

                    <div class="mt-8 border-t border-gray-200 pt-8">
                        <h2 class="text-md font-medium text-gray-900">
                            <?= $translations['ingradient_and_care'] ?>
                        </h2>

                        <div class="prose prose-sm mt-4 text-gray-500 text-sm leading-6 ">
                            <ul role="list" class="list-disc ml-4">
                                <li>Only the best materials</li>
                                <li>Ethically and locally made</li>
                                <li>Pre-washed and pre-shrunk</li>
                                <li>Machine wash cold with similar colors</li>
                            </ul>
                        </div>
                    </div>

                    <section aria-labelledby="policies-heading" class="mt-10">
                        <h2 id="policies-heading" class="sr-only">Our Policies</h2>

                        <dl class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-1 xl:grid-cols-2">
                            <div class="rounded-lg border border-gray-200 bg-gray-50 p-6 text-center">
                                <dt>
                                    <svg class="mx-auto h-6 w-6 flex-shrink-0 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.115 5.19l.319 1.913A6 6 0 008.11 10.36L9.75 12l-.387.775c-.217.433-.132.956.21 1.298l1.348 1.348c.21.21.329.497.329.795v1.089c0 .426.24.815.622 1.006l.153.076c.433.217.956.132 1.298-.21l.723-.723a8.7 8.7 0 002.288-4.042 1.087 1.087 0 00-.358-1.099l-1.33-1.108c-.251-.21-.582-.299-.905-.245l-1.17.195a1.125 1.125 0 01-.98-.314l-.295-.295a1.125 1.125 0 010-1.591l.13-.132a1.125 1.125 0 011.3-.21l.603.302a.809.809 0 001.086-1.086L14.25 7.5l1.256-.837a4.5 4.5 0 001.528-1.732l.146-.292M6.115 5.19A9 9 0 1017.18 4.64M6.115 5.19A8.965 8.965 0 0112 3c1.929 0 3.716.607 5.18 1.64" />
                                    </svg>
                                    <span class="mt-4 text-sm font-medium text-gray-900">
                                        <?= $translations['international_delivery'] ?>
                                    </span>
                                </dt>
                                <dd class="mt-1 text-sm text-gray-500">
                                    <?= $translations['international_delivery_description'] ?>
                                </dd>
                            </div>
                            <div class="rounded-lg border border-gray-200 bg-gray-50 p-6 text-center">
                                <dt>
                                    <svg class="mx-auto h-6 w-6 flex-shrink-0 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="mt-4 text-sm font-medium text-gray-900">
                                        <?= $translations['loyalty_rewards'] ?>
                                    </span>
                                </dt>
                                <dd class="mt-1 text-sm text-gray-500">
                                    <?= $translations['loyalty_rewards_description'] ?>
                                </dd>
                            </div>
                        </dl>
                    </section>
                </div>
            </div>

            <section id="recently-review" aria-labelledby="reviews-heading" class="mt-16 sm:mt-24">
                <h2 id="reviews-heading" class="text-lg font-medium text-gray-900">
                    <?= $translations['recent_reviews'] ?>
                </h2>

                <div class="mt-6 space-y-10 divide-y divide-gray-200 border-b border-t border-gray-200 pb-10">

                    <?php if ($reviews_result->num_rows === 0) : ?>
                        <div class="pt-10 text-center">
                            <p class="text-gray-500">No reviews yet. Be the first to review this product! 🚀</p>
                        </div>
                    <?php else : ?>
                        <?php while ($review = $reviews_result->fetch_assoc()) : ?>
                            <div class="pt-10 lg:grid lg:grid-cols-12 lg:gap-x-8">
                                <div class="lg:col-span-8 lg:col-start-5 xl:col-span-9 xl:col-start-4 xl:grid xl:grid-cols-3 xl:items-start xl:gap-x-8">
                                    <div class="flex items-center xl:col-span-1 mt-2">
                                        <div class="flex items-center">
                                            <?php
                                            $rating = $review['rating'];

                                            for ($i = 1; $i <= 5; $i++) {
                                                $colorClass = $i <= $rating ? 'text-yellow-400' : 'text-gray-200'; // Set color based on rating
                                                echo '<svg class="h-5 w-5 flex-shrink-0 ' . $colorClass . '" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd" />
          </svg>';
                                            }
                                            ?>
                                        </div>
                                        <p class="ml-3 text-sm font-medium text-gray-700">
                                            <?= $review['rating'] ?>
                                            <span class="sr-only"> out of 5 stars</span>
                                        </p>
                                    </div>

                                    <div class="mt-4 lg:mt-6 xl:col-span-2 xl:mt-0">
                                        <h3 class="text-sm font-medium text-gray-900">
                                            <?= $review['review_title'] ?>
                                        </h3>

                                        <div class="mt-3 space-y-6 text-sm text-gray-500">
                                            <p>
                                                <?= $review['review_text'] ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-6 flex items-center justify-center text-sm lg:col-span-4 lg:col-start-1 gap-3 lg:row-start-1 lg:mt-0 lg:items-start xl:col-span-3">
                                    <div>
                                        <img class="rounded-full h-12 w-12" src="<?= $review['user_image'] ?>" alt="">
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">
                                            <?= $review['username'] ?>
                                        </p>
                                        <time class="ml-4 border-l border-gray-200 pl-4 text-gray-500 lg:ml-0 lg:mt-2 lg:border-0 lg:pl-0">
                                            <?= date('Y-m-d', strtotime($review['created_at'])) ?>
                                        </time>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php endif; ?>

                </div>
            </section>

            <section aria-labelledby="related-heading" class="mt-16 sm:mt-24">
                <h2 id="related-heading" class="text-lg font-medium text-gray-900">
                    <?= $translations['customers_also_purchased'] ?>
                </h2>

                <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">

                    <?php foreach ($limit_products as $product) : ?>

                        <div class="group relative">
                            <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md lg:aspect-none group-hover:opacity-75 lg:h-80">
                                <img src="<?php echo $product['image_url']; ?>"
                                    alt="<?php echo htmlspecialchars($product['name']); ?>"
                                    class="h-full w-full object-cover object-center lg:h-full lg:w-full">
                            </div>
                            <div class="mt-4 flex justify-between">
                                <div>
                                    <h3 class="text-sm text-gray-700">
                                        <a href="http://localhost/foodfarm/views/single-product.php?id=<?= $product['id']; ?>">
                                            <span aria-hidden="true" class="absolute inset-0"></span>
                                            <?= htmlspecialchars($product['name']); ?>
                                        </a>
                                    </h3>
                                    <p class="mt-1 text-sm text-gray-500">
                                        <?= htmlspecialchars($product['description']); ?>
                                    </p>
                                </div>
                                <p class="text-sm font-medium text-gray-900">$<?= htmlspecialchars($product['price']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>



                </div>
            </section>
        </main>

        <footer aria-labelledby="footer-heading">
            <h2 id="footer-heading" class="sr-only">Footer</h2>
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="border-t border-gray-200 py-20">
                    <div class="grid grid-cols-1 md:grid-flow-col md:auto-rows-min md:grid-cols-12 md:gap-x-8 md:gap-y-16">
                        <div class="col-span-1 md:col-span-2 lg:col-start-1 lg:row-start-1">
                            <img src="https://tailwindui.com/img/logos/mark.svg?color=green&shade=600" alt="" class="h-8 w-auto">
                        </div>

                        <div class="col-span-6 mt-10 grid grid-cols-2 gap-8 sm:grid-cols-3 md:col-span-8 md:col-start-3 md:row-start-1 md:mt-0 lg:col-span-6 lg:col-start-2">
                            <div class="grid grid-cols-1 gap-y-12 sm:col-span-2 sm:grid-cols-2 sm:gap-x-8">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-900">Products</h3>
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
                            <div>
                                <h3 class="text-sm font-medium text-gray-900">Customer Service</h3>
                                <ul role="list" class="mt-6 space-y-6">
                                    <li class="text-sm">
                                        <a href="#" class="text-gray-500 hover:text-gray-600">Contact</a>
                                    </li>
                                    <li class="text-sm">
                                        <a href="#" class="text-gray-500 hover:text-gray-600">Shipping</a>
                                    </li>
                                    <li class="text-sm">
                                        <a href="#" class="text-gray-500 hover:text-gray-600">Returns</a>
                                    </li>
                                    <li class="text-sm">
                                        <a href="#" class="text-gray-500 hover:text-gray-600">Warranty</a>
                                    </li>
                                    <li class="text-sm">
                                        <a href="#" class="text-gray-500 hover:text-gray-600">Secure Payments</a>
                                    </li>
                                    <li class="text-sm">
                                        <a href="#" class="text-gray-500 hover:text-gray-600">FAQ</a>
                                    </li>
                                    <li class="text-sm">
                                        <a href="#" class="text-gray-500 hover:text-gray-600">Find a store</a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="mt-12 md:col-span-8 md:col-start-3 md:row-start-2 md:mt-0 lg:col-span-4 lg:col-start-9 lg:row-start-1">
                            <h3 class="text-sm font-medium text-gray-900">Sign up for our newsletter</h3>
                            <p class="mt-6 text-sm text-gray-500">The latest deals and savings, sent to your inbox weekly.</p>
                            <form class="mt-2 flex sm:max-w-md">
                                <label for="email-address" class="sr-only">Email address</label>
                                <input id="email-address" type="text" autocomplete="email" required class="w-full min-w-0 appearance-none rounded-md border border-gray-300 bg-white px-4 py-2 text-base text-gray-900 placeholder-gray-500 shadow-sm focus:border-green-500 focus:outline-none focus:ring-1 focus:ring-green-500">
                                <div class="ml-4 flex-shrink-0">
                                    <button type="submit" class="flex w-full items-center justify-center rounded-md border border-transparent bg-green-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">Sign up</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-100 py-10 text-center">
                    <p class="text-sm text-gray-500">&copy; 2021 Your Company, Inc. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </div>
    <script>
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
        const headerElement = document.querySelector("header.relative.bg-white");
        const childNodes = headerElement.childNodes;
        childNodes.forEach(node => {
            if (node.nodeType === Node.TEXT_NODE && node.textContent.trim() === "1") {
                headerElement.removeChild(node);
            }
        });
        const sizeLabels = document.querySelectorAll('fieldset label');

        sizeLabels.forEach(label => {
            label.addEventListener('click', () => {
                sizeLabels.forEach(lbl => {
                    lbl.classList.remove('border-green-500');
                });
                label.classList.add('border-green-500');
            });
        });
    </script>

</body>

</html>