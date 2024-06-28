<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Name - FoodFarm</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="css/vendor.css">
  <link rel="stylesheet" type="text/css" href="style.css">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Rubik+Mono+One&display=swap" rel="stylesheet">
<style> 

.breadcrumb {
    background-color: white;
}

.container h2 {
    font-size: 2em;
    margin-top: 0.5em;
    margin-bottom: 0.5em;
}

.price {
    font-size: 1.5em;
    color: #28a745;
}


button.btn-success {
    background-color: #28a745;
    border: none;
}

button.btn-success:hover {
    background-color: #218838;
}
</style>
</head>
<body>
    <!-- Header -->
    <?php require("./src/components/svg.php") ?>
    <?php require("./src/components/header.php") ?>


    <header class="bg-success text-white text-center py-4">
        <h1>FoodFarm</h1>
        <p>Fuel Your Body, Feed Your Soul with Organic Goodness</p>
    </header>

    <!-- Main Content -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <img src="images/carrot.jpg" class="img-fluid w-100 object-fit-contain" alt="Product Image">
            </div>
            <div class="col-md-6">
                <h2>Carrot</h2>
                <p class="price">$10.00</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur lacinia enim at ex blandit, quis vehicula lectus venenatis.</p>
                <button class="btn btn-success btn-lg">Add to Cart</button>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12">
                <h3>Product Details</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam scelerisque, justo vitae accumsan viverra, ex turpis varius libero, id convallis quam magna et lorem. In scelerisque nisl at sem cursus, nec ullamcorper sem tincidunt. Vivamus tincidunt sapien nec justo cursus, in condimentum magna sagittis. Sed vitae lorem tincidunt, tempor mauris a, fermentum magna. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Donec vehicula orci sed dignissim luctus.</p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php require("./src/components/subscribe.php") ?>
    <?php require("./src/components/footer.php") ?>


    <script src="js/jquery-1.11.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  <script src="js/plugins.js"></script>
  <script src="js/script.js"></script>
</body>
</html>
