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
    background-color: #be1e24;
    color: white;
    font-size: 18px;
    padding: 10px 20px;
    border-radius: 5px;
    text-decoration: none;
}

.deposit-button:hover {
    background-color: red;
}

    </style>
</head>
<body>
    <div class="verification-container">
        <div class="verification-box">
            <div class="verification-icon">
                <img src="../image/danger-sign.png" alt="failed Icon">
            </div>
            <h1>Failed</h1>
            <p>Insufficient balance or invalid amount</p>
            <a href="profile.php" class="deposit-button">View Profile</a>
        </div>
    </div>
</body>
</html>
