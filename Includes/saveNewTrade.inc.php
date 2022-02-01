<?php

    session_start();

    if (isset($_SESSION['uid']) && isset($_SESSION['account_id'])) {
        require 'dbh.inc.php';

        $symbol = $_POST['symbol'];
        $side = $_POST['side'];
        $entryDate = $_POST['entryDate'];
        $entryPrice = $_POST['entryPrice'];
        $qty = $_POST['qty'];
        $entryAmt = $entryPrice * $qty;
        $fees = $_POST['fees'];

        if (empty($fees)) {
            $fees = 0;
        }

        $exitDate = $_POST['exitDate'];
        $exitPrice = $_POST['exitPrice'];

        // set default open values
        $status = 'Open';
        $exitAmt = NULL;
        $netReturn = NULL;
        $roi = NULL;

        // close trade and calculate returns if closed

        if (!empty($exitDate) && !empty($exitPrice)) {
            $status = 'Closed';
            $exitAmt = $exitPrice * $qty;

            if ($side == 'Long') {
                $netReturn = ($exitAmt - $entryAmt) - $fees;
                $netReturn = number_format((float)$netReturn, 2, '.', '');
            }
            else {
                $netReturn = ($entryAmt - $exitAmt) - $fees;
                $netReturn = number_format((float)$netReturn, 2, '.', '');
            }

            $roi = ($netReturn / $entryAmt) * 100;
            $roi = number_format((float)$roi, 2, '.', '');

        }
        else {
            $exitDate = NULL;
            $exitPrice = NULL;
        }

        if ($fees == 0.00) {
            $fees = NULL;
        }

        $stmt = $conn->prepare('INSERT INTO trades (symbol, side, quantity, entry_date, entry_price, entry_amount, status, exit_price, exit_date, exit_amount, net_return, net_roi, fees, uid, account_id) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
        $stmt->bind_param('ssssiisisiiiiii', $symbol, $side, $qty, $entryDate, $entryPrice, $entryAmt, $status, $exitPrice, $exitDate, $exitAmt, $netReturn, $roi, $fees, $_SESSION['uid'], $_SESSION['account_id']);
        $stmt->execute();
        $stmt->close();
    }