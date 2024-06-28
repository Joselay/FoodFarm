<!DOCTYPE html>
<html lang="en">

<head>
  <title>FoodFarm - Grocery</title>
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

</head>

<body>

  <?php require("./src/components/svg.php") ?>
  <?php require("./src/components/header.php") ?>
  <!-- Header -->
  <header class="bg-success text-white text-center py-4">
        <h1>About FoodFarm</h1>
        <p>Fuel Your Body, Feed Your Soul with Organic Goodness</p>
    </header>

    <!-- Main Content -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <h2>Our Mission</h2>
                <p>At FoodFarm, our mission is to provide fresh, organic, and sustainably sourced products to our customers. We believe in the importance of healthy eating and strive to offer a wide variety of products that cater to all dietary needs.</p>
            </div>
            <div class="col-md-6">
                <img src="images/fresh.jpg" class="img-fluid w-100 object-fit-fill" alt="Fresh Produce">
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-6 order-md-2">
                <h2>Our Story</h2>
                <p>Founded in [Year], FoodFarm started as a small family-owned business with a passion for organic farming. Over the years, we have grown into a trusted name in the organic food industry, committed to delivering quality products and exceptional customer service.</p>
            </div>
            <div class="col-md-6 order-md-1">
                <img src="images/farm.jpg" class="img-fluid w-100 object-fit-fill" alt="Our Farm">
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-6">
                <h2>Our Team</h2>
                <p>Our team is comprised of dedicated individuals who are passionate about organic food and sustainable practices. From our farmers to our customer service representatives, everyone at FoodFarm plays a crucial role in our success.</p>
            </div>
            <div class="col-md-6">
                <img src="images/team.jpg" class="img-fluid w-100 object-fit-fill" alt="Our Team">
            </div>
        </div>
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