<?php

    require 'dbh.inc.php';
    session_start();

    if (isset($_SESSION['uid'])) {

        $tradeId = $_POST['id'];
        $symbol = $_POST['symbol'];
        
        $stmt = $conn->prepare('SELECT id, bullet_note FROM notes WHERE uid=? AND trade_id=?');
        $stmt->bind_param('ii', $_SESSION['uid'], $tradeId);
        $stmt->execute();
        $stmt->bind_result($noteId, $note);

        echo '
        <div class="tradeNotesInner">
            <div class="tradeNotesTopBar">
                <i class="far fa-bars tradeNotesHandle"></i>
                <p class="tradeNotesHdr">'.$symbol.'</p>
                <div class="closeTradeNotes">
                    <i class="bi bi-x-lg"></i>
                </div>
            </div>

            <div class="tradeNotesWrap" tradeId="'.$tradeId.'" symbol="'.$symbol.'">';


        while ($stmt->fetch()) {

            echo '
                <div class="tradeNoteWrap" noteId="'.$noteId.'">
                    <span class="tnBullet">•</span>
                    <textarea rows="1" class="tradeNoteInpt">'.$note.'</textarea>
                    <span class="deleteNoteBtn"><i class="bi bi-trash"></i></span>
                </div>';
        }

        $newNoteId = rand(100000000,999999999);
            echo '
                <div class="tradeNoteWrap newTradeNoteWrap" noteId="'.$newNoteId.'">
                    <span class="tnBullet">•</span>
                    <textarea rows="1" placeholder="Type a new note" class="tradeNoteInpt"></textarea>
                    <span class="deleteNoteBtn"><i class="bi bi-trash"></i></span>
                </div>';

        echo '
            </div>
        </div>';

    }