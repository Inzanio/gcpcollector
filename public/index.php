<?php
$url = $_SERVER['REQUEST_URI'];

switch ($url) {
    case '/':
        include 'index.php';
        break;
    // case '/about':
    //     include 'about.php';
    //     break;
    // case '/contact':
    //     include 'contact.php';
    //     break;
    default:
        include '404.php';
        break;
}
?>