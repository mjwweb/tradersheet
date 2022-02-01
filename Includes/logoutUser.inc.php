<?php

    session_start();
    unset($_SESSION['uid']);
    unset($_SESSION['email']);
    unset($_SESSION['demo']);
    setcookie('al_auth', '', -1, '/');
    session_destroy();