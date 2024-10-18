<?php
require_once "../config/database.php";

$name = "";
$description = "";
$price = "";
$stock = "";
$image = "";

if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        $name = $product['name'];
        $description = $product['description'];
        $price = $product['price'];
        $stock = $product['stock_quantity'];
        $image = $product['image_url'];
    } else {
        echo "Product not found!";
    }

    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $productId = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $image = $_POST['image'];

    $stmt = $conn->prepare("UPDATE products SET name = ?, description = ?, price = ?, stock_quantity = ?, image_url = ? WHERE id = ?");
    $stmt->bind_param("ssdssi", $name, $description, $price, $stock, $image, $productId);

    if ($stmt->execute()) {
        echo '
<div id="toast" class="w-[22rem] fixed top-0 left-[40%] mt-4">
    <div class="flex w-full max-w-sm py-5 px-6 bg-white rounded-xl border border-gray-200 shadow-sm mb-4 gap-4" role="alert">
        <div class="inline-flex space-x-3">
            <span class="bg-green-50 w-9 h-9 rounded-full flex-shrink-0 flex justify-center items-center">
                <svg class="w-5 h-5 text-green-600" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M5 10L8 13L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
</svg>

            </span>
            <div class="flex flex-col">
                <span class="font-semibold text-green-600">Success!</span>
                <span class="text-sm text-gray-500">Product added successfully!</span>
            </div>
        </div>
    </div>
</div>
';
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
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

<body style="font-family: 'Inter'">
    <header>
        <nav
            class="flex items-center justify-between p-6 lg:px-8"
            aria-label="Global">
            <div class="flex lg:flex-1">
                <a href="#" class="-m-1.5 p-1.5">
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
    <form class="grid place-items-center py-12" method="POST">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($_GET['id']); ?>">
        <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-12">
                <h2 class="text-base font-semibold leading-7 text-gray-900">Edit product</h2>
                <p class="mt-1 text-sm leading-6 text-gray-600">Please fill out the form below to Edit a new product to our inventory.</p>

                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="sm:col-span-4">
                        <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Name</label>
                        <div class="mt-2">
                            <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-600 sm:max-w-md">
                                <input type="text" name="name" id="name" autocomplete="name" class="block flex-1 border-0 bg-transparent py-1.5 pl-3 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" value="<?php echo htmlspecialchars($name); ?>" placeholder="Product name" required>
                            </div>
                        </div>
                    </div>

                    <div class="sm:col-span-4">
                        <label for="description" class="block text-sm font-medium leading-6 text-gray-900">Description</label>
                        <div class="mt-2">
                            <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-600 sm:max-w-md">
                                <input type="text" name="description" id="description" autocomplete="description" class="block flex-1 border-0 bg-transparent py-1.5 pl-3 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" value="<?php echo htmlspecialchars($description); ?>" placeholder="Description" required>
                            </div>
                        </div>
                    </div>

                    <div class="sm:col-span-4">
                        <label for="price" class="block text-sm font-medium leading-6 text-gray-900">Price</label>
                        <div class="mt-2">
                            <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-600 sm:max-w-md">
                                <input type="number" name="price" id="price" autocomplete="price" class="block flex-1 border-0 bg-transparent py-1.5 pl-3 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" value="<?php echo htmlspecialchars($price); ?>" placeholder="$" required step="0.01">
                            </div>
                        </div>
                    </div>


                    <div class="sm:col-span-4">
                        <label for="stock" class="block text-sm font-medium leading-6 text-gray-900">Stock Quantity</label>
                        <div class="mt-2">
                            <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-600 sm:max-w-md">
                                <input type="number" name="stock" id="stock" autocomplete="stock" class="block flex-1 border-0 bg-transparent py-1.5 pl-3 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" value="<?php echo htmlspecialchars($stock); ?>" placeholder="Number of stock" required>
                            </div>
                        </div>
                    </div>

                    <div class="sm:col-span-4">
                        <label for="image" class="block text-sm font-medium leading-6 text-gray-900">Image URL</label>
                        <div class="mt-2 flex flex-col items-center">
                            <div class="flex rounded-md self-stretch shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-600 sm:max-w-md">
                                <input type="text" name="image" id="image" autocomplete="image" class="block flex-1 border-0 bg-transparent py-1.5 pl-3 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" value="<?php echo htmlspecialchars($image); ?>" placeholder="http://example.com/" required>

                            </div>
                            <div class="mt-4">
                                <img id="preview" src="<?php echo htmlspecialchars($image); ?>" class="w-32 h-32 object-cover" alt="Product Image">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-6 flex items-center justify-end gap-x-6">
            <button type="button" class="text-sm font-semibold leading-6 text-gray-900">Cancel</button>
            <button type="submit" class="rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">Edit</button>
        </div>
    </form>

    <script>
        document.getElementById('image').addEventListener('input', function() {
            var imageUrl = this.value;
            document.getElementById('preview').src = imageUrl;
        });

        const toast = document.getElementById('toast');

        gsap.fromTo(toast, {
            y: -100,
            opacity: 0
        }, {
            y: 0,
            opacity: 1,
            duration: 0.5
        });

        setTimeout(() => {
            gsap.to(toast, {
                y: -100,
                opacity: 0,
                duration: 1,
                onComplete: () => {
                    toast.style.display = 'none';
                }
            });
        }, 3000);
    </script>

</body>

</html>