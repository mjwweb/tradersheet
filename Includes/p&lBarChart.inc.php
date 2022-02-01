<?php

    require 'dbh.inc.php';

    $currentDate = $date = date('Y-m-d');
    $overall = 0;

    $chartData = array();

    $stmt = $conn->prepare('SELECT MIN(date_sold), MAX(date_sold) FROM spreadsheet');
    $stmt->execute();
    $stmt->bind_result($earliestDate, $latestDate);
    $stmt->fetch();
    $stmt->close();

    $stmt = $conn->prepare('SELECT sold, bought, date_sold FROM spreadsheet WHERE date_sold BETWEEN ? AND ? ORDER BY date_sold ASC');
    $stmt->bind_param('ss', $earliestDate, $currentDate);
    $stmt->execute();
    $stmt->store_result();
    $rows = $stmt->num_rows;
    $stmt->bind_result($soldPrice, $boughtPrice, $soldDate);

    while ($stmt->fetch()) {
        $beforeFees = $soldPrice - $boughtPrice;
        $revenue = $beforeFees - ($soldPrice * .05);
        $revenue = round($revenue);

        $overall += $revenue;

        if (array_key_exists($soldDate, $chartData)) {
            $chartData[$soldDate] += $revenue;
        } 
        else {
            $chartData[$soldDate] = $revenue;
        }

    }

    $stmt->close();

    echo json_encode($chartData);