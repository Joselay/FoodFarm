<?php
require_once "../config/database.php";

$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$items_per_page = 12;

$countSql = "SELECT COUNT(*) AS total FROM products";
$countResult = $conn->query($countSql);
$total_results = $countResult->fetch_assoc()['total'];

$total_pages = ceil($total_results / $items_per_page);

$start_item = ($current_page - 1) * $items_per_page + 1;
$end_item = min($current_page * $items_per_page, $total_results);

function pagination_link($page, $label, $is_active = false)
{
    $class = $is_active ? 'bg-green-600 text-white' : 'text-gray-900 hover:bg-gray-50';
    echo "<a href=\"?page=$page\" class=\"relative inline-flex items-center px-4 py-2 text-sm font-semibold $class ring-1 ring-inset ring-gray-300 focus:z-20\">$label</a>";
}
?>

<div class="flex items-center justify-between mt-8 border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
    <div class="flex flex-1 justify-between sm:hidden">
        <a href="?page=<?= max(1, $current_page - 1) ?>" class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Previous</a>
        <a href="?page=<?= min($total_pages, $current_page + 1) ?>" class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Next</a>
    </div>
    <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
        <div>
            <p class="text-sm text-gray-700">
                Showing
                <span class="font-medium"><?= $start_item ?></span>
                to
                <span class="font-medium"><?= $end_item ?></span>
                of
                <span class="font-medium"><?= $total_results ?></span>
                results
            </p>
        </div>
        <div>
            <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                <a href="?page=<?= max(1, $current_page - 1) ?>" class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                    <span class="sr-only">Previous</span>
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" />
                    </svg>
                </a>

                <?php for ($page = 1; $page <= $total_pages; $page++): ?>
                    <?php if ($page == $current_page): ?>
                        <a href="#" aria-current="page" class="relative z-10 inline-flex items-center bg-green-600 px-4 py-2 text-sm font-semibold text-white focus:z-20 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600"><?= $page ?></a>
                    <?php else: ?>
                        <?php pagination_link($page, $page); ?>
                    <?php endif; ?>
                <?php endfor; ?>

                <a href="?page=<?= min($total_pages, $current_page + 1) ?>" class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                    <span class="sr-only">Next</span>
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                    </svg>
                </a>
            </nav>
        </div>
    </div>
</div>

<?php
$conn->close();
?>