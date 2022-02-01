<?php

    session_start();

    if (isset($_SESSION['uid'])) {
        require 'dbh.inc.php';

        $account_name = $_POST['account_name'];
        $account_id = $_POST['account_id'];

        $stmt = $conn->prepare('UPDATE accounts SET account_name = ? WHERE uid = ? AND id = ?');
        $stmt->bind_param('sii', $account_name, $_SESSION['uid'], $account_id);
        $stmt->execute();
        $stmt->close();
    }