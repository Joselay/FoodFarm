<?php
require "../utils/dd.php";
require_once "../enums/Language.php";

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['language'])) {
  $language = $_POST['language'];
  $_SESSION['language'] = $language;
  header("Location: " . $_SERVER['PHP_SELF']);
  exit();
}

$language = $_SESSION['language'] ?? Language::English->value;

$languageFile = "../i18n/{$language}.php";
if (file_exists($languageFile)) {
  require_once $languageFile;
} else {
  require_once "../i18n/en-US.php";
}

require_once "../config/database.php";

$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['language'])) {
  $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
  $password = $_POST['password'];

  $sql = "SELECT * FROM users WHERE email = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['user_role'] = $user['role'];
      $_SESSION['user_email'] = $user['email'];
      $_SESSION['user_username'] = $user['username'];
      $_SESSION['user_image_url'] = $user['image_url'];
      $_SESSION['language'] = $language;

      header("Location: /foodfarm");
      exit();
    } else {
      $error = $translations['invalid_password'];
    }
  } else {
    $error = $translations['no_user_found'];
  }
}

$fontFamily = ($language === Language::Khmer->value) ? "'Kantumruy Pro', sans-serif" : "'Inter', sans-serif";
?>

<!DOCTYPE html>
<html lang="<?php echo $language; ?>">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php echo $translations['signin_title']; ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="./public/js/script.js" defer></script>
</head>

<style>
  html {
    scroll-behavior: smooth;
  }
</style>

<body class="relative w-screen h-screen flex justify-center items-center" style="font-family: <?php echo $fontFamily; ?>;">
  <div class="cursor-pointer group absolute right-[2rem] top-[1rem] flex justify-center items-center gap-3">
    <form method="POST" action="signin.php">
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
      <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900"><?php echo $translations['signin_heading']; ?></h2>
    </div>

    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
      <form class="space-y-6" action="signin.php" method="POST">
        <div>
          <label for="email" class="block text-sm font-medium leading-6 text-gray-900"><?php echo $translations['email_label']; ?></label>
          <div class="mt-2">
            <input id="email" name="email" type="email" autocomplete="email" required class="p-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-green-600 sm:text-sm sm:leading-6">
          </div>
        </div>

        <div>
          <div class="flex items-center justify-between">
            <label for="password" class="block text-sm font-medium leading-6 text-gray-900"><?php echo $translations['password_label']; ?></label>
            <div class="text-sm">
              <a href="#" class="font-semibold text-green-600 hover:text-green-500"><?php echo $translations['forgot_password']; ?></a>
            </div>
          </div>
          <div class="mt-2">
            <input id="password" name="password" type="password" autocomplete="current-password" required class="p-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-green-600 sm:text-sm sm:leading-6">
          </div>
        </div>

        <?php if (!empty($error)): ?>
          <p class="text-red-600"><?php echo $error; ?></p>
        <?php endif; ?>

        <div>
          <button type="submit" class="flex w-full justify-center rounded-md bg-green-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600"><?php echo $translations['signin_button']; ?></button>
        </div>
      </form>

      <p class="mt-10 text-center text-sm text-gray-500">
        <?php echo $translations['not_a_member']; ?>
        <a href="./signup.php" class="font-semibold leading-6 text-green-600 hover:text-green-500"><?php echo $translations['create_account']; ?></a>
      </p>
    </div>
  </div>
</body>

</html>