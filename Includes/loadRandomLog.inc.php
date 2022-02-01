<?php

    require 'dbh.inc.php';
    session_start();

    for ($i=0; $i < 150; $i++) {
        $symbolArr = ['AAPL', 'MSFT', 'BTC', 'ETH', 'AMZN', 'JNJ', 'JPM', 'MMM', 'ABBV', 'DIS'];
        $symbol = $symbolArr[array_rand($symbolArr)];

        $qty = rand(2, 5);
        $entryPrice = rand(50, 200);
        $entryAmt = $qty * $entryPrice;
        $status = 'Open';

        $today = time();
        $threeMonthsAgo = $today - 7889229;
        $halfYearAgo = $today - 15778458;
    
        $entryDateUnix = rand($halfYearAgo, $threeMonthsAgo);  // random date between 1 year ago to 6 months ago from today
        $entryDate = date("Y-m-d", $entryDateUnix);

        $tradeOpenOdds = rand(0, 6);

        if ($tradeOpenOdds <= 5) {
            $status = 'Closed';
            $exitPrice = rand(55, 210);

            $exitDateUnix = rand($threeMonthsAgo, $today); // random date between 6 months ago to today
            $exitDate = date("Y-m-d", $exitDateUnix);
            $exitAmt = $qty * $exitPrice;

            $netReturn = ($exitPrice * $qty) - ($entryPrice * $qty);
            $roi = ($netReturn / $entryAmt) * 100;
        } 
        else {
            $exitPrice = NULL;
            $exitDate = NULL;
            $exitAmt = NULL;
            $netReturn = NULL;
            $roi = NULL;
        }

        $stmt = $conn->prepare('INSERT INTO trades (uid, status, symbol, quantity, entry_price, entry_amount, exit_price, exit_amount, entry_date, exit_date, net_return, net_roi) VALUES(?,?,?,?,?,?,?,?,?,?,?,?) ');
        $stmt->bind_param('isssssssssss', $_SESSION['uid'], $status, $symbol, $qty, $entryPrice, $entryAmt, $exitPrice, $exitAmt, $entryDate, $exitDate, $netReturn, $roi);
        $stmt->execute();
        $stmt->close();

        $_SESSION['demo'] = 1;

    }

    