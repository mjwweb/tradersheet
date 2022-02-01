
<?php

    session_start();

    if (isset($_SESSION['uid']) && isset($_SESSION['account_id'])) {
        require 'dbh.inc.php';
        $accountId = $_POST['id'];

        $stmt = $conn->prepare('SELECT api_key FROM accounts WHERE uid=? AND id=?');
        $stmt->bind_param('ii', $_SESSION['uid'], $accountId);
        $stmt->execute();
        $stmt->bind_result($key);
        $stmt->fetch();
        echo $key;
        $stmt->close();
    }