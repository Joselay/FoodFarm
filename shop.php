<!DOCTYPE html>
<html lang="en">

<head>
<title>Shop - FoodFarm</title>
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
 .breadcrumb {
    background-color: white;
}

.hero-section {
    position: relative;
    color: white;
}

.hero-section img {
    width: 100%;
    height: auto;
}

.hero-text {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
}

.hero-text h2 {
    font-size: 3em;
}

.hero-text p {
    font-size: 1.5em;
}

.categories-section {
    margin-top: 3em;
}

.category-card {
    border: 1px solid #ddd;
    padding: 1em;
    border-radius: 10px;
    transition: box-shadow 0.3s ease;
}

.category-card:hover {
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
}

.new-arrivals-section {
    margin-top: 3em;
}

.product-card {
    border: 1px solid #ddd;
    padding: 1em;
    border-radius: 10px;
    transition: box-shadow 0.3s ease;
    margin-bottom: 1em;
}

.product-card:hover {
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
}

.product-card .price {
    font-size: 1.2em;
    color: #007bff;
}
</style>
</head>

<body>

  <?php require("./src/components/svg.php") ?>
  <?php require("./src/components/header.php") ?>
  <!-- Header -->
  <header class="bg-dark text-white text-center py-4">
        <h1>FoodFarm</h1>
        <p>Fuel Your Body, Feed Your Soul with Organic Goodness</p>
    </header>

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-white">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Shop</li>
        </ol>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section text-center">
        <img src="path/to/hero-image.jpg" class="img-fluid" alt="Shop Hero Image">
        <div class="hero-text">
            <h2>Welcome to Our Shop</h2>
            <p>Discover the best organic products for your health and wellness.</p>
            <a href="#new-arrivals" class="btn btn-primary btn-lg">Shop Now</a>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="categories-section container mt-5">
        <h2 class="text-center mb-4">Shop by Category</h2>
        <div class="row">
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="category-card text-center">
                    <img src="path/to/category-image1.jpg" class="img-fluid" alt="Fruits & Vegetables">
                    <h3>Fruits & Vegetables</h3>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="category-card text-center">
                    <img src="path/to/category-image2.jpg" class="img-fluid" alt="Dairy & Eggs">
                    <h3>Dairy & Eggs</h3>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="category-card text-center">
                    <img src="path/to/category-image3.jpg" class="img-fluid" alt="Meat & Poultry">
                    <h3>Meat & Poultry</h3>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="category-card text-center">
                    <img src="path/to/category-image4.jpg" class="img-fluid" alt="Bakery">
                    <h3>Bakery</h3>
                </div>
            </div>
        </div>
    </section>

    <!-- New Arrivals Section -->
    <section id="new-arrivals" class="new-arrivals-section container mt-5">
        <h2 class="text-center mb-4">New Arrivals</h2>
        <div class="row">
            <!-- Example Product Card -->
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="product-card text-center">
                    <img src="path/to/product-image1.jpg" class="img-fluid" alt="Product Image">
                    <h3>Organic Strawberries</h3>
                    <p class="price">$8.00</p>
                    <a href="product.html" class="btn btn-primary btn-sm">View Details</a>
                    <button class="btn btn-outline-primary btn-sm">Add to Cart</button>
                </div>
            </div>
            <!-- Repeat for more products -->
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="product-card text-center">
                    <img src="path/to/product-image2.jpg" class="img-fluid" alt="Product Image">
                    <h3>Organic Avocados</h3>
                    <p class="price">$3.50</p>
                    <a href="product.html" class="btn btn-primary btn-sm">View Details</a>
                    <button class="btn btn-outline-primary btn-sm">Add to Cart</button>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="product-card text-center">
                    <img src="path/to/product-image3.jpg" class="img-fluid" alt="Product Image">
                    <h3>Organic Bell Peppers</h3>
                    <p class="price">$5.00</p>
                    <a href="product.html" class="btn btn-primary btn-sm">View Details</a>
                    <button class="btn btn-outline-primary btn-sm">Add to Cart</button>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="product-card text-center">
                    <img src="path/to/product-image4.jpg" class="img-fluid" alt="Product Image">
                    <h3>Organic Pears</h3>
                    <p class="price">$4.00</p>
                    <a href="product.html" class="btn btn-primary btn-sm">View Details</a>
                    <button class="btn btn-outline-primary btn-sm">Add to Cart</button>
                </div>
            </div>
            <!-- Add more product cards as needed -->
        </div>
    </section>

    <!-- Popular Products Section -->
    <section class="popular-products-section container mt-5">
        <h2 class="text-center mb-4">Popular Products</h2>
        <div class="row">
            <!-- Example Product Card -->
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="product-card text-center">
                    <img src="path/to/product-image5.jpg" class="img-fluid" alt="Product Image">
                    <h3>Organic Apples</h3>
                    <p class="price">$6.00</p>
                    <a href="product.html" class="btn btn-primary btn-sm">View Details</a>
                    <button class="btn btn-outline-primary btn-sm">Add to Cart</button>
                </div>
            </div>
            <!-- Repeat for more products -->
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="product-card text-center">
                    <img src="path/to/product-image6.jpg" class="img-fluid" alt="Product Image">
                    <h3>Organic Broccoli</h3>
                    <p class="price">$3.00</p>
                    <a href="product.html" class="btn btn-primary btn-sm">View Details</a>
                    <button class="btn btn-outline-primary btn-sm">Add to Cart</button>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="product-card text-center">
                    <img src="path/to/product-image7.jpg" class="img-fluid" alt="Product Image">
                    <h3>Organic Lettuce</h3>
                    <p class="price">$2.50</p>
                    <a href="product.html" class="btn btn-primary btn-sm">View Details</a>
                    <button class="btn btn-outline-primary btn-sm">Add to Cart</button>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="product-card text-center">
                    <img src="path/to/product-image8.jpg" class="img-fluid" alt="Product Image">
                    <h3>Organic Tomatoes</h3>
                    <p class="price">$4.50</p>
                    <a href="product.html" class="btn btn-primary btn-sm">View Details</a>
                    <button class="btn btn-outline-primary btn-sm">Add to Cart</button>
                </div>
            </div>
            <!-- Add more product cards as needed -->
        </div>
    </section>
  <?php require("./src/components/subscribe.php") ?>
  <?php require("./src/components/footer.php") ?>

  <script src="js/jquery-1.11.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  <script src="js/plugins.js"></script>
  <script src="js/script.js"></script>
</body>

</html>