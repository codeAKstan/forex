<?php
session_start();
include "../db_conn.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ensure the user is authenticated
    if (!isset($_SESSION['user_id'])) {
        echo "You must be logged in to make a deposit.";
        exit();
    }

    // Validate deposit amount and uploaded file
    if (isset($_FILES['upload']) && isset($_POST['deposit'])) {
        $uploadDir = '../../admin/uploads/';
        
        // Ensure the upload directory exists and is writable
        if (!is_dir($uploadDir)) {
            echo "Upload directory does not exist.";
            exit();
        }

        if (!is_writable($uploadDir)) {
            echo "Upload directory is not writable.";
            exit();
        }

        // Secure the uploaded file path
        $uploadFile = $uploadDir . basename($_FILES['upload']['name']);
        $depositAmount = (float)$_POST['deposit'];

        // Check deposit amount is valid
        if ($depositAmount <= 0) {
            echo "Invalid deposit amount.";
            exit();
        }

        // Validate file type (allow only images and PDFs)
        $allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
        if (!in_array($_FILES['upload']['type'], $allowedTypes)) {
            echo "Invalid file type. Only JPG, PNG, and PDF are allowed.";
            exit();
        }

        // Check for file upload errors
        if ($_FILES['upload']['error'] !== UPLOAD_ERR_OK) {
            echo "File upload error: " . $_FILES['upload']['error'];
            exit();
        }

        // Check if file size is too large (limit to 2MB)
        if ($_FILES['upload']['size'] > 2000000) {
            echo "File size exceeds 2MB limit.";
            exit();
        }

        // Move uploaded file to the target directory
        if (move_uploaded_file($_FILES['upload']['tmp_name'], $uploadFile)) {
            $userId = $_SESSION['user_id'];

            // Insert deposit transaction with proof of payment
            $query = "INSERT INTO transactions (user_id, type, amount, status, proof_of_payment) 
                      VALUES (?, 'deposit', ?, 'pending', ?)";
            $stmt = $conn->prepare($query);

            // Error handling for database query
            if ($stmt->execute([$userId, $depositAmount, $uploadFile])) {
                header("Location: s.php");
            } else {
                echo "Database error. Please try again.";
            }
        } else {
            echo "File upload failed. Please check file permissions.";
        }
    } else {
        echo "Please upload a file and enter the deposit amount.";
    }
}
?>


