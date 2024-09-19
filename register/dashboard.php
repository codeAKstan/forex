<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../x2/access/en.php");
    exit;
}

// Fetch the current user's portfolio and crypto market data
include "db_conn.php";

// Example query to get user's balance (from a "portfolio" table or similar)
$query = "SELECT balance FROM portfolio WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->execute([$_SESSION['user_id']]);
$balance = $stmt->fetchColumn();  // Fetch user's balance

// Fetch cryptocurrency data (e.g., from an external API or local database)
$cryptos = [
    ["name" => "Bitcoin", "price" => 57927.49, "change" => -2.84],
    ["name" => "Dogecoin", "price" => 0.099104, "change" => -4.62],
    ["name" => "Ethereum", "price" => 2287.45, "change" => -2.62]
];


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="styles.css">
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="shortcut icon" href="image/chainlink.png" type="image/x-icon">
	<script src="https://kit.fontawesome.com/c1fbfe0463.js" crossorigin="anonymous"></script>
    <style>
      @media (max-width: 768px) {
    .container {
        flex-direction: column;
    }

    .sidebar {
        width: 100%;
        visibility: hidden;
        height: 0;
    }

    .main-content {
        padding: 10px;
    }

    .balance-info h2 {
        font-size: 2em;
    }

    .crypto-cards {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
    }

    .crypto-card {
        width: 100%;
    }

    .balance-actions button {
        width: 100%;
        font-size: 1em;
        padding: 10px;
    }

    .market-table th, .market-table td {
        padding: 5px;
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
                <a href="dashboard.php">
					<i class='bx bxs-dashboard' ></i>
					<span class="text">Home</span>
				</a>
                </li>
                <li> <a href="home/trade.php">
					<i class='bx bxs-copy' ></i>
					<span class="text">Copy Trade</span>
				</a></li>
                <li> <a href="home/deposit.php">
					<i class='bx bxs-bank' ></i>
					<span class="text">Asset</span>
				</a></li>
                <li> <a href="home/profile.php">
					<i class='bx bxs-user' ></i>
					<span class="text">Account</span>
				</a></li>
                <li> <a href="home/recent.php">
					<i class='bx bxs-news' ></i>
					<span class="text">Recent Activities</span>
				</a></li>
            </ul>
        </nav>
        <div class="main-content">
            <h2>Portfolio</h2>
            <header class="header">
                <p>Welcome Back, <strong>
                        <?= $_SESSION['user_name'] ?>
                    </strong></p>
            </header>
            <section class="balance-section">
                <div class="balance-info">
                    <p>Current Balance</p>
                    <h2>US$
                        <?= number_format($balance, 2) ?>
                    </h2>
                    <div class="balance-actions">
                        <button onclick='window.location.href="home/deposit.php"'>Deposit</button>
                        <button onclick='window.location.href="home/portfolio.php"'>Portfolio</button>
                    </div>
                </div>
            </section>
            <section class="crypto-section">
    <div class="crypto-cards" id="cryptoCards">
        <!-- Dummy Cards for Placeholder -->
        <div class="crypto-card">
            <img src="image/1.png" alt="Bitcoin logo">
            <h3>Bitcoin</h3>
            <p>$57,000.00</p>
            <p class="change green">+0.00%</p>
        </div>
        <div class="crypto-card">
            <img src="image/3.png" alt="Ethereum logo">
            <h3>Ethereum</h3>
            <p>$2,000.00</p>
            <p class="change green">+0.00%</p>
        </div>
        <div class="crypto-card">
            <img src="image/2.png" alt="Dogecoin logo">
            <h3>Dogecoin</h3>
            <p>$0.10</p>
            <p class="change green">+0.00%</p>
        </div>
        <!-- Add more dummy cards if needed -->
    </div>
</section>

<section class="market-table">
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Coin</th>
                <th>Price</th>
                <th>24H</th>
                <th>MCap</th>
            </tr>
        </thead>
        <tbody id="cryptoTable">
            <!-- Dummy Data for Placeholder -->
            <tr>
                <td>1</td>
                <td>Bitcoin</td>
                <td>$57,000.00</td>
                <td class="green">+0.00%</td>
                <td>$1,000,000</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Ethereum</td>
                <td>$2,000.00</td>
                <td class="green">+0.00%</td>
                <td>$500,000</td>
            </tr>
            <tr>
                <td>3</td>
                <td>Dogecoin</td>
                <td>$0.10</td>
                <td class="green">+0.00%</td>
                <td>$100,000</td>
            </tr>
        </tbody>
    </table>
</section>
<div id="loadingIndicator" style="display: none;">
    <p>Loading data...</p>
</div>
<section class="top-stories-section">
    <h2>Top Stories</h2>
    <div id="topStories">
        <div class="grid-0GkkYHKF"><a href="https://www.tradingview.com/symbols/TVC-DJI/history-timeline/#dji-dow-jones-closes-at-all-time-record-above-41600-big-fed-event-in-sight-2024-09-17" target="_blank" class="card-YNF0OWRe cardWithImage-YNF0OWRe"><article class="card-exterior-Us1ZHpvJ article-YNF0OWRe"><div class="container-YNF0OWRe"><div class="header-YNF0OWRe"><relative-time locale="en" event-time="Tue, 17 Sep 2024 07:20:51 GMT" class="apply-common-tooltip" title="Sep 17, 2024, 08:20 GMT+1"></relative-time></div><div class="preview-gDIex6UB ratio16by9-gDIex6UB previewWrapper-S9oMlbeu preview-YNF0OWRe"><picture class="picture-gDIex6UB"><source srcset="https://s3.tradingview.com/timeline/dji_122347348.jpg" type="images/jpg"><img alt="Illustration by TradingView" src="https://s3.tradingview.com/timeline/dji_122347348.jpg" role="presentation" loading="lazy" class="image-gDIex6UB"></picture></div><div class="apply-overflow-tooltip apply-overflow-tooltip--direction_both title-YNF0OWRe" data-overflow-tooltip-text="DJI: Dow Jones Closes at All-Time Record Above 41,600. Big Fed Event in Sight.">DJI: Dow Jones Closes at All-Time Record Above 41,600. Big Fed Event in Sight.</div></div></article></a><a href="https://www.tradingview.com/symbols/GBPUSD/history-timeline/#gbpusd-sterling-zeros-in-on-2024-high-amid-broad-dollar-weakness-2024-09-17" target="_blank" class="card-YNF0OWRe cardWithImage-YNF0OWRe"><article class="card-exterior-Us1ZHpvJ article-YNF0OWRe"><div class="container-YNF0OWRe"><div class="header-YNF0OWRe"><img class="tv-circle-logo-PsAlMQQF tv-circle-logo--xxxsmall-PsAlMQQF" crossorigin="" src="https://s3-symbol-logo.tradingview.com/country/GB.svg" alt=""><relative-time locale="en" event-time="Tue, 17 Sep 2024 06:41:00 GMT" class="apply-common-tooltip" title="Sep 17, 2024, 07:41 GMT+1"></relative-time></div><div class="preview-gDIex6UB ratio16by9-gDIex6UB previewWrapper-S9oMlbeu preview-YNF0OWRe"><picture class="picture-gDIex6UB"><source srcset="https://s3.tradingview.com/timeline/usd_122347408.jpg" type="images/jpg"><img alt="Illustration by TradingView" src="https://s3.tradingview.com/timeline/usd_122347408.jpg" role="presentation" loading="lazy" class="image-gDIex6UB"></picture></div><div class="apply-overflow-tooltip apply-overflow-tooltip--direction_both title-YNF0OWRe" data-overflow-tooltip-text="GBP/USD: Sterling Zeros In on 2024 High Amid Broad Dollar Weakness">GBP/USD: Sterling Zeros In on 2024 High Amid Broad Dollar Weakness</div></div></article></a><a href="https://www.tradingview.com/symbols/NASDAQ-AAPL/history-timeline/#aapl-apple-stock-falls-almost-3-after-report-flags-waning-iphone-16-demand-from-china-2024-09-17" target="_blank" class="card-YNF0OWRe cardWithImage-YNF0OWRe"><article class="card-exterior-Us1ZHpvJ article-YNF0OWRe"><div class="container-YNF0OWRe"><div class="header-YNF0OWRe"><img class="tv-circle-logo-PsAlMQQF tv-circle-logo--xxxsmall-PsAlMQQF" crossorigin="" src="https://s3-symbol-logo.tradingview.com/apple.svg" alt=""><relative-time locale="en" event-time="Tue, 17 Sep 2024 06:33:51 GMT" class="apply-common-tooltip" title="Sep 17, 2024, 07:33 GMT+1"></relative-time></div><div class="preview-gDIex6UB ratio16by9-gDIex6UB previewWrapper-S9oMlbeu preview-YNF0OWRe"><picture class="picture-gDIex6UB"><source srcset="https://s3.tradingview.com/timeline/aapl_122347257.jpg" type="images/jpg"><img alt="Illustration by TradingView" src="https://s3.tradingview.com/timeline/aapl_122347257.jpg" role="presentation" loading="lazy" class="image-gDIex6UB"></picture></div><div class="apply-overflow-tooltip apply-overflow-tooltip--direction_both title-YNF0OWRe" data-overflow-tooltip-text="AAPL: Apple Stock Falls Almost 3% After Report Flags Waning iPhone 16 Demand from China">AAPL: Apple Stock Falls Almost 3% After Report Flags Waning iPhone 16 Demand from China</div></div></article></a><a href="https://www.tradingview.com/symbols/BTCUSD/history-timeline/#btcusd-bitcoin-slides-under-60000-with-a-lot-at-stake-in-this-weeks-fed-decision-2024-09-16" target="_blank" class="card-YNF0OWRe cardWithImage-YNF0OWRe"><article class="card-exterior-Us1ZHpvJ article-YNF0OWRe"><div class="container-YNF0OWRe"><div class="header-YNF0OWRe"><img class="tv-circle-logo-PsAlMQQF tv-circle-logo--xxxsmall-PsAlMQQF" crossorigin="" src="https://s3-symbol-logo.tradingview.com/crypto/XTVCBTC.svg" alt=""><relative-time locale="en" event-time="Mon, 16 Sep 2024 06:18:31 GMT" class="apply-common-tooltip" title="Sep 16, 2024, 07:18 GMT+1"></relative-time></div><div class="preview-gDIex6UB ratio16by9-gDIex6UB previewWrapper-S9oMlbeu preview-YNF0OWRe"><picture class="picture-gDIex6UB"><source srcset="https://s3.tradingview.com/timeline/usd_-2_122259082.jpg" type="images/jpg"><img alt="Illustration by TradingView" src="https://s3.tradingview.com/timeline/usd_-2_122259082.jpg" role="presentation" loading="lazy" class="image-gDIex6UB"></picture></div><div class="apply-overflow-tooltip apply-overflow-tooltip--direction_both title-YNF0OWRe" data-overflow-tooltip-text="BTC/USD: Bitcoin Slides Under $60,000 with a Lot at Stake in This Week’s Fed Decision">BTC/USD: Bitcoin Slides Under $60,000 with a Lot at Stake in This Week’s Fed Decision</div></div></article></a><a href="https://www.tradingview.com/symbols/USDJPY/history-timeline/#usdjpy-dollar-breaks-through-key-double-bottom-as-traders-ramp-up-short-bets-2024-09-16" target="_blank" class="card-YNF0OWRe cardWithImage-YNF0OWRe"><article class="card-exterior-Us1ZHpvJ article-YNF0OWRe"><div class="container-YNF0OWRe"><div class="header-YNF0OWRe"><img class="tv-circle-logo-PsAlMQQF tv-circle-logo--xxxsmall-PsAlMQQF" crossorigin="" src="https://s3-symbol-logo.tradingview.com/country/US.svg" alt=""><relative-time locale="en" event-time="Mon, 16 Sep 2024 06:14:52 GMT" class="apply-common-tooltip" title="Sep 16, 2024, 07:14 GMT+1"></relative-time></div><div class="preview-gDIex6UB ratio16by9-gDIex6UB previewWrapper-S9oMlbeu preview-YNF0OWRe"><picture class="picture-gDIex6UB"><source srcset="https://s3.tradingview.com/timeline/jpy_122259112.jpg" type="images/jpg"><img alt="Illustration by TradingView" src="https://s3.tradingview.com/timeline/jpy_122259112.jpg" role="presentation" loading="lazy" class="image-gDIex6UB"></picture></div><div class="apply-overflow-tooltip apply-overflow-tooltip--direction_both title-YNF0OWRe" data-overflow-tooltip-text="USD/JPY: Dollar Breaks Through Key Double Bottom as Traders Ramp Up Short Bets">USD/JPY: Dollar Breaks Through Key Double Bottom as Traders Ramp Up Short Bets</div></div></article></a><a href="https://www.tradingview.com/symbols/XAUUSD/history-timeline/#xauusd-gold-surges-to-fresh-record-at-2590-all-eyes-on-feds-rate-decision-2024-09-16" target="_blank" class="card-YNF0OWRe cardWithImage-YNF0OWRe"><article class="card-exterior-Us1ZHpvJ article-YNF0OWRe"><div class="container-YNF0OWRe"><div class="header-YNF0OWRe"><img class="tv-circle-logo-PsAlMQQF tv-circle-logo--xxxsmall-PsAlMQQF" crossorigin="" src="https://s3-symbol-logo.tradingview.com/metal/gold.svg" alt=""><relative-time locale="en" event-time="Mon, 16 Sep 2024 06:14:15 GMT" class="apply-common-tooltip" title="Sep 16, 2024, 07:14 GMT+1"></relative-time></div><div class="preview-gDIex6UB ratio16by9-gDIex6UB previewWrapper-S9oMlbeu preview-YNF0OWRe"><picture class="picture-gDIex6UB"><source srcset="https://s3.tradingview.com/timeline/usd_-3_122259128.jpg" type="images/jpg"><img alt="Illustration by TradingView" src="https://s3.tradingview.com/timeline/usd_-3_122259128.jpg" role="presentation" loading="lazy" class="image-gDIex6UB"></picture></div><div class="apply-overflow-tooltip apply-overflow-tooltip--direction_both title-YNF0OWRe" data-overflow-tooltip-text="XAU/USD: Gold Surges to Fresh Record at $2,590. All Eyes on Fed’s Rate Decision.">XAU/USD: Gold Surges to Fresh Record at $2,590. All Eyes on Fed’s Rate Decision.</div></div></article></a><a href="https://www.tradingview.com/symbols/XAUUSD/history-timeline/#xauusd-gold-blasts-off-to-new-record-above-2570-as-feds-rate-cut-draws-near-2024-09-13" target="_blank" class="card-YNF0OWRe cardWithImage-YNF0OWRe"><article class="card-exterior-Us1ZHpvJ article-YNF0OWRe"><div class="container-YNF0OWRe"><div class="header-YNF0OWRe"><img class="tv-circle-logo-PsAlMQQF tv-circle-logo--xxxsmall-PsAlMQQF" crossorigin="" src="https://s3-symbol-logo.tradingview.com/metal/gold.svg" alt=""><relative-time locale="en" event-time="Fri, 13 Sep 2024 12:19:59 GMT" class="apply-common-tooltip" title="Sep 13, 2024, 13:19 GMT+1"></relative-time></div><div class="preview-gDIex6UB ratio16by9-gDIex6UB previewWrapper-S9oMlbeu preview-YNF0OWRe"><picture class="picture-gDIex6UB"><source srcset="https://s3.tradingview.com/timeline/usd_-1_122007076.jpg" type="images/jpg"><img alt="Illustration by TradingView" src="https://s3.tradingview.com/timeline/usd_-1_122007076.jpg" role="presentation" loading="lazy" class="image-gDIex6UB"></picture></div><div class="apply-overflow-tooltip apply-overflow-tooltip--direction_both title-YNF0OWRe" data-overflow-tooltip-text="XAU/USD: Gold Blasts Off to New Record Above $2,570 as Fed’s Rate Cut Draws Near">XAU/USD: Gold Blasts Off to New Record Above $2,570 as Fed’s Rate Cut Draws Near</div></div></article></a><a href="https://www.tradingview.com/symbols/EURUSD/history-timeline/#eurusd-euro-eyes-111-after-ecb-cuts-rates-to-35-us-dollar-retreats-broadly-2024-09-13" target="_blank" class="card-YNF0OWRe cardWithImage-YNF0OWRe"><article class="card-exterior-Us1ZHpvJ article-YNF0OWRe"><div class="container-YNF0OWRe"><div class="header-YNF0OWRe"><img class="tv-circle-logo-PsAlMQQF tv-circle-logo--xxxsmall-PsAlMQQF" crossorigin="" src="https://s3-symbol-logo.tradingview.com/country/EU.svg" alt=""><relative-time locale="en" event-time="Fri, 13 Sep 2024 19:07:47 GMT" class="apply-common-tooltip" title="Sep 13, 2024, 20:07 GMT+1"></relative-time></div><div class="preview-gDIex6UB ratio16by9-gDIex6UB previewWrapper-S9oMlbeu preview-YNF0OWRe"><picture class="picture-gDIex6UB"><source srcset="https://s3.tradingview.com/timeline/usd_122007015.jpg" type="images/jpg"><img alt="Illustration by TradingView" src="https://s3.tradingview.com/timeline/usd_122007015.jpg" role="presentation" loading="lazy" class="image-gDIex6UB"></picture></div><div class="apply-overflow-tooltip apply-overflow-tooltip--direction_both title-YNF0OWRe" data-overflow-tooltip-text="EUR/USD: Euro Eyes $1.11 After ECB Cuts Rates to 3.5%, US Dollar Retreats Broadly">EUR/USD: Euro Eyes $1.11 After ECB Cuts Rates to 3.5%, US Dollar Retreats Broadly</div></div></article></a><a href="https://www.tradingview.com/symbols/SPX/history-timeline/#spx-sp-500-gains-08-as-hotter-producer-inflation-fails-to-dampen-risk-appetite-2024-09-13" target="_blank" class="card-YNF0OWRe cardWithImage-YNF0OWRe"><article class="card-exterior-Us1ZHpvJ article-YNF0OWRe"><div class="container-YNF0OWRe"><div class="header-YNF0OWRe"><img class="tv-circle-logo-PsAlMQQF tv-circle-logo--xxxsmall-PsAlMQQF" crossorigin="" src="https://s3-symbol-logo.tradingview.com/indices/s-and-p-500.svg" alt=""><relative-time locale="en" event-time="Fri, 13 Sep 2024 08:56:43 GMT" class="apply-common-tooltip" title="Sep 13, 2024, 09:56 GMT+1"></relative-time></div><div class="preview-gDIex6UB ratio16by9-gDIex6UB previewWrapper-S9oMlbeu preview-YNF0OWRe"><picture class="picture-gDIex6UB"><source srcset="https://s3.tradingview.com/timeline/spx_122006980.jpg" type="images/jpg"><img alt="Illustration by TradingView" src="https://s3.tradingview.com/timeline/spx_122006980.jpg" role="presentation" loading="lazy" class="image-gDIex6UB"></picture></div><div class="apply-overflow-tooltip apply-overflow-tooltip--direction_both title-YNF0OWRe" data-overflow-tooltip-text="SPX: S&amp;P 500 Gains 0.8% as Hotter Producer Inflation Fails to Dampen Risk Appetite">SPX: S&amp;P 500 Gains 0.8% as Hotter Producer Inflation Fails to Dampen Risk Appetite</div></div></article></a><a href="https://www.tradingview.com/symbols/NASDAQ-ADBE/history-timeline/#adbe-adobe-stock-falls-92-as-weak-guidance-outweighs-earnings-and-revenue-beat-2024-09-13" target="_blank" class="card-YNF0OWRe cardWithImage-YNF0OWRe"><article class="card-exterior-Us1ZHpvJ article-YNF0OWRe"><div class="container-YNF0OWRe"><div class="header-YNF0OWRe"><img class="tv-circle-logo-PsAlMQQF tv-circle-logo--xxxsmall-PsAlMQQF" crossorigin="" src="https://s3-symbol-logo.tradingview.com/adobe.svg" alt=""><relative-time locale="en" event-time="Fri, 13 Sep 2024 08:21:24 GMT" class="apply-common-tooltip" title="Sep 13, 2024, 09:21 GMT+1"></relative-time></div><div class="preview-gDIex6UB ratio16by9-gDIex6UB previewWrapper-S9oMlbeu preview-YNF0OWRe"><picture class="picture-gDIex6UB"><source srcset="https://s3.tradingview.com/timeline/adbe_122006937.jpg" type="images/jpg"><img alt="Illustration by TradingView" src="https://s3.tradingview.com/timeline/adbe_122006937.jpg" role="presentation" loading="lazy" class="image-gDIex6UB"></picture></div><div class="apply-overflow-tooltip apply-overflow-tooltip--direction_both title-YNF0OWRe" data-overflow-tooltip-text="ADBE: Adobe Stock Falls 9.2% as Weak Guidance Outweighs Earnings and Revenue Beat">ADBE: Adobe Stock Falls 9.2% as Weak Guidance Outweighs Earnings and Revenue Beat</div></div></article></a><a href="https://www.tradingview.com/symbols/BTCUSD/history-timeline/#btcusd-bitcoin-jumps-5-after-inflation-data-sparks-broad-crypto-comeback-2024-09-12" target="_blank" class="card-YNF0OWRe cardWithImage-YNF0OWRe"><article class="card-exterior-Us1ZHpvJ article-YNF0OWRe"><div class="container-YNF0OWRe"><div class="header-YNF0OWRe"><img class="tv-circle-logo-PsAlMQQF tv-circle-logo--xxxsmall-PsAlMQQF" crossorigin="" src="https://s3-symbol-logo.tradingview.com/crypto/XTVCBTC.svg" alt=""><relative-time locale="en" event-time="Thu, 12 Sep 2024 09:30:58 GMT" class="apply-common-tooltip" title="Sep 12, 2024, 10:30 GMT+1"></relative-time></div><div class="preview-gDIex6UB ratio16by9-gDIex6UB previewWrapper-S9oMlbeu preview-YNF0OWRe"><picture class="picture-gDIex6UB"><source srcset="https://s3.tradingview.com/timeline/usd_-4_121918164.jpg" type="images/jpg"><img alt="Illustration by TradingView" src="https://s3.tradingview.com/timeline/usd_-4_121918164.jpg" role="presentation" loading="lazy" class="image-gDIex6UB"></picture></div><div class="apply-overflow-tooltip apply-overflow-tooltip--direction_both title-YNF0OWRe" data-overflow-tooltip-text="BTC/USD: Bitcoin Jumps 5% After Inflation Data Sparks Broad Crypto Comeback">BTC/USD: Bitcoin Jumps 5% After Inflation Data Sparks Broad Crypto Comeback</div></div></article></a><a href="https://www.tradingview.com/symbols/TVC-DXY/history-timeline/#dxy-dollar-index-eyes-102-in-upswing-as-traders-dump-hopes-of-bigger-rate-cut-2024-09-12" target="_blank" class="card-YNF0OWRe cardWithImage-YNF0OWRe"><article class="card-exterior-Us1ZHpvJ article-YNF0OWRe"><div class="container-YNF0OWRe"><div class="header-YNF0OWRe"><img class="tv-circle-logo-PsAlMQQF tv-circle-logo--xxxsmall-PsAlMQQF" crossorigin="" src="https://s3-symbol-logo.tradingview.com/indices/u-s-dollar-index.svg" alt=""><relative-time locale="en" event-time="Thu, 12 Sep 2024 08:22:01 GMT" class="apply-common-tooltip" title="Sep 12, 2024, 09:22 GMT+1"></relative-time></div><div class="preview-gDIex6UB ratio16by9-gDIex6UB previewWrapper-S9oMlbeu preview-YNF0OWRe"><picture class="picture-gDIex6UB"><source srcset="https://s3.tradingview.com/timeline/dxy_121918083.jpg" type="images/jpg"><img alt="Illustration by TradingView" src="https://s3.tradingview.com/timeline/dxy_121918083.jpg" role="presentation" loading="lazy" class="image-gDIex6UB"></picture></div><div class="apply-overflow-tooltip apply-overflow-tooltip--direction_both title-YNF0OWRe" data-overflow-tooltip-text="DXY: Dollar Index Eyes 102 in Upswing as Traders Dump Hopes of Bigger Rate Cut">DXY: Dollar Index Eyes 102 in Upswing as Traders Dump Hopes of Bigger Rate Cut</div></div></article></a><a href="https://www.tradingview.com/symbols/NASDAQ-IXIC/history-timeline/#ixic-nasdaq-composite-stages-powerful-u-turn-after-mixed-bag-of-inflation-data-2024-09-12" target="_blank" class="card-YNF0OWRe cardWithImage-YNF0OWRe"><article class="card-exterior-Us1ZHpvJ article-YNF0OWRe"><div class="container-YNF0OWRe"><div class="header-YNF0OWRe"><img class="tv-circle-logo-PsAlMQQF tv-circle-logo--xxxsmall-PsAlMQQF" crossorigin="" src="https://s3-symbol-logo.tradingview.com/indices/nasdaq-composite.svg" alt=""><relative-time locale="en" event-time="Thu, 12 Sep 2024 07:19:10 GMT" class="apply-common-tooltip" title="Sep 12, 2024, 08:19 GMT+1"></relative-time></div><div class="preview-gDIex6UB ratio16by9-gDIex6UB previewWrapper-S9oMlbeu preview-YNF0OWRe"><picture class="picture-gDIex6UB"><source srcset="https://s3.tradingview.com/timeline/ixic_-1_121918106.jpg" type="images/jpg"><img alt="Illustration by TradingView" src="https://s3.tradingview.com/timeline/ixic_-1_121918106.jpg" role="presentation" loading="lazy" class="image-gDIex6UB"></picture></div><div class="apply-overflow-tooltip apply-overflow-tooltip--direction_both title-YNF0OWRe" data-overflow-tooltip-text="IXIC: Nasdaq Composite Stages Powerful U-Turn After Mixed Bag of Inflation Data">IXIC: Nasdaq Composite Stages Powerful U-Turn After Mixed Bag of Inflation Data</div></div></article></a><a href="https://www.tradingview.com/symbols/NASDAQ-NVDA/history-timeline/#nvda-nvidia-stock-gains-8-as-recovery-in-chip-shares-continues-after-bad-week-2024-09-12" target="_blank" class="card-YNF0OWRe cardWithImage-YNF0OWRe"><article class="card-exterior-Us1ZHpvJ article-YNF0OWRe"><div class="container-YNF0OWRe"><div class="header-YNF0OWRe"><img class="tv-circle-logo-PsAlMQQF tv-circle-logo--xxxsmall-PsAlMQQF" crossorigin="" src="https://s3-symbol-logo.tradingview.com/nvidia.svg" alt=""><relative-time locale="en" event-time="Fri, 13 Sep 2024 13:12:35 GMT" class="apply-common-tooltip" title="Sep 13, 2024, 14:12 GMT+1"></relative-time></div><div class="preview-gDIex6UB ratio16by9-gDIex6UB previewWrapper-S9oMlbeu preview-YNF0OWRe"><picture class="picture-gDIex6UB"><source srcset="https://s3.tradingview.com/timeline/nvda_-1_121918130.jpg" type="images/jpg"><img alt="Illustration by TradingView" src="https://s3.tradingview.com/timeline/nvda_-1_121918130.jpg" role="presentation" loading="lazy" class="image-gDIex6UB"></picture></div><div class="apply-overflow-tooltip apply-overflow-tooltip--direction_both title-YNF0OWRe" data-overflow-tooltip-text="NVDA: Nvidia Stock Gains 8% as Recovery in Chip Shares Continues After Bad Week">NVDA: Nvidia Stock Gains 8% as Recovery in Chip Shares Continues After Bad Week</div></div></article></a><a href="https://www.tradingview.com/symbols/ECONOMICS-USCPI/history-timeline/#us-cpi-us-inflation-drops-to-25-in-august-fed-stays-on-track-for-interest-rate-cut-2024-09-11" target="_blank" class="card-YNF0OWRe cardWithImage-YNF0OWRe"><article class="card-exterior-Us1ZHpvJ article-YNF0OWRe"><div class="container-YNF0OWRe"><div class="header-YNF0OWRe"><img class="tv-circle-logo-PsAlMQQF tv-circle-logo--xxxsmall-PsAlMQQF" crossorigin="" src="https://s3-symbol-logo.tradingview.com/country/US.svg" alt=""><relative-time locale="en" event-time="Wed, 11 Sep 2024 13:07:07 GMT" class="apply-common-tooltip" title="Sep 11, 2024, 14:07 GMT+1"></relative-time></div><div class="preview-gDIex6UB ratio16by9-gDIex6UB previewWrapper-S9oMlbeu preview-YNF0OWRe"><picture class="picture-gDIex6UB"><source srcset="https://s3.tradingview.com/timeline/inf_121851156.jpg" type="images/jpg"><img alt="Illustration by TradingView" src="https://s3.tradingview.com/timeline/inf_121851156.jpg" role="presentation" loading="lazy" class="image-gDIex6UB"></picture></div><div class="apply-overflow-tooltip apply-overflow-tooltip--direction_both title-YNF0OWRe" data-overflow-tooltip-text="US CPI: US Inflation Drops to 2.5% in August. Fed Stays on Track for Interest Rate Cut.">US CPI: US Inflation Drops to 2.5% in August. Fed Stays on Track for Interest Rate Cut.</div></div></article></a><a href="https://www.tradingview.com/symbols/USDJPY/history-timeline/#usdjpy-dollar-falls-to-fresh-2024-low-against-yen-pair-nears-double-bottom-2024-09-11" target="_blank" class="card-YNF0OWRe cardWithImage-YNF0OWRe"><article class="card-exterior-Us1ZHpvJ article-YNF0OWRe"><div class="container-YNF0OWRe"><div class="header-YNF0OWRe"><img class="tv-circle-logo-PsAlMQQF tv-circle-logo--xxxsmall-PsAlMQQF" crossorigin="" src="https://s3-symbol-logo.tradingview.com/country/US.svg" alt=""><relative-time locale="en" event-time="Wed, 11 Sep 2024 07:57:31 GMT" class="apply-common-tooltip" title="Sep 11, 2024, 08:57 GMT+1"></relative-time></div><div class="preview-gDIex6UB ratio16by9-gDIex6UB previewWrapper-S9oMlbeu preview-YNF0OWRe"><picture class="picture-gDIex6UB"><source srcset="https://s3.tradingview.com/timeline/jpy_121827801.jpg" type="images/jpg"><img alt="Illustration by TradingView" src="https://s3.tradingview.com/timeline/jpy_121827801.jpg" role="presentation" loading="lazy" class="image-gDIex6UB"></picture></div><div class="apply-overflow-tooltip apply-overflow-tooltip--direction_both title-YNF0OWRe" data-overflow-tooltip-text="USD/JPY: Dollar Falls to Fresh 2024 Low Against Yen, Pair Nears Double Bottom">USD/JPY: Dollar Falls to Fresh 2024 Low Against Yen, Pair Nears Double Bottom</div></div></article></a><a href="https://www.tradingview.com/symbols/SPX/history-timeline/#spx-sp-500-gains-05-led-by-tech-updraft-august-inflation-data-looms-2024-09-11" target="_blank" class="card-YNF0OWRe cardWithImage-YNF0OWRe"><article class="card-exterior-Us1ZHpvJ article-YNF0OWRe"><div class="container-YNF0OWRe"><div class="header-YNF0OWRe"><img class="tv-circle-logo-PsAlMQQF tv-circle-logo--xxxsmall-PsAlMQQF" crossorigin="" src="https://s3-symbol-logo.tradingview.com/indices/s-and-p-500.svg" alt=""><relative-time locale="en" event-time="Wed, 11 Sep 2024 07:02:50 GMT" class="apply-common-tooltip" title="Sep 11, 2024, 08:02 GMT+1"></relative-time></div><div class="preview-gDIex6UB ratio16by9-gDIex6UB previewWrapper-S9oMlbeu preview-YNF0OWRe"><picture class="picture-gDIex6UB"><source srcset="https://s3.tradingview.com/timeline/spx_121827779.jpg" type="images/jpg"><img alt="Illustration by TradingView" src="https://s3.tradingview.com/timeline/spx_121827779.jpg" role="presentation" loading="lazy" class="image-gDIex6UB"></picture></div><div class="apply-overflow-tooltip apply-overflow-tooltip--direction_both title-YNF0OWRe" data-overflow-tooltip-text="SPX: S&amp;P 500 Gains 0.5% Led by Tech Updraft. August Inflation Data Looms.">SPX: S&amp;P 500 Gains 0.5% Led by Tech Updraft. August Inflation Data Looms.</div></div></article></a><a href="https://www.tradingview.com/symbols/NYSE-GME/history-timeline/#gme-gamestop-stock-dives-10-after-surprise-profit-but-no-growth-in-revenue-2024-09-11" target="_blank" class="card-YNF0OWRe cardWithImage-YNF0OWRe"><article class="card-exterior-Us1ZHpvJ article-YNF0OWRe"><div class="container-YNF0OWRe"><div class="header-YNF0OWRe"><img class="tv-circle-logo-PsAlMQQF tv-circle-logo--xxxsmall-PsAlMQQF" crossorigin="" src="https://s3-symbol-logo.tradingview.com/gamestop.svg" alt=""><relative-time locale="en" event-time="Wed, 11 Sep 2024 06:42:28 GMT" class="apply-common-tooltip" title="Sep 11, 2024, 07:42 GMT+1"></relative-time></div><div class="preview-gDIex6UB ratio16by9-gDIex6UB previewWrapper-S9oMlbeu preview-YNF0OWRe"><picture class="picture-gDIex6UB"><source srcset="https://s3.tradingview.com/timeline/gme_121827764.jpg" type="images/jpg"><img alt="Illustration by TradingView" src="https://s3.tradingview.com/timeline/gme_121827764.jpg" role="presentation" loading="lazy" class="image-gDIex6UB"></picture></div><div class="apply-overflow-tooltip apply-overflow-tooltip--direction_both title-YNF0OWRe" data-overflow-tooltip-text="GME: GameStop Stock Dives 10% After Surprise Profit but No Growth in Revenue">GME: GameStop Stock Dives 10% After Surprise Profit but No Growth in Revenue</div></div></article></a><a href="https://www.tradingview.com/symbols/EURUSD/history-timeline/#eurusd-euro-loses-111-threshold-early-on-ahead-of-jampacked-week-of-events-2024-09-10" target="_blank" class="card-YNF0OWRe cardWithImage-YNF0OWRe"><article class="card-exterior-Us1ZHpvJ article-YNF0OWRe"><div class="container-YNF0OWRe"><div class="header-YNF0OWRe"><img class="tv-circle-logo-PsAlMQQF tv-circle-logo--xxxsmall-PsAlMQQF" crossorigin="" src="https://s3-symbol-logo.tradingview.com/country/EU.svg" alt=""><relative-time locale="en" event-time="Tue, 10 Sep 2024 07:55:10 GMT" class="apply-common-tooltip" title="Sep 10, 2024, 08:55 GMT+1"></relative-time></div><div class="preview-gDIex6UB ratio16by9-gDIex6UB previewWrapper-S9oMlbeu preview-YNF0OWRe"><picture class="picture-gDIex6UB"><source srcset="https://s3.tradingview.com/timeline/usd_-3_121741794.jpg" type="images/jpg"><img alt="Illustration by TradingView" src="https://s3.tradingview.com/timeline/usd_-3_121741794.jpg" role="presentation" loading="lazy" class="image-gDIex6UB"></picture></div><div class="apply-overflow-tooltip apply-overflow-tooltip--direction_both title-YNF0OWRe" data-overflow-tooltip-text="EUR/USD: Euro Loses $1.11 Threshold Early On Ahead of Jampacked Week of Events">EUR/USD: Euro Loses $1.11 Threshold Early On Ahead of Jampacked Week of Events</div></div></article></a><a href="https://www.tradingview.com/symbols/ETHUSD/history-timeline/#ethusd-ether-briefly-regains-2400-in-third-winning-day-eth-etf-shed-5-million-2024-09-10" target="_blank" class="card-YNF0OWRe cardWithImage-YNF0OWRe"><article class="card-exterior-Us1ZHpvJ article-YNF0OWRe"><div class="container-YNF0OWRe"><div class="header-YNF0OWRe"><img class="tv-circle-logo-PsAlMQQF tv-circle-logo--xxxsmall-PsAlMQQF" crossorigin="" src="https://s3-symbol-logo.tradingview.com/crypto/XTVCETH.svg" alt=""><relative-time locale="en" event-time="Tue, 10 Sep 2024 07:44:42 GMT" class="apply-common-tooltip" title="Sep 10, 2024, 08:44 GMT+1"></relative-time></div><div class="preview-gDIex6UB ratio16by9-gDIex6UB previewWrapper-S9oMlbeu preview-YNF0OWRe"><picture class="picture-gDIex6UB"><source srcset="https://s3.tradingview.com/timeline/usd_121741766.jpg" type="images/jpg"><img alt="Illustration by TradingView" src="https://s3.tradingview.com/timeline/usd_121741766.jpg" role="presentation" loading="lazy" class="image-gDIex6UB"></picture></div><div class="apply-overflow-tooltip apply-overflow-tooltip--direction_both title-YNF0OWRe" data-overflow-tooltip-text="ETH/USD: Ether Briefly Regains $2,400 in Third Winning Day, ETH ETF Shed $5 Million">ETH/USD: Ether Briefly Regains $2,400 in Third Winning Day, ETH ETF Shed $5 Million</div></div></article></a><a href="https://www.tradingview.com/symbols/XAUUSD/history-timeline/#xauusd-gold-hugs-2500-mark-as-traders-gird-up-for-key-us-inflation-data-2024-09-10" target="_blank" class="card-YNF0OWRe cardWithImage-YNF0OWRe"><article class="card-exterior-Us1ZHpvJ article-YNF0OWRe"><div class="container-YNF0OWRe"><div class="header-YNF0OWRe"><img class="tv-circle-logo-PsAlMQQF tv-circle-logo--xxxsmall-PsAlMQQF" crossorigin="" src="https://s3-symbol-logo.tradingview.com/metal/gold.svg" alt=""><relative-time locale="en" event-time="Tue, 10 Sep 2024 07:33:15 GMT" class="apply-common-tooltip" title="Sep 10, 2024, 08:33 GMT+1"></relative-time></div><div class="preview-gDIex6UB ratio16by9-gDIex6UB previewWrapper-S9oMlbeu preview-YNF0OWRe"><picture class="picture-gDIex6UB"><source srcset="https://s3.tradingview.com/timeline/usd_-2_121741744.jpg" type="images/jpg"><img alt="Illustration by TradingView" src="https://s3.tradingview.com/timeline/usd_-2_121741744.jpg" role="presentation" loading="lazy" class="image-gDIex6UB"></picture></div><div class="apply-overflow-tooltip apply-overflow-tooltip--direction_both title-YNF0OWRe" data-overflow-tooltip-text="XAU/USD: Gold Hugs $2,500 Mark as Traders Gird Up for Key US Inflation Data">XAU/USD: Gold Hugs $2,500 Mark as Traders Gird Up for Key US Inflation Data</div></div></article></a><a href="https://www.tradingview.com/symbols/NASDAQ-NVDA/history-timeline/#nvda-nvidia-stock-rises-35-after-brutal-week-wipes-out-406-billion-from-market-cap-2024-09-10" target="_blank" class="card-YNF0OWRe cardWithImage-YNF0OWRe"><article class="card-exterior-Us1ZHpvJ article-YNF0OWRe"><div class="container-YNF0OWRe"><div class="header-YNF0OWRe"><img class="tv-circle-logo-PsAlMQQF tv-circle-logo--xxxsmall-PsAlMQQF" crossorigin="" src="https://s3-symbol-logo.tradingview.com/nvidia.svg" alt=""><relative-time locale="en" event-time="Tue, 10 Sep 2024 07:27:22 GMT" class="apply-common-tooltip" title="Sep 10, 2024, 08:27 GMT+1"></relative-time></div><div class="preview-gDIex6UB ratio16by9-gDIex6UB previewWrapper-S9oMlbeu preview-YNF0OWRe"><picture class="picture-gDIex6UB"><source srcset="https://s3.tradingview.com/timeline/nvda_121741826.jpg" type="images/jpg"><img alt="Illustration by TradingView" src="https://s3.tradingview.com/timeline/nvda_121741826.jpg" role="presentation" loading="lazy" class="image-gDIex6UB"></picture></div><div class="apply-overflow-tooltip apply-overflow-tooltip--direction_both title-YNF0OWRe" data-overflow-tooltip-text="NVDA: Nvidia Stock Rises 3.5% After Brutal Week Wipes Out $406 Billion from Market Cap">NVDA: Nvidia Stock Rises 3.5% After Brutal Week Wipes Out $406 Billion from Market Cap</div></div></article></a><a href="https://www.tradingview.com/symbols/GBPUSD/history-timeline/#gbpusd-sterling-reverses-gains-in-1-drop-as-dollar-stages-sharp-jobs-fueled-rally-2024-09-09" target="_blank" class="card-YNF0OWRe cardWithImage-YNF0OWRe"><article class="card-exterior-Us1ZHpvJ article-YNF0OWRe"><div class="container-YNF0OWRe"><div class="header-YNF0OWRe"><img class="tv-circle-logo-PsAlMQQF tv-circle-logo--xxxsmall-PsAlMQQF" crossorigin="" src="https://s3-symbol-logo.tradingview.com/country/GB.svg" alt=""><time datetime="Mon, 09 Sep 2024 09:08:45 GMT" class="apply-common-tooltip" title="Sep 9, 2024, 10:08 GMT+1">Sep 9</time></div><div class="preview-gDIex6UB ratio16by9-gDIex6UB previewWrapper-S9oMlbeu preview-YNF0OWRe"><picture class="picture-gDIex6UB"><source srcset="https://s3.tradingview.com/timeline/usd_-1_121660395.jpg" type="images/jpg"><img alt="Illustration by TradingView" src="https://s3.tradingview.com/timeline/usd_-1_121660395.jpg" role="presentation" loading="lazy" class="image-gDIex6UB"></picture></div><div class="apply-overflow-tooltip apply-overflow-tooltip--direction_both title-YNF0OWRe" data-overflow-tooltip-text="GBP/USD: Sterling Reverses Gains in 1% Drop as Dollar Stages Sharp Jobs-Fueled Rally">GBP/USD: Sterling Reverses Gains in 1% Drop as Dollar Stages Sharp Jobs-Fueled Rally</div></div></article></a><a href="https://www.tradingview.com/symbols/BTCUSD/history-timeline/#btcusd-bitcoin-slips-to-1-month-low-after-august-jobs-number-rattles-crypto-market-2024-09-09" target="_blank" class="card-YNF0OWRe cardWithImage-YNF0OWRe"><article class="card-exterior-Us1ZHpvJ article-YNF0OWRe"><div class="container-YNF0OWRe"><div class="header-YNF0OWRe"><img class="tv-circle-logo-PsAlMQQF tv-circle-logo--xxxsmall-PsAlMQQF" crossorigin="" src="https://s3-symbol-logo.tradingview.com/crypto/XTVCBTC.svg" alt=""><time datetime="Mon, 09 Sep 2024 08:09:28 GMT" class="apply-common-tooltip" title="Sep 9, 2024, 09:09 GMT+1">Sep 9</time></div><div class="preview-gDIex6UB ratio16by9-gDIex6UB previewWrapper-S9oMlbeu preview-YNF0OWRe"><picture class="picture-gDIex6UB"><source srcset="https://s3.tradingview.com/timeline/usd_121660359.jpg" type="images/jpg"><img alt="Illustration by TradingView" src="https://s3.tradingview.com/timeline/usd_121660359.jpg" role="presentation" loading="lazy" class="image-gDIex6UB"></picture></div><div class="apply-overflow-tooltip apply-overflow-tooltip--direction_both title-YNF0OWRe" data-overflow-tooltip-text="BTC/USD: Bitcoin Slips to 1-Month Low After August Jobs Number Rattles Crypto Market">BTC/USD: Bitcoin Slips to 1-Month Low After August Jobs Number Rattles Crypto Market</div></div></article></a><a href="https://www.tradingview.com/symbols/NASDAQ-IXIC/history-timeline/#ixic-nasdaq-futures-rise-after-tech-index-logs-worst-first-week-of-september-since-2001-2024-09-09" target="_blank" class="card-YNF0OWRe cardWithImage-YNF0OWRe"><article class="card-exterior-Us1ZHpvJ article-YNF0OWRe"><div class="container-YNF0OWRe"><div class="header-YNF0OWRe"><img class="tv-circle-logo-PsAlMQQF tv-circle-logo--xxxsmall-PsAlMQQF" crossorigin="" src="https://s3-symbol-logo.tradingview.com/indices/nasdaq-composite.svg" alt=""><time datetime="Mon, 09 Sep 2024 08:04:13 GMT" class="apply-common-tooltip" title="Sep 9, 2024, 09:04 GMT+1">Sep 9</time></div><div class="preview-gDIex6UB ratio16by9-gDIex6UB previewWrapper-S9oMlbeu preview-YNF0OWRe"><picture class="picture-gDIex6UB"><source srcset="https://s3.tradingview.com/timeline/ixic_121660322.jpg" type="images/jpg"><img alt="Illustration by TradingView" src="https://s3.tradingview.com/timeline/ixic_121660322.jpg" role="presentation" loading="lazy" class="image-gDIex6UB"></picture></div><div class="apply-overflow-tooltip apply-overflow-tooltip--direction_both title-YNF0OWRe" data-overflow-tooltip-text="IXIC: Nasdaq Futures Rise After Tech Index Logs Worst First Week of September Since 2001">IXIC: Nasdaq Futures Rise After Tech Index Logs Worst First Week of September Since 2001</div></div></article></a><a href="https://www.tradingview.com/symbols/NYSE-DELL/history-timeline/#dell-dell-stock-to-open-higher-as-pc-maker-readies-to-join-elite-sp-500-club-2024-09-09" target="_blank" class="card-YNF0OWRe cardWithImage-YNF0OWRe"><article class="card-exterior-Us1ZHpvJ article-YNF0OWRe"><div class="container-YNF0OWRe"><div class="header-YNF0OWRe"><img class="tv-circle-logo-PsAlMQQF tv-circle-logo--xxxsmall-PsAlMQQF" crossorigin="" src="https://s3-symbol-logo.tradingview.com/dell.svg" alt=""><time datetime="Mon, 09 Sep 2024 08:00:55 GMT" class="apply-common-tooltip" title="Sep 9, 2024, 09:00 GMT+1">Sep 9</time></div><div class="preview-gDIex6UB ratio16by9-gDIex6UB previewWrapper-S9oMlbeu preview-YNF0OWRe"><picture class="picture-gDIex6UB"><source srcset="https://s3.tradingview.com/timeline/dell_121660434.jpg" type="images/jpg"><img alt="Illustration by TradingView" src="https://s3.tradingview.com/timeline/dell_121660434.jpg" role="presentation" loading="lazy" class="image-gDIex6UB"></picture></div><div class="apply-overflow-tooltip apply-overflow-tooltip--direction_both title-YNF0OWRe" data-overflow-tooltip-text="DELL: Dell Stock to Open Higher as PC Maker Readies to Join Elite S&amp;P 500 Club">DELL: Dell Stock to Open Higher as PC Maker Readies to Join Elite S&amp;P 500 Club</div></div></article></a><a href="https://www.tradingview.com/symbols/ECONOMICS-USNFP/history-timeline/#us-nfp-us-economy-slows-to-142000-new-jobs-in-august-fanning-recession-worries-2024-09-06" target="_blank" class="card-YNF0OWRe cardWithImage-YNF0OWRe"><article class="card-exterior-Us1ZHpvJ article-YNF0OWRe"><div class="container-YNF0OWRe"><div class="header-YNF0OWRe"><img class="tv-circle-logo-PsAlMQQF tv-circle-logo--xxxsmall-PsAlMQQF" crossorigin="" src="https://s3-symbol-logo.tradingview.com/country/US.svg" alt=""><time datetime="Fri, 06 Sep 2024 12:51:09 GMT" class="apply-common-tooltip" title="Sep 6, 2024, 13:51 GMT+1">Sep 6</time></div><div class="preview-gDIex6UB ratio16by9-gDIex6UB previewWrapper-S9oMlbeu preview-YNF0OWRe"><picture class="picture-gDIex6UB"><source srcset="https://s3.tradingview.com/timeline/indices-5_121420241.jpg" type="images/jpg"><img alt="Illustration by TradingView" src="https://s3.tradingview.com/timeline/indices-5_121420241.jpg" role="presentation" loading="lazy" class="image-gDIex6UB"></picture></div><div class="apply-overflow-tooltip apply-overflow-tooltip--direction_both title-YNF0OWRe" data-overflow-tooltip-text="US NFP: US Economy Slows to 142,000 New Jobs in August, Fanning Recession Worries">US NFP: US Economy Slows to 142,000 New Jobs in August, Fanning Recession Worries</div></div></article></a><a href="https://www.tradingview.com/symbols/TVC-DXY/history-timeline/#dxy-us-dollar-index-dives-under-101-as-forex-traders-brace-for-key-august-jobs-data-2024-09-06" target="_blank" class="card-YNF0OWRe cardWithImage-YNF0OWRe"><article class="card-exterior-Us1ZHpvJ article-YNF0OWRe"><div class="container-YNF0OWRe"><div class="header-YNF0OWRe"><img class="tv-circle-logo-PsAlMQQF tv-circle-logo--xxxsmall-PsAlMQQF" crossorigin="" src="https://s3-symbol-logo.tradingview.com/indices/u-s-dollar-index.svg" alt=""><time datetime="Fri, 06 Sep 2024 06:49:49 GMT" class="apply-common-tooltip" title="Sep 6, 2024, 07:49 GMT+1">Sep 6</time></div><div class="preview-gDIex6UB ratio16by9-gDIex6UB previewWrapper-S9oMlbeu preview-YNF0OWRe"><picture class="picture-gDIex6UB"><source srcset="https://s3.tradingview.com/timeline/dxy_121394121.jpg" type="images/jpg"><img alt="Illustration by TradingView" src="https://s3.tradingview.com/timeline/dxy_121394121.jpg" role="presentation" loading="lazy" class="image-gDIex6UB"></picture></div><div class="apply-overflow-tooltip apply-overflow-tooltip--direction_both title-YNF0OWRe" data-overflow-tooltip-text="DXY: US Dollar Index Dives Under 101 as Forex Traders Brace for Key August Jobs Data">DXY: US Dollar Index Dives Under 101 as Forex Traders Brace for Key August Jobs Data</div></div></article></a><a href="https://www.tradingview.com/symbols/XAUUSD/history-timeline/#xauusd-gold-adds-1-to-approach-record-as-jitters-build-up-ahead-of-jobs-report-2024-09-06" target="_blank" class="card-YNF0OWRe cardWithImage-YNF0OWRe"><article class="card-exterior-Us1ZHpvJ article-YNF0OWRe"><div class="container-YNF0OWRe"><div class="header-YNF0OWRe"><img class="tv-circle-logo-PsAlMQQF tv-circle-logo--xxxsmall-PsAlMQQF" crossorigin="" src="https://s3-symbol-logo.tradingview.com/metal/gold.svg" alt=""><time datetime="Fri, 06 Sep 2024 06:49:03 GMT" class="apply-common-tooltip" title="Sep 6, 2024, 07:49 GMT+1">Sep 6</time></div><div class="preview-gDIex6UB ratio16by9-gDIex6UB previewWrapper-S9oMlbeu preview-YNF0OWRe"><picture class="picture-gDIex6UB"><source srcset="https://s3.tradingview.com/timeline/usd_-1_121394201.jpg" type="images/jpg"><img alt="Illustration by TradingView" src="https://s3.tradingview.com/timeline/usd_-1_121394201.jpg" role="presentation" loading="lazy" class="image-gDIex6UB"></picture></div><div class="apply-overflow-tooltip apply-overflow-tooltip--direction_both title-YNF0OWRe" data-overflow-tooltip-text="XAU/USD: Gold Adds 1% to Approach Record as Jitters Build Up Ahead of Jobs Report">XAU/USD: Gold Adds 1% to Approach Record as Jitters Build Up Ahead of Jobs Report</div></div></article></a><a href="https://www.tradingview.com/symbols/SPX/history-timeline/#spx-sp-500-drifts-lower-by-03-as-private-jobs-data-jolts-stocks-before-nfp-report-2024-09-06" target="_blank" class="card-YNF0OWRe cardWithImage-YNF0OWRe"><article class="card-exterior-Us1ZHpvJ article-YNF0OWRe"><div class="container-YNF0OWRe"><div class="header-YNF0OWRe"><img class="tv-circle-logo-PsAlMQQF tv-circle-logo--xxxsmall-PsAlMQQF" crossorigin="" src="https://s3-symbol-logo.tradingview.com/indices/s-and-p-500.svg" alt=""><time datetime="Fri, 06 Sep 2024 06:33:20 GMT" class="apply-common-tooltip" title="Sep 6, 2024, 07:33 GMT+1">Sep 6</time></div><div class="preview-gDIex6UB ratio16by9-gDIex6UB previewWrapper-S9oMlbeu preview-YNF0OWRe"><picture class="picture-gDIex6UB"><source srcset="https://s3.tradingview.com/timeline/spx_121394156.jpg" type="images/jpg"><img alt="Illustration by TradingView" src="https://s3.tradingview.com/timeline/spx_121394156.jpg" role="presentation" loading="lazy" class="image-gDIex6UB"></picture></div><div class="apply-overflow-tooltip apply-overflow-tooltip--direction_both title-YNF0OWRe" data-overflow-tooltip-text="SPX: S&amp;P 500 Drifts Lower by 0.3% as Private Jobs Data Jolts Stocks Before NFP Report">SPX: S&amp;P 500 Drifts Lower by 0.3% as Private Jobs Data Jolts Stocks Before NFP Report</div></div></article></a><div class="loader-LlTtXvfG"><div><div class="spinner-PLEjRfDc" aria-label="Loading"><div class="tv-spinner tv-spinner--shown tv-spinner--size_small" role="progressbar"></div></div></div></div></div>
        <style>
    img {
        width: 50px;
        height: 50px;
    }
    a{
        text-decoration:none;
    }
</style>
    
</div>
</section>

<script>
    const coins = [
        { id: 'bitcoin', symbol: 'BTC', image: 'image/1.png' },
        { id: 'ethereum', symbol: 'ETH', image: 'image/3.png' },
        { id: 'dogecoin', symbol: 'DOGE', image: 'image/2.png' },
        { id: 'tether', symbol: 'USDT', image: 'image/money.png' },
        { id: 'solana', symbol: 'SOL', image: 'image/solana.png' },
        { id: 'usd-coin', symbol: 'USDC', image: 'image/usdc.png' },
        { id: 'chainlink', symbol: 'CHL', image: 'image/chainlink.png' },
        { id: 'wif-token', symbol: 'WIF', image: 'image/8.png' },
        { id: 'binancecoin', symbol: 'BNB', image: 'image/bnb.png' },
        // { id: 'bonk', symbol: 'BONK', image: 'image/10.png' },
        { id: 'marinade-staked-sol', symbol: 'MSOL', image: 'image/11.png' }
    ];

    async function fetchData() {
        try {
            document.getElementById('loadingIndicator').style.display = 'block';  // Show loading
            const response = await fetch('https://api.coingecko.com/api/v3/coins/markets?vs_currency=usd&ids=tether,solana,usd-coin,chainlink,dogecoin,wif-token,binancecoin,bitcoin,ethereum,marinade-staked-sol');
            const data = await response.json();

            const formattedData = data.map((coin, index) => {
                const matchedCoin = coins.find(c => c.id === coin.id);
                return {
                    id: index + 1,
                    coin: matchedCoin.symbol,
                    image: matchedCoin.image,
                    price: coin.current_price,
                    change: coin.price_change_percentage_24h,
                    marketCap: coin.market_cap,
                    color: coin.price_change_percentage_24h >= 0 ? 'green' : 'red'
                };
            });

            // Update both the cards and table with live data
            updateCryptoCards(formattedData);
            renderTable(formattedData);
            document.getElementById('loadingIndicator').style.display = 'none';  // Hide loading
        
        } catch (error) {
            console.error('Error fetching data:', error);
            document.getElementById('loadingIndicator').style.display = 'none';  // Hide loading
       
        }
    }

    function updateCryptoCards(data) {
        const cryptoCardsContainer = document.getElementById('cryptoCards');
        cryptoCardsContainer.innerHTML = ''; // Clear dummy data

        data.forEach(crypto => {
            const card = document.createElement('div');
            card.className = 'crypto-card';
            card.innerHTML = `
                <img src="${crypto.image}" alt="${crypto.coin} logo">
                <h3>${crypto.coin}</h3>
                <p>$${crypto.price.toFixed(2)}</p>
                <p class="change ${crypto.color}">${crypto.change.toFixed(2)}%</p>
            `;
            cryptoCardsContainer.appendChild(card);
        });
    }

    function renderTable(data) {
        const tableBody = document.getElementById('cryptoTable');
        tableBody.innerHTML = ''; // Clear dummy data

        data.forEach(row => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${row.id}</td>
                <td>${row.coin}</td>
                <td>${row.price.toFixed(6)}</td>
                <td class="${row.color}">${row.change.toFixed(1)}%</td>
                <td>$${row.marketCap.toLocaleString()}</td>
            `;
            tableBody.appendChild(tr);
        });
    }

    // Fetch and update data every 10 seconds
    setInterval(fetchData, 10000);

    // Fetch data on initial load
    document.addEventListener('DOMContentLoaded', fetchData);
</script>


</div>
            </section>
        </div>
    </div>
</body>

</html>