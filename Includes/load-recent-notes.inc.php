<?php

    session_start();

    if (isset($_SESSION['uid']) && isset($_SESSION['account_id'])) {
        require 'dbh.inc.php';

        $stmt = $conn->prepare('SELECT trade_id, symbol, bullet_note FROM notes WHERE uid=? AND account_id=? ORDER BY id desc');
        $stmt->bind_param('ii', $_SESSION['uid'], $_SESSION['account_id']);
        $stmt->execute();
        $stmt->bind_result($trade_id, $symbol, $note);
        
        $previous_trade_id = null;

        while($stmt->fetch()) {
            
            if ($trade_id !== $previous_trade_id) {
                echo '
                    <div class="recentNoteSymbol">'.$symbol.'</div>
                    <div class="recentNoteBullet">• '.$note.'</div>';

            }
            else {
                echo '<div class="recentNoteBullet">• '.$note.'</div>';
            }

            $previous_trade_id = $trade_id;
        }
        $stmt->close();
    }