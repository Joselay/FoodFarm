<!DOCTYPE html>
<html lang="en">

<head>
  <title>Shopping Cart - FoodFarm</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
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

.container h2 {
    font-size: 2em;
    margin-top: 0.5em;
    margin-bottom: 0.5em;
}

.table thead th {
    background-color: #28a745;
    color: white;
}

.product-info {
    display: flex;
    align-items: center;
}

.product-info img {
    width: 50px;
    height: 50px;
    margin-right: 10px;
}

.quantity-input {
    width: 60px;
}

footer {
    background-color: #343a40;
    color: white;
    padding: 1em 0;
}

button.btn-success {
    background-color: #28a745;
    border: none;
}

button.btn-success:hover {
    background-color: #218838;
}

button.btn-danger {
    background-color: #dc3545;
    border: none;
}

button.btn-danger:hover {
    background-color: #c82333;
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
    <div class="container mt-5">
        <h2>Shopping Cart</h2>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Product</th>
                        <th scope="col">Price</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Total</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="product-info">
                                <img src="images/carrot.jpg" class="img-fluid object-fit-contain" alt="Product Image">
                                <span>Product Name</span>
                            </div>
                        </td>
                        <td>$10.00</td>
                        <td>
                            <input type="number" value="1" class="form-control quantity-input">
                        </td>
                        <td>$10.00</td>
                        <td>
                            <button class="btn btn-danger btn-sm">Remove</button>
                        </td>
                    </tr>
                    <!-- Repeat for more products -->
                </tbody>
            </table>
        </div>
        <div class="row mt-5">
            <div class="col-md-6">
                <h4>Cart Total</h4>
                <table class="table">
                    <tbody>
                        <tr>
                            <td>Subtotal</td>
                            <td>$10.00</td>
                        </tr>
                        <tr>
                            <td>Tax</td>
                            <td>$1.00</td>
                        </tr>
                        <tr>
                            <td>Total</td>
                            <td>$11.00</td>
                        </tr>
                    </tbody>
                </table>
                <button class="btn btn-success btn-lg">Proceed to Checkout</button>
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