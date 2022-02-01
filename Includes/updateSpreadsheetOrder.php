<?php

    require 'dbh.inc.php';
    require 'functions.inc.php';

    $column = $_POST['column'];
    $action = $_POST['action'];

    $uid = 1;

    $order = $column.' '.$action;

    $stmt = $conn->prepare('UPDATE user_preferences SET moments_order=? WHERE uid=?');
    $stmt->bind_param('si', $order, $uid);
    $stmt->execute();
    $stmt->close();

    loadSpreadsheetLog();