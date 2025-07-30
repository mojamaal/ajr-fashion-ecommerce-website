<?php
session_start();
session_destroy();
header('Location: /ajr_fashion/index.php');
exit;
?>