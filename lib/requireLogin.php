<?php

include_once 'lib/User.php';

session_start();
if(!isset($_SESSION['user'])){
	$location = dirname($_SERVER['SCRIPT_NAME']) . '/login.php';
	header('Location: ' . $location);
	die();
}

?>
