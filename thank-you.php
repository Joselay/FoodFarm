<!DOCTYPE html>
<html lang="en">

<head>
<title>Thank You - FoodFarm</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="format-detection" content="telephone=no">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="author" content="TemplatesJungle">
  <meta name="keywords" content="grocery, store">
  <meta name="description" content="Grocery Store HTML Website Template">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="css/vendor.css">
  <link rel="stylesheet" type="text/css" href="style.css">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Rubik+Mono+One&display=swap" rel="stylesheet">
<style>
    .container h1.display-4 {
    font-size: 3em;
    margin-top: 1em;
}

.container p.lead {
    font-size: 1.5em;
    margin-top: 0.5em;
}

.container p {
    font-size: 1.2em;
    margin-top: 0.5em;
    margin-bottom: 1em;
}

button.btn-success {
    background-color: #28a745;
    border: none;
}

button.btn-success:hover {
    background-color: #218838;
}

button.btn-outline-success {
    border-color: #28a745;
    color: #28a745;
}

button.btn-outline-success:hover {
    background-color: #28a745;
    color: white;
}
</style>
</head>

<body>

  <?php require("./src/components/svg.php") ?>
  <?php require("./src/components/header.php") ?>
 <!-- Header -->
 <header class="bg-success text-white text-center py-4">
        <h1>FoodFarm</h1>
        <p>Fuel Your Body, Feed Your Soul with Organic Goodness</p>
    </header>

    <!-- Main Content -->
    <div class="container text-center mt-5">
        <h1 class="display-4 text-success">Thank You!</h1>
        <p class="lead">Your order has been received and is being processed.</p>
        <p>We appreciate your business and hope you enjoy your organic products.</p>
        <a href="/FoodFarm" class="btn btn-success btn-lg mt-4">Back to Home</a>
        <a href="/FoodFarm/shop.php" class="btn btn-outline-success btn-lg mt-4">Continue Shopping</a>
        <!-- <img src="path/to/thank-you-image.jpg" class="img-fluid mt-5" alt="Thank You Image"> -->
    </div>
  <?php require("./src/components/subscribe.php") ?>
  <?php require("./src/components/footer.php") ?>

  <script src="js/jquery-1.11.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  <script src="js/plugins.js"></script>
  <script src="js/script.js"></script>
</body>

</html>