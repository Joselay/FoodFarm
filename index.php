<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>FoodFarm | Explore organic fruits</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link rel="icon" href="./public/images/apple.svg" type="image/icon type">

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
  require_once "./components/hero.php";
  require_once "./components/list-product.php";
  require_once "./components/footer.php";
  ?>
</body>

</html>