<?php

    require 'dbh.inc.php';

    $email = $_POST['email'];
    $pwd = $_POST['pwd'];

    if (!empty($email && !empty($pwd))) {

        // check if email already exists

        $stmt = $conn->prepare('SELECT email FROM users WHERE email=?');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();
        $rows = $stmt->num_rows;
        $stmt->close();

        if ($rows == 0) {
            $cookieId = password_hash($email, PASSWORD_DEFAULT);
            $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

            date_default_timezone_set("UTC");
            $curDT = date("Y-m-d H:i:s", time());
            $account_status = 'early_access'; // account status for stripe payments
            $demo_account_name = 'Demo Account'; // default brokerage account
            $temp_account_id = 1;

            // add user to the users table

            $stmt = $conn->prepare('INSERT INTO users (email, hashed_password, cookieId, signup_datetime, account_status, default_account_id) VALUES (?, ?, ?, ?, ?, ?)');
            $stmt->bind_param('sssssi', $email, $hashedPwd, $cookieId, $curDT, $account_status, $temp_account_id);
            $stmt->execute();
            $uid = $stmt->insert_id; // the uid to set the session to
            $stmt->close();

            // create the demo account in the account table
            // create the api key
            $keyChars = uniqid(true).'abcdef123456';
            $apiKey = str_shuffle($keyChars);

            $stmt = $conn->prepare('INSERT INTO accounts (account_name, api_key, uid) VALUES (?, ?, ?)');
            $stmt->bind_param('ssi', $demo_account_name, $apiKey, $uid);
            $stmt->execute();
            $demo_account_id = $stmt->insert_id; // replace the $temp_account_id originally inserted in the previous query to this
            $stmt->close();

            // update the $temp_account_id to the new demo account id for the users default account
            
            $stmt = $conn->prepare('UPDATE users SET default_account_id = ? WHERE uid = ?');
            $stmt->bind_param('ii', $demo_account_id, $uid);
            $stmt->execute();
            $stmt->close();

            session_start();

            $_SESSION['uid'] = $uid;
            $_SESSION['email'] = $email;
            $_SESSION['account_status'] = $account_status; // for validating payments through stripe
            $_SESSION['account_id'] = $demo_account_id; // brokerage account that trades are saved under

            setcookie('al_auth', $cookieId, time() + (10 * 365 * 24 * 60 * 60), '/'); // cookie for auto login

            $stmt = $conn->prepare('INSERT INTO signups (uid) VALUES(?)');
            $stmt->bind_param('i', $_SESSION['uid']);
            $stmt->execute();
            $stmt->close();

            echo 1;
        }
        else {
            echo 'Account already exists with email';
        }

        // load data into the users demo account
    
        for ($i=0; $i < 200; $i++) {
            $symbolArr = ['AAPL','MSFT','TSLA','BTC','ETH','XRP','JNJ','AMZN','NVDA','GOOG','NKE','CSCO','JPM','DIS','MMM','BRK.B','PG','NKE'];
            $symbol = $symbolArr[array_rand($symbolArr)];

            $qty = rand(2, 5);
            $entryPrice = rand(50, 200);
            $entryAmt = $qty * $entryPrice;
            $status = 'Open';
            $shortBool = rand(0, 1);

            if ($shortBool == 0) {
                $side = 'Long';
            } else {
                $side = 'Short';
            }

            $today = time();
            $threeMonthsAgo = $today - 7889229;
            $halfYearAgo = $today - 15778458;
        
            $entryDateUnix = rand($halfYearAgo, $threeMonthsAgo);  // random date between 1 year ago to 6 months ago from today
            $entryDate = date("Y-m-d", $entryDateUnix);

            if ($i > 7) {
                $status = 'Closed';

                if ($side == 'Long') {
                    $exitPrice = rand(58, 215);
                } else {
                    $exitPrice = rand(42, 185);
                }

                $exitDateUnix = rand($threeMonthsAgo, $today); // random date between 6 months ago to today
                $exitDate = date("Y-m-d", $exitDateUnix);
                $exitAmt = $qty * $exitPrice;

                if ($side == 'Long') {
                    $netReturn = ($exitAmt - $entryAmt);
                    $netReturn = number_format((float)$netReturn, 2, '.', '');
                }
                else {
                    $netReturn = ($entryAmt - $exitAmt);
                    $netReturn = number_format((float)$netReturn, 2, '.', '');
                }
    
                $roi = ($netReturn / $entryAmt) * 100;
                $roi = number_format((float)$roi, 2, '.', '');
            } 
            else {
                $exitPrice = NULL;
                $exitDate = NULL;
                $exitAmt = NULL;
                $netReturn = NULL;
                $roi = NULL;
            }

            $stmt = $conn->prepare('INSERT INTO trades (uid, account_id, status, symbol, side, quantity, entry_price, entry_amount, exit_price, exit_amount, entry_date, exit_date, net_return, net_roi) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?) ');
            $stmt->bind_param('iissssssssssss', $_SESSION['uid'], $_SESSION['account_id'], $status, $symbol, $side, $qty, $entryPrice, $entryAmt, $exitPrice, $exitAmt, $entryDate, $exitDate, $netReturn, $roi);
            $stmt->execute();
            $stmt->close();
            }

    }