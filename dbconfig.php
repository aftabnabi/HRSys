<?php
	$dbhost = "localhost";
	// $dbuser = "formitis_cpm";
	// $dbpassword = "formitis@cpm!";
	// $database = "formitis_cpm";
	 $dbuser = "root";
	 $dbpassword = "";
	 $database = "resources_module";
	
	$table_prefix = "";
	
	$db = mysql_connect($dbhost, $dbuser, $dbpassword) or die("Connection Error: " . mysql_error()); 
	mysql_select_db($database) or die("Error conecting to db.");
?>