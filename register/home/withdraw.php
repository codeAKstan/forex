<?php
session_start();
include "../db_conn.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $withdrawAmount = (float)$_POST['amount'];
    $userId = $_SESSION['user_id'];

    // Check user balance
    $query = "SELECT balance FROM portfolio WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$userId]);
    $balance = $stmt->fetchColumn();

    if ($balance >= 50 && $withdrawAmount <= $balance) {
        // Insert withdrawal transaction
        $cryptoOption = $_POST['coin'];
        $walletAddress = $_POST['address'];

        $query = "INSERT INTO transactions (user_id, type, amount, status) 
                  VALUES (?, 'withdrawal', ?, 'pending')";
        $stmt = $conn->prepare($query);
        $stmt->execute([$userId, $withdrawAmount]);

        echo "Withdrawal submitted successfully. Pending approval.";
    } else {
        echo "Insufficient balance or invalid amount.";
    }
}
?>
