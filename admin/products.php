<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Products</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link rel="icon" href="../public/images/apple.svg" type="image/icon type">

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
  require_once "../config/database.php";

  $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
  $items_per_page = 12;

  $total_results_sql = "SELECT COUNT(*) as total FROM products";
  $total_results_result = $conn->query($total_results_sql);
  $total_results_row = $total_results_result->fetch_assoc();
  $total_results = $total_results_row['total'];

  $total_pages = ceil($total_results / $items_per_page);

  $offset = ($current_page - 1) * $items_per_page;

  $sql = "SELECT p.*, c.name AS category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id LIMIT $items_per_page OFFSET $offset";
  $result = $conn->query($sql);
  ?>

  <?php require_once "./components/header.php"; ?>

  <div class="px-4 sm:px-6 lg:px-8">
    <div class="sm:flex sm:items-center">
      <div class="sm:flex-auto">
        <h1 class="text-base font-semibold leading-6 text-gray-900">Products</h1>
        <p class="mt-2 text-sm text-gray-700">A list of all the products in admin dashboard including their category, name, description, price, stock quantity.</p>
      </div>
      <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
        <a href="add-product.php" class="block rounded-md bg-green-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-green-500 focus-visible:outline-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">Add product</a>
      </div>
    </div>
    <div class="mt-8 flow-root">
      <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
          <table class="min-w-full divide-y divide-gray-300">
            <thead>
              <tr>
                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Image</th>
                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Name</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Category</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Description</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Price</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Stock Quantity</th>
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
                  echo "<img class='h-10 w-10 rounded-full' src='" . htmlspecialchars($row['image_url']) . "' alt='Product Image'>";
                  echo "</td>";
                  echo "<td class='whitespace-nowrap py-5 pl-4 pr-3 text-sm sm:pl-0'>" . htmlspecialchars($row['name']) . "</td>";
                  echo "<td class='whitespace-nowrap px-3 py-5 text-sm text-gray-500'>" . htmlspecialchars($row['category_name']) . "</td>";
                  echo "<td class='whitespace-nowrap px-3 py-5 text-sm text-gray-500'>" . htmlspecialchars($row['description']) . "</td>";
                  echo "<td class='whitespace-nowrap px-3 py-5 text-sm text-gray-500'>" . htmlspecialchars($row['price']) . "</td>";
                  echo "<td class='whitespace-nowrap px-3 py-5 text-sm text-gray-500'>" . htmlspecialchars($row['stock_quantity']) . "</td>";
                  echo "<td class='relative whitespace-nowrap py-5 pl-3 pr-4 text-right text-sm font-medium sm:pr-0'>";
                  echo "<a href='edit-product.php?id=" . $row['id'] . "' class='text-green-600 hover:text-green-900'>Edit<span class='sr-only'>, " . htmlspecialchars($row['name']) . "</span></a>";

                  echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                  echo "<a href='#' class='text-red-600 hover:text-red-900 delete-btn' onclick='confirmDelete(" . $row['id'] . ")'>Delete<span class='sr-only'>, " . htmlspecialchars($row['name']) . "</span></a>";
                  echo "</td>";
                  echo "</tr>";
                }
              } else {
                echo "<tr><td colspan='7' class='text-center py-5'>No products found</td></tr>";
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
      window.location.href = 'delete_product.php?id=' + id;
    }
  </script>

</body>

</html>