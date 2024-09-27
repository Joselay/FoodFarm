<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="icon" href="../public/images/apple.svg" type="image/icon type">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<style>
    html {
        scroll-behavior: smooth;
    }
</style>

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

    $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $items_per_page = 12;

    $total_results_sql = "SELECT COUNT(*) as total FROM users";
    $total_results_result = $conn->query($total_results_sql);
    $total_results_row = $total_results_result->fetch_assoc();
    $total_results = $total_results_row['total'];

    $total_pages = ceil($total_results / $items_per_page);

    $offset = ($current_page - 1) * $items_per_page;

    $sql = "SELECT * FROM users LIMIT $items_per_page OFFSET $offset";
    $result = $conn->query($sql);
    ?>

    <header>
        <nav
            class="flex items-center justify-between p-6 lg:px-8"
            aria-label="Global">
            <div class="flex lg:flex-1">
                <a href="./" class="-m-1.5 p-1.5">
                    <span class="sr-only">Your Company</span>
                    <img
                        class="h-8 w-auto"
                        src="../public/images/logo.svg"
                        alt="" />
                </a>
            </div>
            <div class="hidden lg:flex lg:gap-x-12">
                <a href="./products.php" class="text-sm font-semibold leading-6 text-gray-900">Products</a>
                <a href="./users.php" class="text-sm font-semibold leading-6 text-gray-900">Users</a>
            </div>
            <div class="hidden lg:flex lg:flex-1 lg:justify-end justify-center items-center gap-2">
                <img class="inline-block h-8 w-8 rounded-full object-cover" src="https://cdn.oneesports.gg/cdn-data/2023/04/Anime_DemonSlayer_Muzan_3-450x253.jpg" alt="">
                <span class="text-sm">Admin</span>
            </div>
        </nav>
    </header>

    <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-base font-semibold leading-6 text-gray-900">Users</h1>
                <p class="mt-2 text-sm text-gray-700">A list of all users in the admin dashboard, including their username, email, role, and profile image.</p>
            </div>
            <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                <a href="add-user.php" class="block rounded-md bg-green-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">Add user</a>
            </div>
        </div>
        <div class="mt-8 flow-root">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead>
                            <tr>
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Image</th>
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Username</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Email</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Role</th>
                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                    <span class="sr-only">Edit</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td class='whitespace-nowrap py-5 pl-4 pr-3 text-sm sm:pl-0'>";
                                    echo "<img class='object-cover h-10 w-10 rounded-full' src='" . htmlspecialchars($row['image_url']) . "' alt='User Image'>";
                                    echo "</td>";
                                    echo "<td class='whitespace-nowrap py-5 pl-4 pr-3 text-sm sm:pl-0'>" . htmlspecialchars($row['username']) . "</td>";
                                    echo "<td class='whitespace-nowrap px-3 py-5 text-sm text-gray-500'>" . htmlspecialchars($row['email']) . "</td>";
                                    echo "<td class='whitespace-nowrap px-3 py-5 text-sm text-gray-500'>" . htmlspecialchars($row['role']) . "</td>";
                                    echo "<td class='relative whitespace-nowrap py-5 pl-3 pr-4 text-right text-sm font-medium sm:pr-0'>";
                                    echo "<a href='edit-user.php?id=" . $row['id'] . "' class='text-green-600 hover:text-green-900'>Edit<span class='sr-only'>, " . htmlspecialchars($row['username']) . "</span></a>";

                                    echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                    echo "<a href='#' class='text-red-600 hover:text-red-900 delete-btn' onclick='confirmDelete(" . $row['id'] . ")'>Delete<span class='sr-only'>, " . htmlspecialchars($row['username']) . "</span></a>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5' class='text-center py-5'>No users found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php require "./pagination.php"; ?>
    </div>

    <script>
        function confirmDelete(id) {
            const deleteDialog = document.querySelector('.delete-dialog');
            const deleteBtn = document.querySelector('.delete-btn');
            deleteBtn.addEventListener('click', (e) => {
                e.preventDefault();
            });
            window.location.href = 'delete_user.php?id=' + id;
        }
    </script>

</body>

</html>