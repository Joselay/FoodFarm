<?php
// Start the session (if you are using sessions to store order information)
session_start();

// You can retrieve order information from the session or database if necessary
// For example, if you stored the transaction details in session variables:
$transactionId = isset($_SESSION['transaction_id']) ? $_SESSION['transaction_id'] : 'N/A';
$amount = isset($_SESSION['amount']) ? $_SESSION['amount'] : 'N/A';
$items = isset($_SESSION['items']) ? $_SESSION['items'] : 'N/A';

// Optionally, clear session variables after displaying
// unset($_SESSION['transaction_id']);
// unset($_SESSION['amount']);
// unset($_SESSION['items']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Success</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            color: #343a40;
        }

        .container {
            margin-top: 100px;
        }
    </style>
</head>

<body>
    <div class="container text-center">
        <h1 class="display-4">Thank You for Your Purchase!</h1>
        <p class="lead">Your transaction has been completed successfully.</p>
        <p>Transaction ID: <strong><?php echo htmlspecialchars($transactionId); ?></strong></p>
        <p>Amount: <strong><?php echo htmlspecialchars($amount); ?></strong></p>
        <p>Items Purchased: <strong><?php echo htmlspecialchars($items); ?></strong></p>
        <a href="index.php" class="btn btn-primary mt-4">Return to Homepage</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>