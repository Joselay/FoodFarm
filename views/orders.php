<?php
require "../utils/dd.php";
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ./views/signin.php");
    exit();
}

require "../config/database.php";

$userId = $_SESSION['user_id'];
$userName = $_SESSION['user_username'];
$userEmail = $_SESSION['user_email'];
$imageUrl = $_SESSION['user_image_url'];

$sql = "
    SELECT o.id AS order_id, 
           o.total_amount, 
           o.status, 
           o.created_at, 
           SUM(oi.quantity) AS quantity,
           p.price AS item_price,
           p.name AS product_name, 
           p.image_url
    FROM orders o
    LEFT JOIN order_items oi ON o.id = oi.order_id
    LEFT JOIN products p ON oi.product_id = p.id
    WHERE o.user_id = ?
    GROUP BY o.id, oi.product_id ORDER BY o.created_at DESC
";


$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $userId);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    echo "Error fetching orders: " . mysqli_error($conn);
    exit();
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
</head>

<body style="font-family: 'Inter';">
    <?php require "../components/header.php"; ?>

    <div class="mx-auto max-w-7xl pt-16 lg:flex lg:gap-x-16 lg:px-8">
        <aside class="flex overflow-x-auto border-b border-gray-900/5 py-4 lg:block lg:w-64 lg:flex-none lg:border-0 lg:py-20">
            <nav class="flex-none px-4 sm:px-6 lg:px-0">
                <ul role="list" class="flex gap-x-3 gap-y-1 whitespace-nowrap lg:flex-col">
                    <li>
                        <a href="./profile.php" class="group flex gap-x-3 rounded-md py-2 pl-2 pr-3 text-sm font-semibold leading-6 text-gray-700 hover:bg-gray-50 hover:text-green-600">
                            <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Profile
                        </a>
                    </li>
                    <li>
                        <a href="#" class="group flex gap-x-3 rounded-md bg-gray-50 py-2 pl-2 pr-3 text-sm font-semibold leading-6 text-green-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                            </svg>
                            Orders
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
                            <h1 class="text-2xl font-bold leading-6 text-gray-900">Orders</h1>
                        </div>
                    </div>
                    <div class="mt-8 flow-root">
                        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                <table class="min-w-full divide-y divide-gray-300">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Order ID</th>
                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Product</th>
                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Unit Price</th>
                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Quantity</th> <!-- Added Quantity Header -->
                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Total Amount</th>
                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status</th>
                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Created At</th>
                                        </tr>
                                    </thead>

                                    <tbody class="divide-y divide-gray-200 bg-white">
                                        <?php while ($row = mysqli_fetch_assoc($result)):
                                            $lineTotal = $row['item_price'] * $row['quantity'];
                                        ?>
                                            <tr>
                                                <td class="whitespace-nowrap py-5 pl-4 pr-3 text-sm sm:pl-0">
                                                    <div class="font-medium text-gray-900"><?= htmlspecialchars($row['order_id']) ?></div>
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500">
                                                    <div class="flex items-center">
                                                        <img src="<?= htmlspecialchars($row['image_url']) ?>" alt="<?= htmlspecialchars($row['product_name']) ?>" class="w-10 h-10 mr-2">
                                                        <span><?= htmlspecialchars($row['product_name']) ?></span>
                                                    </div>
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500">
                                                    $<?= number_format($row['item_price'], 2) ?> <!-- Price from products table -->
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500">
                                                    <?= htmlspecialchars($row['quantity']) ?> <!-- Display quantity -->
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500">
                                                    <div class="text-gray-900">$<?= number_format($lineTotal, 2) ?></div>
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500">
                                                    <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium <?= $row['status'] == 'completed' ? 'bg-green-100 text-green-800' : ($row['status'] == 'canceled' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') ?>">
                                                        <?= htmlspecialchars($row['status']) ?>
                                                    </span>
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500"><?= htmlspecialchars($row['created_at']) ?></td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

</body>

</html>