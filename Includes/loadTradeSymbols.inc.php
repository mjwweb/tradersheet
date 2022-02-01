<?php

    session_start();

    if (isset($_SESSION['uid']) && isset($_SESSION['account_id'])) {
        require 'dbh.inc.php';

        $query = $_POST['query'];
        $queryPattern = $query.'%';

        if ($query == 'null') {
            $stmt = $conn->prepare('SELECT DISTINCT symbol FROM trades WHERE uid=? AND account_id=?');
            $stmt->bind_param('ii', $_SESSION['uid'], $_SESSION['account_id']);
        } else {
            $stmt = $conn->prepare('SELECT DISTINCT symbol FROM trades WHERE uid=? AND account_id=? AND symbol LIKE ?');
            $stmt->bind_param('iis', $_SESSION['uid'], $_SESSION['account_id'], $queryPattern);
        }
        $stmt->execute();
        $stmt->bind_result($symbol);
        while ($stmt->fetch()) {
            echo '<p>'.$symbol.'</p>';
        }
        $stmt->close();
    }