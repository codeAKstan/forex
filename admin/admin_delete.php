<?php
session_start();
include "../register/db_conn.php";

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit();
}

// Get transaction ID and delete
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM transactions WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$id]);

    echo "Transaction deleted successfully.";
    header("Location: admin.php");
    exit();
} else {
    echo "Invalid request.";
}
?>
