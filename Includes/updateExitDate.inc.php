<?php

    require 'dbh.inc.php';

    session_start();

    if (isset($_SESSION['uid'])) {
        $id = $_POST['id'];

        if (empty($_POST['date'])) {
            $date = NULL;
        } 
        else {
            $date = $_POST['date'];
        }

        $stmt = $conn->prepare('UPDATE trades SET exit_date=? WHERE id=? AND uid=?');
        $stmt->bind_param('ssi', $date, $id, $_SESSION['uid']);
        $stmt->execute();
        $stmt->close();

    }