<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Verification</title>
    <style>
        * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    background-color: #f8f8f8;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.verification-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
}

.verification-box {
    background-color: white;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    padding: 40px;
    text-align: center;
}

.verification-icon img {
    width: 60px;
    height: 60px;
}

h1 {
    font-size: 24px;
    color: #333;
    margin-top: 20px;
    margin-bottom: 10px;
}

p {
    font-size: 16px;
    color: #666;
    margin-bottom: 20px;
}

.deposit-button {
    display: inline-block;
    background-color: #f6c344;
    color: white;
    font-size: 18px;
    padding: 10px 20px;
    border-radius: 5px;
    text-decoration: none;
}

.deposit-button:hover {
    background-color: #e1ac10;
}

    </style>
</head>
<body>
    <div class="verification-container">
        <div class="verification-box">
            <div class="verification-icon">
                <img src="../image/expired.png" alt="pending Icon">
            </div>
            <h1>Pending</h1>
            <p>Withdrawal submitted successfully. Pending approval</p>
            <a href="recent.php" class="deposit-button">View History</a>
        </div>
    </div>
</body>
</html>
