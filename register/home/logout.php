<?php  
session_start();

session_unset();
session_destroy();

header("Location: ../../x2/access/en.php");
exit;