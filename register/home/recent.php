<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../x2/access/en.php");
    exit;
}

include "../db_conn.php";

// Fetch the user's recent transactions
$query = "SELECT * FROM transactions WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($query);
$stmt->execute([$_SESSION['user_id']]);
$transactions = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recent Activities</title>

    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="shortcut icon" href="../image/chainlink.png" type="image/x-icon">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #4a4a4a;
            margin-bottom: 20px;
        }

        .transaction {
            display: flex;
            justify-content: space-between;
            background-color: #f9f9f9;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .transaction p {
            margin: 0;
            color: #333;
        }

        .transaction .type {
            font-weight: bold;
        }

        .status.pending {
            color: orange;
        }

        .status.completed {
            color: green;
        }

        .status.failed {
            color: red;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
        }

        .footer a {
            color: #6a1b9a;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Recent Activities</h2>

        <?php if (count($transactions) > 0): ?>
            <?php foreach ($transactions as $transaction): ?>
                <div class="transaction">
                    <p class="type"><?= ucfirst($transaction['type']) ?> of $<?= number_format($transaction['amount'], 2) ?></p>
                    <p class="status <?= $transaction['status'] ?>"><?= ucfirst($transaction['status']) ?></p>
                    <p><?= date("d M Y, h:i A", strtotime($transaction['created_at'])) ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No recent activities to show.</p>
        <?php endif; ?>

        <div class="footer">
            <a href="../dashboard.php">Back to Dashboard</a>
        </div>
    </div>
</body>

</html>
