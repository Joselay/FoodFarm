<?php
require_once "../config/database.php";

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $user_id = $_GET['id'];

    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $username = $user['username'];
        $email = $user['email'];
        $role = $user['role'];
        $image_url = $user['image_url'];
    } else {
        die("User not found.");
    }
} else {
    die("Invalid user ID.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $image_url = $_POST['image_url'];

    $update_sql = "UPDATE users SET username = ?, email = ?, role = ?, image_url = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ssssi", $username, $email, $role, $image_url, $user_id);

    if ($update_stmt->execute()) {
        header("Location: users.php?message=User updated successfully");
        exit();
    } else {
        echo "Error updating user: " . $conn->error;
    }
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
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
        <nav class="flex items-center justify-between p-6 lg:px-8" aria-label="Global">
            <div class="flex lg:flex-1">
                <a href="#" class="-m-1.5 p-1.5">
                    <span class="sr-only">Your Company</span>
                    <img class="h-8 w-auto" src="../public/images/logo.svg" alt="" />
                </a>
            </div>
            <div class="hidden lg:flex lg:gap-x-12">
                <a href="./products.php" class="text-sm font-semibold leading-6 text-gray-900">Products</a>
                <a href="#" class="text-sm font-semibold leading-6 text-gray-900">Users</a>
            </div>
            <div class="hidden lg:flex lg:flex-1 lg:justify-end justify-center items-center gap-2">
                <img class="inline-block h-8 w-8 rounded-full object-cover" src="https://cdn.oneesports.gg/cdn-data/2023/04/Anime_DemonSlayer_Muzan_3-450x253.jpg" alt="">
                <span class="text-sm">Admin</span>
            </div>
        </nav>
    </header>
    <form class="grid place-items-center py-12" method="POST">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($user_id); ?>">
        <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-12">
                <h2 class="text-base font-semibold leading-7 text-gray-900">Edit User</h2>
                <p class="mt-1 text-sm leading-6 text-gray-600">Please fill out the form below to edit the user in our inventory.</p>

                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="sm:col-span-4">
                        <label for="username" class="block text-sm font-medium leading-6 text-gray-900">Username</label>
                        <div class="mt-2">
                            <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-600 sm:max-w-md">
                                <input type="text" name="username" id="username" class="block flex-1 border-0 bg-transparent py-1.5 pl-3 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" value="<?php echo htmlspecialchars($username); ?>" placeholder="Username" required>
                            </div>
                        </div>
                    </div>

                    <div class="sm:col-span-4">
                        <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email</label>
                        <div class="mt-2">
                            <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-600 sm:max-w-md">
                                <input type="email" name="email" id="email" class="block flex-1 border-0 bg-transparent py-1.5 pl-3 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" value="<?php echo htmlspecialchars($email); ?>" placeholder="Email" required>
                            </div>
                        </div>
                    </div>

                    <div class="sm:col-span-4">
                        <label for="role" class="block text-sm font-medium leading-6 text-gray-900">Role</label>
                        <div class="mt-2">
                            <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-600 sm:max-w-md">
                                <input type="text" name="role" id="role" class="block flex-1 border-0 bg-transparent py-1.5 pl-3 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" value="<?php echo htmlspecialchars($role); ?>" placeholder="Role" required>
                            </div>
                        </div>
                    </div>

                    <div class="sm:col-span-4">
                        <label for="image_url" class="block text-sm font-medium leading-6 text-gray-900">Image URL</label>
                        <div class="mt-2 flex flex-col items-center">
                            <div class="flex rounded-md self-stretch shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-600 sm:max-w-md">
                                <input type="text" name="image_url" id="image_url" class="block flex-1 border-0 bg-transparent py-1.5 pl-3 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" value="<?php echo htmlspecialchars($image_url); ?>" placeholder="http://example.com/" required>
                            </div>
                            <div class="mt-4">
                                <img id="preview" src="<?php echo htmlspecialchars($image_url); ?>" class="w-32 h-32 object-cover" alt="User Image">
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
        document.getElementById('image_url').addEventListener('input', function() {
            var imageUrl = this.value;
            document.getElementById('preview').src = imageUrl;
        });
    </script>
</body>

</html>