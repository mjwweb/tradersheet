<?php

    session_start();

    if (!isset($_SESSION['uid'])) {
        require 'header.php';

        if (isset($_GET['login'])) {
            require 'login.php';
        }
        else if (isset($_GET['register'])) {
            require 'register.php';
        }
        else {
            require 'login.php';
        }
    } else {
        if ($_SERVER['REMOTE_ADDR'] == '::1' || $_SERVER['REMOTE_ADDR'] == '127.0.0.1') {
            header('Location: http://localhost/tradersheet/');
        }
        else {
            header('Location: https://www.mike-worden.com/tradersheet');
        }
    }