<?php

    session_start();

    if (isset($_SESSION['id'])) {
        $current_user_id = $_SESSION['id'];
    };

?>
