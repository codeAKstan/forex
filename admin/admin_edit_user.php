<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include "../register/db_conn.php";

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Get user ID from URL
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Fetch user details
    $query = "
        SELECT u.*, p.balance, p.profit, p.message, p.message_toggle
        FROM users u 
        LEFT JOIN portfolio p ON u.id = p.user_id 
        WHERE u.id = ?
    ";
    $stmt = $conn->prepare($query);
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "User not found.";
        exit();
    }
} else {
    echo "Invalid request.";
    exit();
}

// Update user details if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $country = $_POST['country'];
    $phone_number = $_POST['phone_number'];
    $balance = (float)$_POST['balance'];
    $profit = (float)$_POST['profit'];
    $message = $_POST['message'];
    $message_toggle = isset($_POST['message_toggle']) ? 1 : 0;

    // Update user details
    $updateUserQuery = "UPDATE users SET name = ?, email = ?, country = ?, phone_number = ? WHERE id = ?";
    $stmt = $conn->prepare($updateUserQuery);
    $stmt->execute([$name, $email, $country, $phone_number, $user_id]);

    // Update portfolio details
    $updatePortfolioQuery = "UPDATE portfolio SET balance = ?, profit = ?, message = ?, message_toggle = ? WHERE user_id = ?";
    $stmt = $conn->prepare($updatePortfolioQuery);
    $stmt->execute([$balance, $profit, $message, $message_toggle, $user_id]);

    echo "User details updated successfully.";
    header("Location: view_users.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f0f0;
        }

        form {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        label, input, textarea {
            display: block;
            width: 100%;
            margin-bottom: 10px;
        }

        input[type="text"], input[type="email"], input[type="number"], textarea {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background-color: #007bff;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            text-align: center;
        }

        button:hover {
            background-color: #0056b3;
        }

        h1 {
            text-align: center;
            font-size: 24px;
            color: #333;
        }
    </style>
</head>
<body>
    <form method="POST" action="">
        <h1>Edit User</h1>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?= $user['name'] ?>" required />

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?= $user['email'] ?>" required />

        <label for="country">Country:</label>
        <input type="text" id="country" name="country" value="<?= $user['country'] ?>" required />

        <label for="phone_number">Phone Number:</label>
        <input type="text" id="phone_number" name="phone_number" value="<?= $user['phone_number'] ?>" required />

        <label for="balance">Balance:</label>
        <input type="number" step="0.01" id="balance" name="balance" value="<?= $user['balance'] ?>" required />

        <label for="profit">Profit:</label>
        <input type="number" step="0.01" id="profit" name="profit" value="<?= $user['profit'] ?>" required />

        <label for="message">Message:</label>
        <textarea id="message" name="message"><?= $user['message'] ?></textarea>

        <label for="message_toggle">Display Message:</label>
        <input type="checkbox" id="message_toggle" name="message_toggle" <?= $user['message_toggle'] ? 'checked' : '' ?> />

        <button type="submit">Update User</button>
    </form>
</body>
</html>
