<?php

    require '../Includes/dbh.inc.php';

    if (isset($_GET['key'])) {
        require 'apifetch.php';
    } else {
        require 'apidocs.php';
    }