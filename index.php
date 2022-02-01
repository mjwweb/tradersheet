
<?php

    session_start();

    //check if running on localhost

    if ($_SERVER['REMOTE_ADDR'] == '::1' || $_SERVER['REMOTE_ADDR'] == '127.0.0.1') {
        $local = true;
    } else {
        $local = false;
    }

    if (isset($_GET['epdemo']) && $_GET['epdemo'] == 1 && $local == false) {
        require 'header.php';
        
        $_SESSION['email'] = 'employer@email.com';
        $_SESSION['uid'] = 2;
        $_SESSION['account_id'] = 3;

        require 'tradelog.php';
    }
    else if (isset($_SESSION['uid'])) {

        // check for account status (stripe) and default account id on every page load
        // if the uid session is alreadys started
        require 'header.php';

        $stmt = $conn->prepare('SELECT account_status, customer_id, default_account_id FROM users WHERE uid=?');
        $stmt->bind_param('i', $_SESSION['uid']);
        $stmt->execute();
        $stmt->bind_result($account_status, $customer_id, $account_id);
        $stmt->fetch();
        $stmt->close();

        $_SESSION['account_status'] = $account_status; // stripe account status
        $_SESSION['customer_id'] = $customer_id; // stripe customer id
        $_SESSION['account_id'] = $account_id; // the users default account to save trades under

        require 'tradelog.php';
    }
    else if (!isset($_SESSION['uid']) && isset($_COOKIE['al_auth'])) {

        // auto login user with cookie
        require 'header.php';

        $cookieId = $_COOKIE['al_auth'];

        $stmt = $conn->prepare('SELECT uid, email, account_status, customer_id, default_account_id FROM users WHERE cookieId=?');
        $stmt->bind_param('s', $cookieId);
        $stmt->execute();
        $stmt->bind_result($uid, $email, $account_status, $customer_id, $account_id);
        $stmt->fetch();
        $stmt->close();

        $_SESSION['email'] = $email;
        $_SESSION['uid'] = $uid;
        $_SESSION['account_status'] = $account_status; // stripe account status
        $_SESSION['customer_id'] = $customer_id; // stripe customer id
        $_SESSION['account_id'] =  $account_id; // the users default account to save trades under

        require 'tradelog.php';

    }
    else {
        if ($local == true) {
            header('Location: http://localhost/tradersheet/home/');
        }
        else {
            header('Location: https://www.mike-worden.com/tradersheet/home/');
        }
    }

?>
