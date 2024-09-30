<?php
require "../config/database.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];

    $valid_statuses = ['pending', 'shipped', 'delivered', 'cancelled'];

    if (!in_array($status, $valid_statuses)) {
        die('Invalid status value.');
    }

    $updateStatusQuery = "UPDATE orders SET status = ? WHERE id = ?";
    $updateStatusStmt = $conn->prepare($updateStatusQuery);
    $updateStatusStmt->bind_param("si", $status, $order_id);

    if ($updateStatusStmt->execute()) {
        header("Location: orders.php?status=success");

        exit();
    } else {
        echo "Error updating order status: " . $conn->error;
    }

    $updateStatusStmt->close();
} else {
    echo "Invalid request method.";
}

$conn->close();
