<?php

    require_once('init.php');
    if (isset($_SESSION['id'])) {
        unset($_SESSION['id']);
    };

    header("Location: /index.php");
?>
