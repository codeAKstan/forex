<?php
// Fetch all transactions
$query = "SELECT t.*, u.name AS username FROM transactions t JOIN users u ON t.user_id = u.id";
$stmt = $conn->prepare($query);
$stmt->execute();
$transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Transactions</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <h1>Admin Panel - Manage Transactions</h1>
    <table>
        <tr>
            <th>Transaction ID</th>
            <th>User</th>
            <th>Amount</th>
            <th>Status</th>
            <th>Type</th>
            <th>Proof of Payment</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($transactions as $transaction): ?>
        <tr>
            <td><?= $transaction['id'] ?></td>
            <td><?= $transaction['username'] ?></td>
            <td>$<?= number_format($transaction['amount'], 2) ?></td>
            <td><?= $transaction['status'] ?></td>
            <td><?= $transaction['type'] ?></td>
            <td>
                <?php if ($transaction['proof_of_payment']): ?>
                    <a href="<?= $transaction['proof_of_payment'] ?>" target="_blank">View</a>
                <?php else: ?>
                    N/A
                <?php endif; ?>
            </td>
            <td>
                <a href="admin_edit.php?id=<?= $transaction['id'] ?>">Edit</a> | 
                <a href="admin_delete.php?id=<?= $transaction['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
