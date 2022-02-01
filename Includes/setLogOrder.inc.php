<?php

    session_start();
    require 'dbh.inc.php';

    if (isset($_SESSION['uid'])) {

        $column = $_POST['column'];
        $direction = $_POST['direction'];
        $sortIdArr = array();

        $order = $column.' '.$direction;

        //$stmt = $conn->prepare('SELECT id FROM trades WHERE uid=? ORDER BY '.$column.' IS NULL, '.$order.'');
        $stmt = $conn->prepare('SELECT id FROM trades WHERE uid=? ORDER BY '.$order.'');
        $stmt->bind_param('i', $_SESSION['uid']);
        $stmt->execute();
        $stmt->bind_result($tradeId);

        $sortId = 0;

        while ($stmt->fetch()) {
            $sortId++;

            $sortIdArr[$tradeId] = $sortId;
            
        }
        $stmt->close();

        foreach ($sortIdArr as $tradeId => $sortId) {
            $stmt = $conn->prepare('UPDATE trades SET sortId=? WHERE uid=? AND id=?');
            $stmt->bind_param('iii', $sortId, $_SESSION['uid'], $tradeId);
            $stmt->execute();
            $stmt->close();
        }

    }
