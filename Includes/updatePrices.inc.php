<?php 

    require 'dbh.inc.php';

    session_start();

    if (isset($_SESSION['uid'])) {
        $id = $_POST['id'];
        $status = $_POST['status'];
        $side = $_POST['side'];

        //net return
        if (empty($_POST['netReturn']) && $_POST['netReturn'] !== '0') {
            $netReturn = NULL;
        } 
        else {
            $netReturn = $_POST['netReturn'];
        }

        //roi
        if (empty($_POST['roi']) && $_POST['roi'] !== '0') {
            $roi = NULL;
        } 
        else {
            $roi = $_POST['roi'];
        }

        //quantity
        if (empty($_POST['qty']) && $_POST['qty'] !== '0') {
            $qty = NULL;
        } 
        else {
            $qty = $_POST['qty'];
        }

        //entry
        if (empty($_POST['entry']) && $_POST['entry'] !== '0') {
            $entry = NULL;
        } 
        else {
            $entry = $_POST['entry'];
        }

        if (empty($_POST['entryAmt']) && $_POST['entryAmt'] !== '0') {
            $entryAmt = NULL;
        } 
        else {
            $entryAmt = $_POST['entryAmt'];
        }

        //exit
        if (empty($_POST['exit']) && $_POST['exit'] !== '0') {
            $exit = NULL;
        } 
        else {
            $exit = $_POST['exit'];
        }

        if (empty($_POST['exitAmt']) && $_POST['exitAmt'] !== '0') {
            $exitAmt = NULL;
        } 
        else {
            $exitAmt = $_POST['exitAmt'];
        }

        if (empty($_POST['fees']) && $_POST['fees'] !== '0') {
            $fees = NULL;
        } 
        else {
            $fees = $_POST['fees'];
        }
        
        
        $stmt = $conn->prepare('SELECT id FROM trades WHERE id=? AND uid=?');
        $stmt->bind_param('ii', $id, $_SESSION['uid']);
        $stmt->execute();
        $stmt->store_result();
        $rows = $stmt->num_rows;

        if ($rows == 0) {
            $stmt = $conn->prepare('INSERT INTO trades (uid, status, side, quantity, entry_price, exit_price, entry_amount, exit_amount, fees) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
            $stmt ->bind_param('isssiiiii', $_SESSION['uid'], $status, $side, $qty, $entry, $exit, $entryAmt, $exitAmt, $fees);
            $stmt->execute();
            echo $stmt->insert_id;
            $stmt->close();
        }
        else {
            $stmt = $conn->prepare('UPDATE trades SET status=?, side=?, quantity=?, entry_price=?, exit_price=?, entry_amount=?, exit_amount=?, fees=?, net_return=?, net_roi=? WHERE id=? AND uid=?');
            $stmt->bind_param('sssiiiiissii', $status, $side, $qty, $entry, $exit, $entryAmt, $exitAmt, $fees, $netReturn, $roi, $id, $_SESSION['uid']);
            $stmt->execute();
            $stmt->close();
        }
    }
