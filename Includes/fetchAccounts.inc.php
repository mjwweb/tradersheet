<?php

    session_start();

    if (isset($_SESSION['uid'])) {
        require 'dbh.inc.php';

        $stmt = $conn->prepare('SELECT account_name, id FROM accounts WHERE uid=?');
        $stmt->bind_param('i', $_SESSION['uid']);
        $stmt->execute();
        $stmt->bind_result($account_name, $id);
        while ($stmt->fetch()) {
            echo '
                <div class="accountDropdownResultRow accountLoadedRow" accountName="'.$account_name.'" accountId="'.$id.'">
                    <span>'.ucwords($account_name).'</span>
                    <i class="bi bi-three-dots-vertical editAccountBtn" accountName="'.$account_name.'" accountId="'.$id.'"></i>
                </div>';
        }
        $stmt->close();
    }