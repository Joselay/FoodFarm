<?php
$servername = "localhost";
$username = "jose";
$password = "jose";
$dbname = "jose";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $image_url = $_POST['image_url'];
    $role = 'user';

    $stmt = $conn->prepare("INSERT INTO users (username, email, password, image_url, role) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $username, $email, $password, $image_url, $role);

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
                <span class="text-sm text-gray-500">User added successfully!</span>
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
    <title>Add User</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="icon" href="../public/images/apple.svg" type="image/icon type">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
</head>

<body style="font-family: 'Inter'">
    <header>
        <nav class="flex items-center justify-between p-6 lg:px-8" aria-label="Global">
            <div class="flex lg:flex-1">
                <a href="#" class="-m-1.5 p-1.5">
                    <span class="sr-only">Your Company</span>
                    <img class="h-8 w-auto" src="../public/images/logo.svg" alt="" />
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
    <form class="flex flex-col justify-center items-center" method="POST">
        <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-12 w-full mt-8">
                <h2 class="text-base font-semibold leading-7 text-gray-900">Add User</h2>
                <p class="mt-1 text-sm leading-6 text-gray-600">Please fill out the form below to add a new user.</p>

                <div class="flex flex-col gap-6 mt-8">
                    <div class="sm:col-span-4">
                        <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Name</label>
                        <div class="mt-2">
                            <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-600 sm:max-w-md">
                                <input type="text" name="name" id="name" autocomplete="name" class="block flex-1 border-0 bg-transparent py-1.5 pl-3 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" required>
                            </div>
                        </div>
                    </div>

                    <div class="sm:col-span-4">
                        <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email</label>
                        <div class="mt-2">
                            <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-600 sm:max-w-md">
                                <input type="email" name="email" id="email" autocomplete="email" class="block flex-1 border-0 bg-transparent py-1.5 pl-3 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" required>
                            </div>
                        </div>
                    </div>

                    <div class="sm:col-span-4">
                        <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                        <div class="mt-2">
                            <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-600 sm:max-w-md">
                                <input type="password" name="password" id="password" autocomplete="new-password" class="block flex-1 border-0 bg-transparent py-1.5 pl-3 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" required>
                            </div>
                        </div>
                    </div>

                    <div class="sm:col-span-4">
                        <label for="image_url" class="block text-sm font-medium leading-6 text-gray-900">Image URL</label>
                        <div class="mt-2">
                            <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-600 sm:max-w-md">
                                <input type="text" name="image_url" id="image_url" class="block flex-1 border-0 bg-transparent py-1.5 pl-3 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-6 flex items-center justify-end gap-x-6">
            <button type="button" class="text-sm font-semibold leading-6 text-gray-900">Cancel</button>
            <button type="submit" class="rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">Save</button>
        </div>
    </form>

    <script>
        const toast = document.getElementById('toast');

        gsap.fromTo(toast, {
            autoAlpha: 0,
            y: -50
        }, {
            autoAlpha: 1,
            y: 0,
            duration: 0.5,
            ease: "power2.out",
            onComplete: () => {
                setTimeout(() => {
                    gsap.to(toast, {
                        autoAlpha: 0,
                        y: -50,
                        duration: 0.5,
                        ease: "power2.in"
                    });
                }, 3000);
            }
        });
    </script>
</body>

</html>