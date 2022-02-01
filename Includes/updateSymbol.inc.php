<?php

    require 'dbh.inc.php';

    session_start();

    if (isset($_SESSION['uid'])) {
        $id = $_POST['id'];

        if (empty($_POST['symbol'])) {
            $symbol = NULL;
        } 
        else {
            $symbol = $_POST['symbol'];
        }

        $stmt = $conn->prepare('UPDATE trades SET symbol=? WHERE id=? AND uid=?');
        $stmt->bind_param('ssi', $symbol, $id, $_SESSION['uid']);
        $stmt->execute();
        $stmt->close();

    }