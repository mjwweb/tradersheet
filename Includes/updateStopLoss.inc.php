<?php

    require 'dbh.inc.php';

    session_start();

    if (isset($_SESSION['uid'])) {
        $id = $_POST['id'];

        if (empty($_POST['stopLoss'])) {
            $stopLoss = NULL;
        } 
        else {
            $stopLoss = $_POST['stopLoss'];
        }

        $stmt = $conn->prepare('UPDATE trades SET stop_loss=? WHERE id=? AND uid=?');
        $stmt->bind_param('sii', $stopLoss, $id, $_SESSION['uid']);
        $stmt->execute();
        $stmt->close();
    }