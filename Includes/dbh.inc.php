<?php

    //check if running on localhost

    if ($_SERVER['REMOTE_ADDR'] == '::1' || $_SERVER['REMOTE_ADDR'] == '127.0.0.1') {
        $dbServername = "localhost";
        $dbUsername = "root";
        $dbPassword = "";
        $dbName = "tradelog_spreadsheet";
    } else {
        $dbServername = "ls-304d582df67a61a8ad296bb20b52b394ffe7d9e5.cxythzh1s89i.us-east-1.rds.amazonaws.com";
        $dbUsername = "dbmasteruser";
        $dbPassword = '0CEZALB.`^r0Nrq?t!,5~<l^J6*!FDR$';
        $dbName = "tradersheet";
    }

    $conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);
    
    if (!$conn) {
        die("Connection failed: ".mysqli_connect_error());
    }