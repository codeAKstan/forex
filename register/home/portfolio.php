<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../x2/access/en.php");
    exit;
}

include "../db_conn.php";

$query = "SELECT balance, profit FROM portfolio WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->execute([$_SESSION['user_id']]);
$portfolio = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch user's portfolio data
$balance = $portfolio['balance']; // Get user's balance
$profit = $portfolio['profit'];   // Get user's profit
$deposit = $balance - $profit;    // Calculate deposit (balance - profit)

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="../styles.css">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="shortcut icon" href="../image/chainlink.png" type="image/x-icon">
    <script src="https://kit.fontawesome.com/c1fbfe0463.js" crossorigin="anonymous"></script>
    <style>
        @media (max-width: 768px) {
            .message {
                visibility: hidden;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <nav class="sidebar">
            <h5>Forex Automated system</h5>
            <ul>
                <li>
                    <a href="../dashboard.php">
                        <i class='bx bxs-dashboard'></i>
                        <span class="text">Home</span>
                    </a>
                </li>
                <li>
                    <a href="trade.php">
                        <i class='bx bxs-copy'></i>
                        <span class="text">Trade</span>
                    </a>
                </li>
                <li>
                    <a href="deposit.php">
                        <i class='bx bxs-bank'></i>
                        <span class="text">Asset</span>
                    </a>
                </li>
                <li>
                    <a href="profile.php">
                        <i class='bx bxs-user'></i>
                        <span class="text">Profile</span>
                    </a>
                </li>
            </ul>
        </nav>
        <div class="main-content">
            <header class="header">
                <h2>Portfolio</h2>
                <p class="message">Welcome Back, <strong><?= $_SESSION['user_name'] ?></strong></p>
            </header>

            <!-- Display profit as Earning Total -->
            <section class="balance-section">
                <div class="balance-info">
                    <p>Earned Total</p>
                    <h5>US$ <?= number_format($profit, 2) ?></h5>
                </div>
            </section>

            <!-- Display balance as Trading Balance -->
            <section class="balance-section">
                <div class="balance-info">
                    <p>Trading Balance</p>
                    <h5>US$ <?= number_format($balance, 2) ?></h5>
                </div>
            </section>

            <!-- Display balance - profit as Deposit -->
            <section class="balance-section">
                <div class="balance-info">
                    <p>Deposit</p>
                    <h5>US$ <?= number_format($deposit, 2) ?></h5>
                </div>
            </section>

            <!-- Display balance as Account Balance -->
            <section class="balance-section">
                <div class="balance-info">
                    <p>Account Balance</p>
                    <h5>US$ <?= number_format($balance, 2) ?></h5>
                </div>
            </section>
        </div>
    </div>
</body>
</html>
