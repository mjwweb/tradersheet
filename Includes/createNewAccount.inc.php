<?php

    session_start();

    if (isset($_SESSION['uid'])) {
        require 'dbh.inc.php';

        $account_name = $_POST['accountName'];

        // create the api key
        $keyChars = uniqid(true).'abcdef123456';
        $apiKey = str_shuffle($keyChars);

        $stmt = $conn->prepare('INSERT INTO accounts (account_name, api_key, uid)  VALUES (?, ?, ?)');
        $stmt->bind_param('ssi', $account_name, $apiKey, $_SESSION['uid']);
        $stmt->execute();
        $new_account_id = $stmt->insert_id;
        $stmt->close();

        // set as the new default_account_id

        $stmt = $conn->prepare('UPDATE users SET default_account_id=? WHERE uid=?');
        $stmt->bind_param('ii', $new_account_id, $_SESSION['uid']);
        $stmt->execute();
        $stmt->close();
    }