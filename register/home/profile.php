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
$balance = $stmt->fetchColumn();  // Fetch user's balance
$profit = $stmt->fetchColumn(); 

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prominent Traders</title>

    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="shortcut icon" href="../image/chainlink.png" type="image/x-icon">
    <script src="https://kit.fontawesome.com/c1fbfe0463.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/web3@latest/dist/web3.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@walletconnect/web3-provider@latest/dist/umd/index.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
        }

        .wrapper {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 100vh;
        }

        .sidebar {
            display: none;
            flex-direction: column;
            width: 200px;
            background-color: #fff;
            color: rgb(116, 106, 106);
            padding: 20px;
        }

        .sidebar a {
            color: #333;
            text-decoration: none;
            margin: 10px 0;
            font-size: 18px;
            display: block;
        }

        .sidebar h5 {
            margin-bottom: 50px;
            color: black;
        }



        /* Main content area */
        .container {
            flex-grow: 1;
            padding: 20px;
            text-align: center;
            margin-top: 20px;
        }

        h2 {
            color: #4a4a4a;
        }

        .dashboard {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
        }

        .profile,
        .wallet {
            width: 45%;
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 8px;
            background-color: #f9f9f9;
        }

        .profile {
            text-align: left;
        }

        .profile p {
            margin: 8px 0;
        }

        .logout-btn {
            background-color: #b71c1c;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }

        .wallet {
            text-align: left;
        }

        .wallet h3 {
            margin-bottom: 10px;
        }

        .wallet p {
            margin: 5px 0;
        }

        .withdraw-btn {
            background-color: #6a1b9a;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }

        .upload-section,
        .withdraw-section {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
            background-color: #f9f9f9;
        }

        .upload-section h3,
        .withdraw-section h3 {
            margin-bottom: 10px;
        }

        .submit-btn {
            background-color: #6a1b9a;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        input[type="file"],
        input[type="text"],
        input[type="number"],
        select {
            display: block;
            margin: 10px auto;
            padding: 10px;
            width: 80%;
            border: 1px solid #ddd;
            border-radius: 5px;
            color: black;
        }

        label {
            font-weight: bold;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .box {
            border: 1px solid #ddd;
            padding: 10px;
            background-color: #f9f9f9;
            width: 100%;
            margin: 0 auto;
        }

        h3 {
            margin-top: 0;
        }



        .footer {
            display: none;
            justify-content: space-around;
            background-color: #1c1b29;
            padding: 15px 0;
            position: relative;
            bottom: 0;
            width: 100%;
        }

        .footer-icon i {
            width: 24px;
            height: 24px;
            color: #fff;
        }

        .footer-icon {
            margin-bottom: 50px;
        }

        @media (min-width: 601px) {
            .wrapper {
                flex-direction: row;
            }

            .sidebar {
                display: flex;
            }

            .container {
                margin-left: 220px;
                text-align: left;
            }

            .footer {
                display: none;
            }
        }

        @media (max-width: 600px) {
            .box {
                width: 90%;
            }

            h1 {
                font-size: 20px;
            }

            .footer {
                display: flex;
            }

            .sidebar {
                display: none;
            }

            .dashboard {
                flex-direction: column;
                align-items: center;
            }

            .profile,
            .wallet {
                width: 100%;
                margin-bottom: 15px;
            }

            .logout-btn,
            .withdraw-btn {
                width: 100%;
                margin-top: 10px;
            }
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="sidebar">
            <h5>Forex automated system</h5>
            <a href="../dashboard.php"><i class='bx bxs-dashboard'></i> Home</a>
            <a href="trade.php"><i class='bx bxs-copy'></i> Trade</a>
            <a href="deposit.php"><i class='bx bxs-bank'></i> Asset</a>
            <a href="profile.php"><i class='bx bxs-user'></i> Profile</a>
        </div>

        <div class="container">
            <h2>Welcome Back,
                <?= $_SESSION['user_name'] ?>
            </h2><br><br>

            <div class="dashboard">
                <div class="profile">
                    <p><strong>Hello</strong></p>
                    <p><strong> <?= $_SESSION['user_name'] ?></strong></p>
                    <p><i class='bx bx-phone'></i> 24/7 Live Chat</p>
                    <p><i class='bx bx-envelope'></i> support@forexautomatedsystem.online</p>
                    <button class="logout-btn" onclick="window.location.href='logout.php'">Logout</button>
                </div>

                <div class="wallet">
                    <h3>Wallet</h3>
                    <p><strong>Investment Plan</strong>: N/A</p>
                    <p><strong>Available Balance</strong>: $
                        <?= number_format($balance, 2) ?>
                    </p>
                    <p><strong>Total Profits</strong>: $
                        <?= number_format($profit, 2) ?>
                    </p>
                    <button class="withdraw-btn"><a href="#withdraw"></a>Withdraw</button>
                </div>
            </div>

            <div class="upload-section">
            <form method="POST" action="depo.php" enctype="multipart/form-data">
    <label for="upload">Upload Receipt</label>
    <input type="file" id="upload" name="upload" accept=".jpg,.jpeg,.png,.pdf" required />
    <input type="number" id="deposit" name="deposit" placeholder="Enter Deposited Amount (USD)" required />
    <button class="submit-btn" type="submit">Submit</button>
</form>

            </div>

            <div class="withdraw-section">
            <form method="POST" action="withdraw.php">
                <h3>Wallet Withdrawal</h3>
                <i>You need a balance of at least $50 to withdraw.</i>
                <input type="text" id="amount" name="amount" placeholder="Enter Amount  (USD)" required />
                <select id="coin" required>
                    <option value="-- SELECT AN OPTION OF COIN --" selected>-- SELECT AN OPTION OF COIN --</option>
                    <option value="btc">Bitcoin</option>
                    <option value="eth">Ethereum</option>
                    <option value="ltc">Litecoin</option>
                </select>
                <input type="text" id="address" placeholder="Enter Address" required/>
                <button class="submit-btn" id="withdraw">Withdraw</button>
            </form>
            </div>
        </div>
        <?= include('recent.php') ?>

        <div class="footer">
            <div class="footer-icon">
                <a href="../dashboard.php"><i class='bx bxs-dashboard'></i></a>
            </div>
            <div class="footer-icon">
                <a href="trade.php"><i class='bx bxs-copy'></i></a>
            </div>
            <div class="footer-icon">
                <a href="deposit.php"><i class='bx bxs-bank'></i></a>
            </div>
            <div class="footer-icon">
                <a href="profile.php"><i class='bx bxs-user'></i></a>
            </div>
        </div>
    </div>
</body>

</html>