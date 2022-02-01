<?php

    $name = $_POST['name'];
    $email = $_POST['email'];
    $msg = $_POST['msg'];

    if (!empty($name) && !empty($email) && !empty($msg)) {
        session_start();
        require '../Includes/dbh.inc.php';

        if (!isset($_SESSION['uid'])) {
            echo 'no uid';
            $stmt = $conn->prepare('INSERT INTO support (person_name, person_email, person_message) VALUES(?,?,?)');
            $stmt->bind_param('sss', $name, $email, $msg);
            $stmt->execute();
            $stmt->close();
        } else {
            echo 'uid';
            $stmt = $conn->prepare('INSERT INTO support (person_name, person_email, person_message, uid) VALUES(?,?,?, ?)');
            $stmt->bind_param('sssi', $name, $email, $msg, $_SESSION['uid']);
            $stmt->execute();
            $stmt->close();
        }

    }

