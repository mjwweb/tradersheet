<?php

    require 'dbh.inc.php';
    session_start();

    if (isset($_SESSION['uid'])) {

        $noteId = $_POST['noteId'];
        
        $stmt = $conn->prepare('DELETE FROM notes WHERE id=? AND uid=?');
        $stmt->bind_param('ii', $noteId, $_SESSION['uid']);
        $stmt->execute();
        $stmt->close();

    }