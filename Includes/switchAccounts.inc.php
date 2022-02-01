<?php

    session_start();

    if (isset($_SESSION['uid']) && isset($_SESSION['account_id'])) {
        require 'dbh.inc.php';

        $account_id = $_POST['account_id'];

        $stmt = $conn->prepare('SELECT COUNT(*) FROM accounts WHERE id=? AND uid=?');
        $stmt->bind_param('ii', $account_id, $_SESSION['uid']);
        $stmt->execute();
        $stmt->bind_result($verify_account_ownership);
        $stmt->fetch();
        $stmt->close();

        // check the account id against the session uid to verify ownership

        if ($verify_account_ownership == '1') {
            $stmt = $conn->prepare('UPDATE users SET default_account_id=? WHERE uid=?');
            $stmt->bind_param('ii', $account_id, $_SESSION['uid']);
            $stmt->execute();
            $stmt->close();
        }
    }