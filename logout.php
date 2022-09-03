<?php
session_start();
$_SESSION = [];
session_reset();
session_destroy();

setcookie('id', '', time() + 3600);
setcookie('key', '', time() + 3600);

header("location: login.php");
exit;
