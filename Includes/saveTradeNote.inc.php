<?php

    require 'dbh.inc.php';
    session_start();

    if (isset($_SESSION['uid']) && isset($_SESSION['account_id'])) {

        $tradeId = $_POST['tradeId'];
        $symbol = $_POST['symbol'];
        $noteId = $_POST['noteId'];
        $note = $_POST['note'];

        if (!empty($note) && !empty($tradeId)) {
            $stmt = $conn->prepare('SELECT id FROM notes WHERE id=? AND uid=?');
            $stmt->bind_param('ii', $noteId, $_SESSION['uid']);
            $stmt->execute();
            $stmt->store_result();
            $rows = $stmt->num_rows;
            $stmt->close();

            if ($rows == 0) {
                $stmt = $conn->prepare('INSERT INTO notes (uid, account_id, trade_id, symbol, bullet_note) VALUES(?,?,?,?,?)');
                $stmt->bind_param('iiiss', $_SESSION['uid'], $_SESSION['account_id'], $tradeId, $symbol, $note);
                $stmt->execute();
                echo $stmt->insert_id;
                $stmt->close();
            }
            else {
                $stmt = $conn->prepare('UPDATE notes SET bullet_note=? WHERE id=? AND trade_id=? AND uid=? AND account_id=?');
                $stmt->bind_param('siiii', $note, $noteId, $tradeId, $_SESSION['uid'], $_SESSION['account_id']);
                $stmt->execute();
                $stmt->close();
            }
        }

    }