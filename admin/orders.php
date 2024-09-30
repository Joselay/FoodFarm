<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="icon" href="../public/images/apple.svg" type="image/icon type">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>

</head>

<body style="font-family: 'Inter'">

    <?php
    $servername = "localhost";
    $username = "jose";
    $password = "jose";
    $dbname = "jose";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $showToast = isset($_GET['status']) && $_GET['status'] === 'success';

    $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $items_per_page = 12;

    $total_results_sql = "SELECT COUNT(*) as total FROM orders";
    $total_results_result = $conn->query($total_results_sql);
    $total_results_row = $total_results_result->fetch_assoc();
    $total_results = $total_results_row['total'];

    $total_pages = ceil($total_results / $items_per_page);
    $offset = ($current_page - 1) * $items_per_page;

    $sql = "
        SELECT o.id AS order_id, o.total_price, o.status, o.order_date, p.name AS product_name, o.quantity, p.image_url AS product_image, u.email AS customer_email
        FROM orders o
        LEFT JOIN products p ON o.product_id = p.id
        LEFT JOIN users u ON o.user_id = u.id
        ORDER BY o.order_date DESC
        LIMIT $items_per_page OFFSET $offset
    ";
    $result = $conn->query($sql);
    ?>

    <?php require_once "./components/header.php"; ?>

    <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-base font-semibold leading-6 text-gray-900">Orders</h1>
                <p class="mt-2 text-sm text-gray-700">A list of all the orders in the admin dashboard including the order ID, customer email, product name, product image, total amount, status, and creation date.</p>
            </div>
        </div>
        <div class="mt-8 flow-root">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead>
                            <tr>
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Order ID</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Customer Email</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Product Image</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Product Name</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Total Amount</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Quantity</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Created At</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td class='whitespace-nowrap py-5 pl-4 pr-3 text-sm sm:pl-0'>" . htmlspecialchars($row['order_id']) . "</td>";
                                    echo "<td class='whitespace-nowrap px-3 py-5 text-sm text-gray-500'>" . htmlspecialchars($row['customer_email']) . "</td>";
                                    echo "<td class='whitespace-nowrap py-5 pl-4 pr-3 text-sm sm:pl-0'>";
                                    echo "<img class='h-10 w-10 rounded-full object-cover' src='" . htmlspecialchars($row['product_image']) . "' alt='Product Image'>";
                                    echo "</td>";
                                    echo "<td class='whitespace-nowrap px-3 py-5 text-sm text-gray-500'>" . htmlspecialchars($row['product_name']) . "</td>";
                                    echo "<td class='whitespace-nowrap px-3 py-5 text-sm text-gray-500'>$" . htmlspecialchars($row['total_price']) . "</td>";
                                    echo "<td class='whitespace-nowrap px-3 py-5 text-sm text-gray-500'>" . htmlspecialchars($row['quantity']) . "</td>";
                                    echo "<td class='whitespace-nowrap px-3 py-5 text-sm'>";
                                    echo "<form class='flex justify-center items-center gap-4' method='POST' action='update_order_status.php'>";
                                    echo "<input type='hidden' name='order_id' value='" . htmlspecialchars($row['order_id']) . "'>";
                                    echo "<select name='status' class='block w-full px-2 py-1 border border-gray-300 rounded-md'>";
                                    echo "<option value='pending'" . ($row['status'] == 'pending' ? ' selected' : '') . ">Pending</option>";
                                    echo "<option value='shipped'" . ($row['status'] == 'shipped' ? ' selected' : '') . ">Shipped</option>";
                                    echo "<option value='delivered'" . ($row['status'] == 'delivered' ? ' selected' : '') . ">Delivered</option>";
                                    echo "<option value='cancelled'" . ($row['status'] == 'cancelled' ? ' selected' : '') . ">Cancelled</option>";
                                    echo "</select>";
                                    echo "<button type='submit' class='mt-1 inline-flex items-center rounded-md bg-green-600 px-2 py-1 text-xs font-medium text-white shadow-sm hover:bg-green-500'>Update</button>";
                                    echo "</form>";
                                    echo "</td>";
                                    echo "<td class='whitespace-nowrap px-3 py-5 text-sm text-gray-500'>" . htmlspecialchars($row['order_date']) . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='8' class='text-center py-5'>No orders found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php require "./pagination.php"; ?>
    </div>

    <?php if ($showToast): ?>
        <div id="toast" class="w-[22rem] fixed top-0 left-[40%] mt-10">
            <div class="flex w-full max-w-sm py-5 px-6 bg-white rounded-xl border border-gray-200 shadow-sm mb-4 gap-4" role="alert">
                <div class="inline-flex space-x-3">
                    <span class="bg-green-50 w-9 h-9 rounded-full flex-shrink-0 flex justify-center items-center">
                        <svg class="w-5 h-5 text-green-600" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5 10L8 13L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>

                    </span>
                    <div class="flex flex-col">
                        <span class="font-semibold text-green-600">Success!</span>
                        <span class="text-sm text-gray-500">Product updated successfully!</span>
                    </div>
                </div>
            </div>
        </div>
        <script>
            const toast = document.getElementById('toast');

            gsap.to(toast, {
                opacity: 1,
                y: -20,
                duration: 0.5,
                ease: "power2.out"
            });

            setTimeout(() => {
                gsap.to(toast, {
                    opacity: 0,
                    y: 0,
                    duration: 0.5,
                    ease: "power2.in",
                    onComplete: () => {
                        toast.style.display = 'none';
                    }
                });
            }, 3000);
        </script>
    <?php endif; ?>

</body>

</html>