<?php
$servername = "localhost";
$username = "jose";
$password = "jose";
$dbname = "jose";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);

    $sql = "DELETE FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {

        header("Location: products.php?message=Product deleted successfully");

        exit();
    } else {
        echo "Error deleting product: " . $conn->error;
    }

    $stmt->close();
} else {
    echo "Invalid product ID.";
}

$conn->close();
