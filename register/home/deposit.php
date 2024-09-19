<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../x2/access/en.php");
    exit;
}

include "../db_conn.php";

$query = "SELECT balance FROM portfolio WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->execute([$_SESSION['user_id']]);
$balance = $stmt->fetchColumn();  // Fetch user's balance

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
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
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

        .note {
            color: green;
        }

        .note a {
            color: green;
            text-decoration: none;
            font-weight: bold;
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
        .crypto-cards {
    display: flex;
    justify-content: space-around;
    flex-wrap: wrap;
}
        .crypto-card {
    width: 200px;
    padding: 20px;
    text-align: center;
    border: 1px solid #ddd;
    margin-bottom: 20px;
    border-radius: 8px;
    box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
    color:white;
    background: black;
}

.crypto-card img {
    width: 32px;
    height: 32px;
    margin-bottom: 10px;
}

.crypto-card h3 {
    margin: 0;
    font-size: 1.2em;
}
em{
    text-align: center;
    color: grey;
}

#btcAddressContainer, #usdtAddressContainer {
            display: none;
            margin-top: 20px;
            font-size: 18px;
        }

        .btn {
            margin-top: 10px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
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
        <h1>Assets</h1>
        <em style="text-align: center">click on the asset you want to deposit</em><br>
        <em style="text-align: center">copy  the address, go to your and upload proof of payment</em>
        <div class="crypto-cards" id="cryptoCards">
            <div class="crypto-card" onclick="toggleBTCAddress()">
                <img src="../image/1.png" alt="Bitcoin logo">
                <h3>Bitcoin</h3>
            </div>
            <div class="crypto-card" onclick="toggleUSDTAddress()">
                <img src="../image/money.png" alt="USDT logo">
                <h3>USDT</h3>
            </div>
        </div>

        <!-- Bitcoin Address -->
        <div id="btcAddressContainer">
            <p>btcadd</p>
            <button class="btn" onclick="copyBTCAddress()">Copy BTC Address</button>
        </div>

        <!-- USDT Address -->
        <div id="usdtAddressContainer">
            <p>usdtadd</p>
            <button class="btn" onclick="copyUSDTAddress()">Copy USDT Address</button>
        </div>
    </div>

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
    <script>
        // Toggle Bitcoin Address visibility
        function toggleBTCAddress() {
            const btcContainer = document.getElementById('btcAddressContainer');
            const usdtContainer = document.getElementById('usdtAddressContainer');
            
            // Hide USDT if open
            usdtContainer.style.display = 'none';
            
            // Toggle Bitcoin container
            btcContainer.style.display = btcContainer.style.display === 'none' ? 'block' : 'none';
        }

        // Toggle USDT Address visibility
        function toggleUSDTAddress() {
            const usdtContainer = document.getElementById('usdtAddressContainer');
            const btcContainer = document.getElementById('btcAddressContainer');
            
            // Hide Bitcoin if open
            btcContainer.style.display = 'none';
            
            // Toggle USDT container
            usdtContainer.style.display = usdtContainer.style.display === 'none' ? 'block' : 'none';
        }

        // Copy BTC Address
        function copyBTCAddress() {
            const btcAddress = 'btcadd';  // Replace with actual BTC address
            navigator.clipboard.writeText(btcAddress).then(() => {
                swal('BTC address copied to clipboard');
            });
        }

        // Copy USDT Address
        function copyUSDTAddress() {
            const usdtAddress = 'usdtadd';  // Replace with actual USDT address
            navigator.clipboard.writeText(usdtAddress).then(() => {
                swal('USDT address copied to clipboard');
            });
        }
    </script>
</body>

</html>