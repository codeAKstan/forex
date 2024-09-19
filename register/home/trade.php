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
            <h1>List of Prominent Traders</h1>
            <div class="box">
                <h3>Copy a Trader</h3><br>
                <hr><br>
                <p class="note">NOTE: <a href="#">Please click to Copy a Trader of your Choice.</a></p>
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
</body>

</html>