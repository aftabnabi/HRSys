<?php
	session_start();
	session_destroy();
	$_SESSION['message'] = "You have been logged out";
	header("location: index.php");
	exit;
?>