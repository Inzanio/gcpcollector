<?php
    $route = $_GET['route'];

    switch ($route) {
        case '':
            require_once './dashboard.php';
            break;
        case 'login':
            require_once './login.php';
            break;
        // case 'contact':
        //     include 'contact.php';
        //     break;
        default:
            require_once './404.php';
            break;
    }
?>