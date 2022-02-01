<?php

    require 'dbh.inc.php';

    $email = $_POST['email'];
    $pwd = $_POST['pwd'];

    if (!empty($email) && !empty($pwd)) {

        $stmt = $conn->prepare('SELECT uid, email, hashed_password, cookieId, account_status, default_account_id FROM users WHERE email=?');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();
        $rows = $stmt->num_rows;

        if ($rows == 1) {
            $stmt->bind_result($uid, $email, $hashed_pwd, $cookie_id, $account_status, $account_id);
            $stmt->fetch();
            $stmt->close();

            if (password_verify($pwd, $hashed_pwd)) {

                session_start();

                $_SESSION['email'] = $email;
                $_SESSION['uid'] = $uid;
                $_SESSION['account_status'] = $account_status;
                $_SESSION['account_id'] = $account_id;

                setcookie('al_auth', $cookie_id, time() + (10 * 365 * 24 * 60 * 60), '/');

                $stmt = $conn->prepare('INSERT INTO logins (uid) VALUES(?)');
                $stmt->bind_param('i', $_SESSION['uid']);
                $stmt->execute();
                $stmt->close();

                echo 1;
            } 
            else {
                echo 'Incorrect password';
            }

        }
        else {
            echo 'Account with email does not exist';
        }

    }