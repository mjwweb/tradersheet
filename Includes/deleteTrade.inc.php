<?php

    session_start();

    if (isset($_SESSION['uid'])) {
        require 'dbh.inc.php';

        $tradeId = $_POST['id'];

        $stmt = $conn->prepare('DELETE FROM trades WHERE id=? AND uid=?');
        $stmt->bind_param('ii', $tradeId, $_SESSION['uid']);
        $stmt->execute();
        $stmt->close();

        $stmt = $conn->prepare('DELETE FROM notes WHERE trade_id=? AND uid=?');
        $stmt->bind_param('ii', $tradeId, $_SESSION['uid']);
        $stmt->execute();
        $stmt->close();
    }