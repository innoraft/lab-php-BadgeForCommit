<?php
    session_start();
    session_destroy();
    header('Location:http://badgethecommit.local/index.php');
?>