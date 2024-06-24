<header>
    <div class="container-lg">
        <div class="row py-3 border-bottom">

            <div class="col-sm-6 col-md-5 col-lg-3 justify-content-center justify-content-lg-between text-center text-sm-start d-flex gap-3">
                <div class="d-flex align-items-center">
                    <a href="/foodfarm">
                        <img src="images/logo.svg" alt="logo" class="img-fluid">
                    </a>
                    <button class="navbar navbar-toggler ms-3 d-block d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
            </div>

            <div class="col-sm-12 col-md-4 col-lg-7 d-none d-md-block">
                <div class="search-bar row bg-light p-2 rounded-4">
                    <div class="col-md-3 d-none d-lg-block">
                        <select class="form-select border-0 bg-transparent">
                            <option>All Categories</option>
                            <option>Groceries</option>
                            <option>Drinks</option>
                            <option>Chocolates</option>
                        </select>
                    </div>
                    <div class="col-11 col-md-10 col-lg-8">
                        <form id="search-form" class="text-center" action="index.php" method="post">
                            <input type="text" class="form-control border-0 bg-transparent" placeholder="Search for more than 20,000 products">
                        </form>
                    </div>
                    <div class="col-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M21.71 20.29L18 16.61A9 9 0 1 0 16.61 18l3.68 3.68a1 1 0 0 0 1.42 0a1 1 0 0 0 0-1.39ZM11 18a7 7 0 1 1 7-7a7 7 0 0 1-7 7Z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3 col-lg-2 d-flex justify-content-end gap-5 align-items-center mt-4 mt-sm-0 justify-content-center justify-content-sm-end">
                <ul class="d-flex justify-content-end list-unstyled m-0">
                    <li>
                        <a href="#" class="p-2 mx-1">
                            <svg width="24" height="24">
                                <use xlink:href="#user"></use>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="p-2 mx-1">
                            <svg width="24" height="24">
                                <use xlink:href="#wishlist"></use>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="p-2 mx-1" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart" aria-controls="offcanvasCart">
                            <svg width="24" height="24">
                                <use xlink:href="#shopping-bag"></use>
                            </svg>
                        </a>
                    </li>
                    <li class="d-md-none">
                        <a href="#" class="p-2 mx-1" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSearch" aria-controls="offcanvasSearch">
                            <svg width="24" height="24">
                                <use xlink:href="#search"></use>
                            </svg>
                        </a>
                    </li>
                </ul>

            </div>

        </div>
        <nav class="p-0 navbar navbar-expand-lg border-bottom">

            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Offcanvas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">

                    <ul class="navbar-nav mb-0">
                        <li class="nav-item border-end-0 border-lg-end-0 border-lg-end active">
                            <a href="#" class="nav-link fw-bold text-uppercase px-3 py-3">Fruits & Vegetables</a>
                        </li>
                        <li class="nav-item border-end-0 border-lg-end-0 border-lg-end dropdown has-megamenu">
                            <a class="nav-link fw-bold text-uppercase px-3 py-3 dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                All Products </a>
                            <div class="dropdown-menu megamenu p-lg-5" role="menu">
                                <div class="row g-3 row-cols-1 row-cols-lg-5">
                                    <div class="col">
                                        <div class="col-megamenu">
                                            <h6 class="title">Household Items</h6>
                                            <ul class="list-unstyled">
                                                <li><a href="#" class="nav-link p-0">Eco-Friendly Cleaning Products</a></li>
                                                <li><a href="#" class="nav-link p-0">Reusable Bags</a></li>
                                                <li><a href="#" class="nav-link p-0">Biodegradable Trash Bags</a></li>
                                                <li><a href="#" class="nav-link p-0">Organic Laundry Detergent</a></li>
                                            </ul>
                                        </div> <!-- col-megamenu.// -->
                                        <div class="col-megamenu mt-4">
                                            <h6 class="title">Frozen Foods</h6>
                                            <ul class="list-unstyled">
                                                <li><a href="#" class="nav-link p-0">Frozen Berries</a></li>
                                                <li><a href="#" class="nav-link p-0">Frozen Vegetables (Peas, Corn, Mixed Veggies)</a></li>
                                                <li><a href="#" class="nav-link p-0">Organic Frozen Meals</a></li>
                                                <li><a href="#" class="nav-link p-0">Ice Cream</a></li>
                                                <li><a href="#" class="nav-link p-0">Frozen Pizza</a></li>
                                            </ul>
                                        </div> <!-- col-megamenu.// -->
                                    </div>
                                    <div class="col">
                                        <div class="col-megamenu">
                                            <h6 class="title">Dairy Products</h6>
                                            <ul class="list-unstyled">
                                                <li><a href="#" class="nav-link p-0">Organic Milk</a></li>
                                                <li><a href="#" class="nav-link p-0">Almond Milk</a></li>
                                                <li><a href="#" class="nav-link p-0">Soy Milk</a></li>
                                                <li><a href="#" class="nav-link p-0">Organic Yogurt</a></li>
                                                <li><a href="#" class="nav-link p-0">Cheese (Cheddar, Mozzarella, Goat Cheese)</a></li>
                                                <li><a href="#" class="nav-link p-0">Butter</a></li>
                                                <li><a href="#" class="nav-link p-0">Cream Cheese</a></li>
                                            </ul>
                                        </div> <!-- col-megamenu.// -->
                                        <div class="col-megamenu mt-4">
                                            <h6 class="title">Meat and Poultry</h6>
                                            <ul class="list-unstyled">
                                                <li><a href="#" class="nav-link p-0">Organic Chicken Breasts</a></li>
                                                <li><a href="#" class="nav-link p-0">Organic Ground Beef</a></li>
                                                <li><a href="#" class="nav-link p-0">Organic Pork Chops</a></li>
                                                <li><a href="#" class="nav-link p-0">Organic Turkey</a></li>
                                                <li><a href="#" class="nav-link p-0">Organic Sausages</a></li>
                                                <li><a href="#" class="nav-link p-0">Organic Bacon</a></li>
                                            </ul>
                                        </div> <!-- col-megamenu.// -->
                                    </div><!-- end col-3 -->
                                    <div class="col">
                                        <div class="col-megamenu">
                                            <h6 class="title">Seafood</h6>
                                            <ul class="list-unstyled">
                                                <li><a href="#" class="nav-link p-0">Wild-Caught Salmon</a></li>
                                                <li><a href="#" class="nav-link p-0">Shrimp</a></li>
                                                <li><a href="#" class="nav-link p-0">Tilapia</a></li>
                                                <li><a href="#" class="nav-link p-0">Tuna</a></li>
                                                <li><a href="#" class="nav-link p-0">Cod</a></li>
                                            </ul>
                                        </div> <!-- col-megamenu.// -->
                                        <div class="col-megamenu mt-4">
                                            <h6 class="title">Bakery</h6>
                                            <ul class="list-unstyled">
                                                <li><a href="#" class="nav-link p-0">Whole Grain Bread</a></li>
                                                <li><a href="#" class="nav-link p-0">Multigrain Bread</a></li>
                                                <li><a href="#" class="nav-link p-0">Sourdough Bread</a></li>
                                                <li><a href="#" class="nav-link p-0">Organic Bagels</a></li>
                                                <li><a href="#" class="nav-link p-0">Organic Cookies</a></li>
                                                <li><a href="#" class="nav-link p-0">Pantry Staples</a></li>
                                                <li><a href="#" class="nav-link p-0">Organic Pasta</a></li>
                                                <li><a href="#" class="nav-link p-0">Brown Rice</a></li>
                                                <li><a href="#" class="nav-link p-0">Quinoa</a></li>
                                                <li><a href="#" class="nav-link p-0">Oats</a></li>
                                            </ul>
                                        </div> <!-- col-megamenu.// -->
                                    </div><!-- end col-3 -->
                                    <div class="col">
                                        <div class="col-megamenu">
                                            <h6 class="title">Lentils</h6>
                                            <ul class="list-unstyled">
                                                <li><a href="#" class="nav-link p-0">Chickpeas</a></li>
                                                <li><a href="#" class="nav-link p-0">Black Beans</a></li>
                                                <li><a href="#" class="nav-link p-0">Canned Tomatoes</a></li>
                                                <li><a href="#" class="nav-link p-0">Tomato Sauce</a></li>
                                                <li><a href="#" class="nav-link p-0">Olive Oil</a></li>
                                                <li><a href="#" class="nav-link p-0">Coconut Oil</a></li>
                                                <li><a href="#" class="nav-link p-0">Apple Cider Vinegar</a></li>
                                                <li><a href="#" class="nav-link p-0">Organic Spices (Cumin, Turmeric, Paprika, etc.)</a></li>
                                            </ul>
                                        </div> <!-- col-megamenu.// -->
                                        <div class="col-megamenu mt-4">
                                            <h6 class="title">Beverages</h6>
                                            <ul class="list-unstyled">
                                                <li><a href="#" class="nav-link p-0">Organic Coffee</a></li>
                                                <li><a href="#" class="nav-link p-0">Herbal Tea</a></li>
                                                <li><a href="#" class="nav-link p-0">Green Tea</a></li>
                                                <li><a href="#" class="nav-link p-0">Coconut Water</a></li>
                                                <li><a href="#" class="nav-link p-0">Kombucha</a></li>
                                                <li><a href="#" class="nav-link p-0">Fresh Juices</a></li>
                                            </ul>
                                        </div> <!-- col-megamenu.// -->
                                    </div>
                                    <div class="col">
                                        <div class="col-megamenu">
                                            <h6 class="title">Snacks</h6>
                                            <ul class="list-unstyled">
                                                <li><a href="#" class="nav-link p-0">Organic Granola Bars</a></li>
                                                <li><a href="#" class="nav-link p-0">Dried Fruit (Apricots, Raisins, Cranberries)</a></li>
                                                <li><a href="#" class="nav-link p-0">Nuts (Almonds, Walnuts, Cashews)</a></li>
                                                <li><a href="#" class="nav-link p-0">Organic Popcorn</a></li>
                                                <li><a href="#" class="nav-link p-0">Dark Chocolate</a></li>
                                                <li><a href="#" class="nav-link p-0">Organic Chips</a></li>
                                            </ul>
                                        </div> <!-- col-megamenu.// -->
                                        <div class="col-megamenu mt-4">
                                            <h6 class="title">Personal Care</h6>
                                            <ul class="list-unstyled">
                                                <li><a href="#" class="nav-link p-0">Organic Shampoo</a></li>
                                                <li><a href="#" class="nav-link p-0">Organic Conditioner</a></li>
                                                <li><a href="#" class="nav-link p-0">Natural Soap</a></li>
                                                <li><a href="#" class="nav-link p-0">Organic Toothpaste</a></li>
                                                <li><a href="#" class="nav-link p-0">Natural Deodorant</a></li>
                                                <li><a href="#" class="nav-link p-0">Organic Skincare Products</a></li>
                                            </ul>
                                        </div> <!-- col-megamenu.// -->
                                    </div><!-- end col-3 -->
                                </div><!-- end row -->
                            </div> <!-- dropdown-mega-menu.// -->
                        </li>
                        <li class="nav-item border-end-0 border-lg-end-0 border-lg-end">
                            <a href="#sale" class="nav-link fw-bold text-uppercase px-3 py-3">Free Delivery</a>
                        </li>
                        <li class="nav-item border-end-0 border-lg-end-0 border-lg-end">
                            <a href="#blog" class="nav-link fw-bold text-uppercase px-3 py-3">Blog</a>
                        </li>
                        <li class="nav-item border-end-0 border-lg-end-0 border-lg-end">
                            <a href="#sale" class="nav-link fw-bold text-uppercase px-3 py-3">Organic</a>
                        </li>
                        <li class="nav-item border-end-0 border-lg-end-0 border-lg-end">
                            <a href="#blog" class="nav-link fw-bold text-uppercase px-3 py-3">Offers</a>
                        </li>
                        <li class="nav-item border-end-0 border-lg-end-0 border-lg-end">
                            <a href="#sale" class="nav-link fw-bold text-uppercase px-3 py-3">Sale</a>
                        </li>
                        <li class="nav-item border-end-0 border-lg-end-0 border-lg-end dropdown">
                            <a class="nav-link fw-bold text-uppercase px-3 py-3 dropdown-toggle" role="button" id="pages" data-bs-toggle="dropdown" aria-expanded="false">Pages</a>
                            <ul class="dropdown-menu px-3 px-lg-0 pb-2 border-0 rounded-0" aria-labelledby="pages">
                                <li><a href="about.php" class="dropdown-item">About Us</a></li>
                                <li><a href="shop.php" class="dropdown-item">Shop</a></li>
                                <li><a href="single-product.php" class="dropdown-item">Single Product </a></li>
                                <li><a href="cart.php" class="dropdown-item">Cart </a></li>
                                <li><a href="checkout.php" class="dropdown-item">Checkout </a></li>
                                <li><a href="blog.php" class="dropdown-item">Blog </a></li>
                                <li><a href="single-post.php" class="dropdown-item">Single Post </a></li>
                                <li><a href="styles.php" class="dropdown-item">Styles </a></li>
                                <li><a href="contact.php" class="dropdown-item">Contact </a></li>
                                <li><a href="thank-you.php" class="dropdown-item">Thank You </a></li>
                                <li><a href="account.php" class="dropdown-item">My Account </a></li>
                                <li><a href="404.php" class="dropdown-item">404 Error </a></li>
                            </ul>
                        </li>

                    </ul>

                </div>
            </div>
        </nav>
    </div>
</header>