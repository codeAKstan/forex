<?php
include "db_conn.php";

// Get all portfolios with a positive balance
$query = "SELECT id, balance, profit FROM portfolio WHERE balance > 0";
$stmt = $conn->prepare($query);
$stmt->execute();
$portfolios = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Loop through each portfolio and update the profit and balance
foreach ($portfolios as $portfolio) {
    $portfolioId = $portfolio['id'];
    $balance = (float)$portfolio['balance'];
    
    // Calculate 1% profit
    $profit = $balance * 0.01;

    // Add the profit to the balance and the profit column
    $newBalance = $balance + $profit;
    $newProfit = $portfolio['profit'] + $profit;

    // Update the portfolio with the new balance and profit
    $updateQuery = "UPDATE portfolio SET balance = ?, profit = ? WHERE id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->execute([$newBalance, $newProfit, $portfolioId]);
}

echo "Profit and balance updated successfully.";
?>
