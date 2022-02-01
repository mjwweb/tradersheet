<?php

    require 'dbh.inc.php';

    session_start();

    if (isset($_SESSION['uid'])) {
        $id = $_POST['id'];

        if (empty($_POST['takeProfit'])) {
            $takeProfit = NULL;
        } 
        else {
            $takeProfit = $_POST['takeProfit'];
        }

        $stmt = $conn->prepare('UPDATE trades SET take_profit=? WHERE id=? AND uid=?');
        $stmt->bind_param('sii', $takeProfit, $id, $_SESSION['uid']);
        $stmt->execute();
        $stmt->close();
    }