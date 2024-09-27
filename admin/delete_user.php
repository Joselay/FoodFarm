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
    $user_id = $_GET['id'];

    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        header("Location: users.php?message=User deleted successfully");
    } else {
        header("Location: users.php?error=Error deleting user");
    }

    $stmt->close();
} else {
    header("Location: users.php?error=Invalid user ID");
}

$conn->close();
