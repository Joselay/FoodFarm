<?php
session_start();;
require_once "../config/database.php";
require_once "../utils/dd.php";
require_once "../enums/Language.php";
require_once "../utils/language.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['language'])) {
    $language = $_POST['language'];
    $_SESSION['language'] = $language;
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    $imageUrl = $_POST['image_url'];

    if (empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
        $error = "All fields are required!";
    } elseif ($password !== $confirmPassword) {
        $error = "Passwords do not match!";
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user) {
            $error = "Email already exists!";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            if (empty($imageUrl)) {
                $imageUrl = 'https://static.vecteezy.com/system/resources/thumbnails/009/292/244/small/default-avatar-icon-of-social-media-user-vector.jpg';
            }

            $stmt = $conn->prepare("INSERT INTO users (username, email, password, role, image_url) VALUES (?, ?, ?, 'user', ?)");
            $stmt->bind_param("ssss", $username, $email, $hashedPassword, $imageUrl);
            $stmt->execute();

            header("Location: signin.php");
            exit();
        }

        $stmt->close();
    }
}
$language = $_SESSION['language'] ?? Language::English->value;

$languageFile = "../i18n/{$language}.php";
if (file_exists($languageFile)) {
    require_once $languageFile;
} else {
    require_once "../i18n/en-US.php";
}
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sign Up</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="relative w-screen h-screen flex justify-center items-center" style="font-family: <?= $fontFamily ?>">
    <div class="cursor-pointer group absolute right-[2rem] top-[1rem] flex justify-center items-center gap-3">
        <form method="POST" action="signup.php">
            <input type="hidden" name="language" value="<?php echo $language === Language::English->value ? Language::Khmer->value : Language::English->value; ?>">
            <button type="submit" class="flex items-center gap-2">
                <img src="../public/images/<?php echo $language === Language::Khmer->value ? 'khmer.webp' : 'english.svg'; ?>" class="w-8 h-6" alt="">
                <span class="group-hover:text-gray-500 font-medium"><?php echo ($language === Language::Khmer->value) ? "KH" : "EN"; ?></span>
            </button>
        </form>
    </div>
    <div class="flex min-h-full w-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <img class="mx-auto h-10 w-auto" src="../public/images/logo.svg" alt="Your Company">
            <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">
                <?php echo $translations['sign_up_to_your_account']; ?>
            </h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <?php if (isset($error)): ?>
                <div class="text-red-500 mb-4">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form class="space-y-6" action="signup.php" method="POST">
                <div>
                    <label for="username" class="block text-sm font-medium leading-6 text-gray-900">
                        <?php echo $translations['username']; ?>
                    </label>
                    <div class="mt-2">
                        <input id="username" name="username" type="text" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 p-2  ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-green-600 sm:text-sm sm:leading-6">
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium leading-6 text-gray-900">
                        <?php echo $translations['email_address']; ?>

                    </label>
                    <div class="mt-2">
                        <input id="email" name="email" type="email" autocomplete="email" required class="block w-full rounded-md border-0 py-1.5 p-2  text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-green-600 sm:text-sm sm:leading-6">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium leading-6 text-gray-900">
                        <?php echo $translations['password']; ?>

                    </label>
                    <div class="mt-2">
                        <input id="password" name="password" type="password" autocomplete="current-password" required class="block w-full rounded-md border-0 py-1.5 p-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-green-600 sm:text-sm sm:leading-6">
                    </div>
                </div>

                <div>
                    <label for="confirm_password" class="block text-sm font-medium leading-6 text-gray-900">
                        <?php echo $translations['confirm_password']; ?>

                    </label>
                    <div class="mt-2">
                        <input id="confirm_password" name="confirm_password" type="password" autocomplete="current-password" required class="p-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-green-600 sm:text-sm sm:leading-6">
                    </div>
                </div>

                <div>
                    <label for="image_url" class="block text-sm font-medium leading-6 text-gray-900">
                        <?php echo $translations['image_url']; ?>

                    </label>
                    <div class="mt-2">
                        <input placeholder="www.example.com" id="image_url" name="image_url" type="text" class="p-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-green-600 sm:text-sm sm:leading-6">
                    </div>
                </div>

                <div>
                    <button type="submit" class="flex w-full justify-center rounded-md bg-green-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">
                        <?php echo $translations['sign_up']; ?>

                    </button>
                </div>
            </form>

            <p class="mt-10 text-center text-sm text-gray-500">
                <?php echo $translations['already_have_account']; ?>

                <a href="./signin.php" class="font-semibold leading-6 text-green-600 hover:text-green-500">
                    <?php echo $translations['sign_in']; ?>

                </a>
            </p>
        </div>
    </div>

</body>

</html>