<?php
// Database connection settings
$servername = "localhost"; // Change if necessary
$username = "jose"; // Your database username
$password = "jose"; // Your database password
$dbname = "jose"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Define number of results per page
$results_per_page = 12; // You can change this number to control how many products per page

// Find out the number of results stored in database
$sql_count = "SELECT COUNT(id) AS total FROM products";
$result_count = $conn->query($sql_count);
$row_count = $result_count->fetch_assoc();
$total_products = $row_count['total'];

// Determine number of total pages available
$total_pages = ceil($total_products / $results_per_page);

// Get the current page or set default to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;

// Calculate the starting limit for the results on the displaying page
$starting_limit = ($page - 1) * $results_per_page;

// SQL query to retrieve selected results per page
$sql = "SELECT id, name, description, price,stock_quantity, image_url FROM products LIMIT $starting_limit, $results_per_page";
$result = $conn->query($sql);
?>

<div id="products" class="bg-white">
  <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
    <div class="md:flex md:items-center md:justify-between">
      <h2 class="text-2xl font-bold tracking-tight text-gray-900"> Products</h2>
    </div>

    <div class="mt-6 grid grid-cols-2 gap-x-4 gap-y-10 sm:gap-x-6 md:grid-cols-4 md:gap-y-0 lg:gap-x-8">
      <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <div class="group relative">
            <a href="views/single-product.php?id=<?php echo htmlspecialchars($row['id']); ?>" class="block h-full">
              <?php if ($row['stock_quantity'] == 0): ?>
                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-white bg-gray-900/50 w-full flex items-center justify-center h-16 text-lg font-medium z-10">
                  <h1>Out of stock</h1>
                </div>
              <?php endif; ?>

              <div class="h-56 w-full overflow-hidden rounded-md bg-gray-200 group-hover:opacity-75 lg:h-72 xl:h-80">
                <img src="<?php echo htmlspecialchars($row['image_url']); ?>" alt="<?php echo htmlspecialchars($row['description']); ?>" class="h-full w-full object-cover object-center transition-opacity duration-300">
              </div>

              <h3 class="mt-4 text-sm text-gray-700">
                <?php echo htmlspecialchars($row['name']); ?>
              </h3>
              <p class="mt-1 text-sm text-gray-500"><?php echo htmlspecialchars($row['description']); ?></p>
              <p class="mt-1 text-sm font-medium text-gray-900">$<?php echo htmlspecialchars($row['price']); ?></p>
            </a>
          </div>

        <?php endwhile; ?>
      <?php else: ?>
        <p class="text-gray-500">No products available.</p>
      <?php endif; ?>
    </div>

    <!-- Pagination controls -->
    <div class="flex items-center justify-between mt-8 border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
      <div class="flex flex-1 justify-between sm:hidden">
        <!-- Previous Button for Small Screens -->
        <?php if ($page > 1): ?>
          <a href="?page=<?php echo $page - 1; ?>" class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Previous</a>
        <?php endif; ?>

        <?php if ($page < $total_pages): ?>
          <a href="?page=<?php echo $page + 1; ?>" class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Next</a>
        <?php endif; ?>
      </div>
      <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
        <div>
          <p class="text-sm text-gray-700">
            Showing
            <span class="font-medium"><?php echo ($starting_limit + 1); ?></span>
            to
            <span class="font-medium"><?php echo min($starting_limit + $results_per_page, $total_products); ?></span>
            of
            <span class="font-medium"><?php echo $total_products; ?></span>
            results
          </p>
        </div>
        <div>
          <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
            <!-- Previous Button -->
            <?php if ($page > 1): ?>
              <a href="?page=<?php echo $page - 1; ?>" class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                <span class="sr-only">Previous</span>
                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" />
                </svg>
              </a>
            <?php endif; ?>

            <!-- Page Numbers -->
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
              <a href="?page=<?php echo $i; ?>" class="relative inline-flex items-center px-4 py-2 text-sm font-semibold <?php echo ($i == $page) ? 'bg-green-600 text-white' : 'text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50'; ?> focus:z-20 focus:outline-offset-0"><?php echo $i; ?></a>
            <?php endfor; ?>

            <!-- Next Button -->
            <?php if ($page < $total_pages): ?>
              <a href="?page=<?php echo $page + 1; ?>" class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                <span class="sr-only">Next</span>
                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                </svg>
              </a>
            <?php endif; ?>
          </nav>
        </div>
      </div>
    </div>

  </div>
</div>

<?php
$conn->close(); // Close the database connection
?>