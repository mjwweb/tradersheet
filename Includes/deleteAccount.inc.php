<?php

    session_start();

    if (isset($_SESSION['uid']) && isset($_SESSION['account_id'])) {

        require 'dbh.inc.php';

        $account_id = $_POST['account_id'];
        $account_name_verify = $_POST['account_name_verify'];

        $stmt = $conn->prepare('SELECT account_name FROM accounts WHERE id=? AND uid=?');
        $stmt->bind_param('ii', $account_id, $_SESSION['uid']);
        $stmt->execute();
        $stmt->bind_result($account_name);
        $stmt->fetch();
        $stmt->close();

        if (!empty($account_name) && strtolower($account_name) == strtolower($account_name_verify)) {

            // delete trades
            $stmt = $conn->prepare('DELETE FROM trades WHERE uid=? AND account_id=?');
            $stmt->bind_param('ii', $_SESSION['uid'], $account_id);
            $stmt->execute();
            $stmt->close();

            // delete notes
            $stmt = $conn->prepare('DELETE from notes WHERE uid=? AND account_id=?');
            $stmt->bind_param('ii', $_SESSION['uid'], $account_id);
            $stmt->execute();
            $stmt->close();

            // delete account
            $stmt = $conn->prepare('DELETE FROM accounts WHERE uid=? AND id=?');
            $stmt->bind_param('ii', $_SESSION['uid'], $account_id);
            $stmt->execute();
            $stmt->close();

            // check if the deleted account was the current active account

            if ($account_id == $_SESSION['account_id']) {

                // select another account to set the default_account_id to in the users table

                $stmt = $conn->prepare('SELECT id FROM accounts WHERE uid=? ORDER BY account_name LIMIT 1');
                $stmt->bind_param('i', $_SESSION['uid']);
                $stmt->execute();
                $stmt->store_result();
                $accounts = $stmt->num_rows;
                
                // set default_account_id in users table to 0 if no other accounts exist
    
                if ($accounts == '0') {
                    $default_account_id = '0';
                    echo 'no other accounts left';
                }
    
                // set default_account_id to the new account queried
    
                else {
                    $stmt->bind_result($default_account_id);
                    $stmt->fetch();
    
                }
                $stmt->close();
    
                // finally update the user table to the new default_account_id
                // if the new_account_id is 0, show the new account form on page reload

                $stmt = $conn->prepare('UPDATE users SET default_account_id=? WHERE uid=?');
                $stmt->bind_param('ii', $default_account_id, $_SESSION['uid']);
                $stmt->execute();
                $stmt->close();

            }

        }
        else {
            echo 'bad name match';
        }

    }