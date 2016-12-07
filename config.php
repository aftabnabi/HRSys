<?php
	session_start();
	if (empty($_SESSION['userid'])) {
		$_SESSION['message'] = "You have been logged out or session expired, Please login again.";
		header("location: index.php");
		exit;
	}

	include_once("systemconfig.php");
	include_once("dbconfig.php");
?>