<?php
    if (!file_exists($_SERVER['REQUEST_URI'])) {
        header('Location: page404.php');
        exit();
    }
?>