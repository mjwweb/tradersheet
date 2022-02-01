<?php

    session_start();

    if (isset($_SESSION['uid']) && isset($_SESSION['account_id'])) {
        require 'dbh.inc.php';

        if ($_SESSION['account_id'] !== '0') {
            $stmt = $conn->prepare('SELECT account_name FROM accounts WHERE id=? AND uid=?');
            $stmt->bind_param('ii', $_SESSION['account_id'], $_SESSION['uid']);
            $stmt->execute();
            $stmt->bind_result($account_name);
            $stmt->fetch();
            $stmt->close();
            echo ucwords($account_name);
        }

    }