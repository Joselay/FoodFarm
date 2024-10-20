<?php

session_start();

require "../vendor/autoload.php";
require "../config/database.php";
require "../utils/dd.php";

$sql = "SELECT * FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_GET['id']);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

$user_sql = "SELECT balance FROM users WHERE id = ?";
$user_stmt = $conn->prepare($user_sql);
$user_stmt->bind_param("i", $_SESSION['user_id']);
$user_stmt->execute();
$user_result = $user_stmt->get_result();
$user = $user_result->fetch_assoc();
$user_balance = $user['balance'];



if (!$product) {
    header("HTTP/1.0 404 Not Found");
    header("Location: /foodfarm/views/404.php");
    exit();
}

if ($user_balance < $product['price']) {
    header("Location: /foodfarm/views/cancel.php");
    exit();
}



$STRIPE_SK = "sk_test_51QBprZP1KZRnTO9mazPFAnfMErmup9nbP3AUZ5iTV83v2M5Tfj8bf0Oa17Tb3qF2EFIdjDRK53PeQFDzLbaHTm5m00bZRa4U4Y";
$STRIPE_PK = "pk_test_51QBprZP1KZRnTO9mZAkjY00woSq7sNghtFKSzUjm67SlX73mmCivFUIXM8t7SXxhLrDWATUD5Ys0ShuNRmpy8HzL00DnJcxImC";

\Stripe\Stripe::setApiKey($STRIPE_SK);

$checkout_session = \Stripe\Checkout\Session::create([
    "mode" => "payment",
    "success_url" => "http://localhost/foodfarm/views/success.php",
    "cancel_url" => "http://localhost/foodfarm/views/cancel.php",
    "line_items" => [
        [
            "quantity" => 1,
            "price_data" => [
                "currency" => "usd",
                "unit_amount" => $product['price'] * 100,
                "product_data" => [
                    "name" => $product['name'],
                ],
            ],
        ],

    ],
]);

http_response_code(303);
header("Location: " . $checkout_session->url);
