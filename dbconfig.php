<?php
	$dbhost = "127.0.0.1";
	//$dbuser = "formitis_cpm";
	// $dbpassword = "formitis@cpm!";
	// $database = "formitis_cpm";
	 $dbuser = "root";
	 $dbpassword = "";
	 $database = "resources_module";
	
	$table_prefix = "";
	
	$db = mysqli_connect($dbhost, $dbuser, $dbpassword, $database) or die("Connection Error: " . mysql_error()); 
	//mysqli_select_db($database) or die("Error conecting to db.");
?>