<?php

    require 'dbh.inc.php';

    session_start();

    if (isset($_SESSION['uid'])) {
        $id = $_POST['id'];

        if (empty($_POST['category'])) {
            $category = NULL;
        } 
        else {
            $category = $_POST['category'];
        }

        $stmt = $conn->prepare('UPDATE trades SET category=? WHERE id=? AND uid=?');
        $stmt->bind_param('ssi', $category, $id, $_SESSION['uid']);
        $stmt->execute();
        $stmt->close();

    }