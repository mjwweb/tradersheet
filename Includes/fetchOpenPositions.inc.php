<?php

    session_start();

    if (isset($_SESSION['uid']) && isset($_SESSION['account_id'])) {
        require 'dbh.inc.php';

        $open = 'open';
        $chart_data = [];

        $stmt = $conn->prepare('SELECT symbol, entry_amount FROM trades WHERE status=? AND uid=? AND account_id=?');
        $stmt->bind_param('sii', $open, $_SESSION['uid'], $_SESSION['account_id']);
        $stmt->execute();
        $stmt->bind_result($symbol, $entry_amount);

        while ($stmt->fetch()) {
            if (array_key_exists($symbol, $chart_data)) {
                $chart_data[$symbol] += floatval($entry_amount);
            }
            else {
                $chart_data[$symbol] = floatval($entry_amount);
            }
        }

        arsort($chart_data);

        echo json_encode($chart_data);

        $stmt->close();
    }