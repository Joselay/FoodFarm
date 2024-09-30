<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: ./signin.php");
  exit();
}


$userName = $_SESSION['user_username'];
$userEmail = $_SESSION['user_email'];
$imageUrl = $_SESSION['user_image_url'];

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

require_once '../config/database.php';
require_once "../utils/dd.php";

$sql = "SELECT * FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

$_SESSION['product_id'] = $product['id'];


if (!$product) {
  die("Product not found.");
}

$stmt->close();
$conn->close();
?>
<?php if (isset($_SESSION['toast_message'])): ?>
  <div id="toast" class="z-[100] w-[22rem] fixed top-0 left-[40%] mt-4">
    <div class="flex w-full max-w-sm py-5 px-6 bg-white rounded-xl border border-gray-200 shadow-sm mb-4 gap-4" role="alert">
      <div class="inline-flex space-x-3">
        <span class="bg-green-50 w-9 h-9 rounded-full flex-shrink-0 flex justify-center items-center">
          <svg class="w-5 h-5 text-green-600" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M5 10L8 13L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
        </span>
        <div class="flex flex-col">
          <span class="font-semibold text-green-600">Success!</span>
          <span class="text-sm text-gray-500"><?= $_SESSION['toast_message']; ?></span>
        </div>
      </div>
    </div>
  </div>
  <?php unset($_SESSION['toast_message']);
  ?>
<?php endif; ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $product ? $product['name'] : 'Product Not Found'; ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link rel="icon" href="../public/images/apple.svg" type="image/icon type">

  <link
    href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
    rel="stylesheet" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
  <script src="https://checkout.payway.com.kh/plugins/checkout2-0.js"></script>
  <script defer src="../public/js/script.js"></script>
</head>
<style>
  html {
    scroll-behavior: smooth;
  }
</style>

<body style="font-family: 'Inter';" class="h-screen w-screen grid place-items-center">
  <?php require "../components/header.php"; ?>

  <div class="bg-white">
    <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:grid lg:max-w-7xl lg:grid-cols-2 lg:gap-x-8 lg:px-8">
      <div class="lg:max-w-lg lg:self-end">
        <div class="mt-4">
          <h1 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
            <?php echo $product ? $product['name'] : 'Product Not Found'; ?>
          </h1>
        </div>

        <section aria-labelledby="information-heading" class="mt-4">
          <h2 id="information-heading" class="sr-only">Product information</h2>

          <div class="flex items-center">
            <p class="text-lg text-gray-900 sm:text-xl">
              $<?php echo $product ? $product['price'] : '0.00'; ?>
            </p>

            <div class="ml-4 border-l border-gray-300 pl-4">
              <h2 class="sr-only">Stocks</h2>
              <div class="flex items-center">
                <div>
                  <div class="flex items-center">
                    <!-- Active: "text-yellow-400", Default: "text-gray-300" -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                      <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                    </svg>

                  </div>
                </div>
                <p class="ml-2 text-sm text-gray-500">
                  <?php echo $product ? $product['stock_quantity'] : '0.00'; ?>
                  stocks</p>
              </div>
            </div>
          </div>

          <div class="mt-4 space-y-6">

            <p class="text-base text-gray-500">
              <?php echo $product ? $product['description'] : ''; ?>
            </p>
          </div>

          <?php if ($product['stock_quantity'] > 0): ?>
            <div class="flex items-center mt-6">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 stroke-green-500">
                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
              </svg>
              <p class="ml-2 text-sm text-gray-500">In stock and ready to ship</p>
            </div>
          <?php else: ?>
            <div class="flex items-center mt-6">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 stroke-red-500">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
              </svg>

              <p class="ml-2 text-sm text-gray-500">Out of stock</p>
            </div>
          <?php endif; ?>
        </section>
      </div>

      <div class="mt-10 lg:col-start-2 lg:row-span-2 lg:mt-0 lg:self-center">
        <div class="aspect-h-1 aspect-w-1 overflow-hidden rounded-lg">
          <img src="<?php echo $product ? $product['image_url'] : ''; ?>" alt="Model wearing light green backpack with black canvas straps and front zipper pouch." class="h-full w-full object-cover object-center">
        </div>
      </div>

      <div class="mt-10 lg:col-start-1 lg:row-start-2 lg:max-w-lg lg:self-start">
        <section aria-labelledby="options-heading">
          <h2 id="options-heading" class="sr-only">Product options</h2>

          <?php
          require_once 'PayWayApiCheckout.php';

          $item = [
            [
              'name' => $userName,
              'quantity' => '1',
              'price' => $product['price']
            ]
          ];

          $req_time = date('YmdHis', time());
          $merchant_id = "ec438425";
          $tran_id = time();
          // $firstName = 'Smae';
          $username = $userName;
          $email = $userEmail;
          $phone = '093596326';
          $amount = $product['price'];
          $type = "purchase";
          // $payment_option = "wechat";
          $items = base64_encode(json_encode($item));
          $currency = "USD";
          $return_param = "500 Character notes included here will be returned on pushback notification after transaction is successful.";
          $continue_success_url = "http://localhost/foodfarm/views/success.php";


          // "return_deeplink":,
          // "custom_fields":"{"Purcahse order ref":"Po-MX9901", "Customfield2":"value for custom field"}",


          ?>

          <form method="POST" target="aba_webservice" action="<?php echo PayWayApiCheckout::getApiUrl(); ?>" id="aba_merchant_request">
            <input type="hidden" name="req_time" value="<?php echo $req_time; ?>" />
            <input type="hidden" name="merchant_id" value="<?php echo $merchant_id; ?>" />
            <input type="hidden" name="tran_id" value="<?php echo $tran_id; ?>" />
            <!-- <input type="hidden" name="firstname" value="<?php echo $firstName; ?>" /> -->
            <input type="hidden" name="lastname" value="<?php echo $username; ?>" />
            <input type="hidden" name="email" value="<?php echo $email; ?>" />
            <input type="hidden" name="phone" value="<?php echo $phone; ?>" />
            <input type="hidden" name="amount" value="<?php echo $amount; ?>" />
            <input type="hidden" name="type" value="<?php echo $type; ?>" />
            <input type="hidden" name="continue_success_url" value="<?php echo $continue_success_url; ?>" />
            <!-- <input type="hidden" name="payment_option" value="<?php echo $payment_option; ?>" /> -->
            <input type="hidden" name="currency" value="<?php echo $currency; ?>" />
            <input type="hidden" name="items" value="<?php echo $items; ?>" />
            <input type="hidden" name="return_params" value="<?php echo $return_param; ?>" />
            <input type="hidden" name="hash" value="<?php echo PayWayApiCheckout::getHash($req_time . ABA_PAYWAY_MERCHANT_ID . $tran_id . $amount . $items  . $username . $email . $phone . $type . $continue_success_url  . $currency . $return_param); ?>" />

            <?php if ($product['stock_quantity'] > 0): ?>
              <div class="mt-10">

                <button type="submit" name="add_to_cart" class="flex w-full items-center justify-center rounded-md border border-transparent bg-green-600 px-8 py-3 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 focus:ring-offset-gray-50" id="checkout_button">
                  Purchase
                </button>
              </div>
            <?php else: ?>
              <div class="mt-10">
                <button disabled type="submit" class="flex w-full items-center justify-center rounded-md border border-transparent bg-gray-400 px-8 py-3 text-base font-medium cursor-not-allowed text-white focus:outline-none">
                  Purchase
                </button>
              </div>
            <?php endif; ?>
          </form>
      </div>
    </div>
  </div>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      document
        .getElementById("checkout_button")
        .addEventListener("click", function() {
          AbaPayway.checkout();
        });
    });
  </script>

</body>

</html>