<?php

session_start();

// From the PHP manual: "When deleting a cookie you should
// assure that the expiration date is in the past, to
// trigger the removal mechanism in your browser."
setcookie(session_name(), '', time() - 3600);

session_unset();
session_destroy();
unset($_SESSION);

header('Location: login.php');
die();

?>
