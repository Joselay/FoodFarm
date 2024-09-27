<?php
require "../utils/dd.php";
require "../config/database.php";
session_start();

$productId = $_SESSION['product_id'];

$query = "UPDATE products SET stock_quantity = stock_quantity - 1 WHERE id = '$productId'";

mysqli_query($conn, $query);

mysqli_close($conn);
?>


<!DOCTYPE html>
<html class="h-full" lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Success</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body style="font-family: 'Inter';" class="h-full">

    <main class="grid min-h-full place-items-center bg-white px-6 py-24 sm:py-32 lg:px-8">
        <div class="text-center">
            <div class="bg-green-200 inline-block rounded-full w-32 h-32 flex items-center justify-center mx-auto mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 mx-auto bg-green-500 rounded-full stroke-white w-[108px] h-[108px] p-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                </svg>
            </div>

            <p class="text-base font-semibold text-green-600">Success</p>


            <h1 class="mt-4 text-3xl font-bold tracking-tight text-gray-900 sm:text-5xl">Transaction Completed</h1>
            <p class="mt-6 text-base leading-7 text-gray-600">Thank you! Your transaction has been successfully processed.</p>
            <div class="mt-10 flex items-center justify-center gap-x-6">
                <a href="#" class="rounded-md bg-green-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">Go back home</a>
                <a href="#" class="text-sm font-semibold text-gray-900">View transaction details <span aria-hidden="true">&rarr;</span></a>
            </div>
        </div>
    </main>
</body>

</html>