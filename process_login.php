<?php
	include "include/config.php";
	
	if(($_POST['username'])&&($_POST['password']) )
	{
		
		$user=$_POST['username'];
		$pass=$_POST['password'];
		$sql = 'select id,username,password from users where username = "' .$user . '" and password = "' .$pass.'"';
		$res = mysql_query($sql) or die("error: ".mysql_error());
		$row = mysql_fetch_array($res);
	
		if (mysql_num_rows($res)) 
		{
		    $_SESSION['authorized'] = true;
		    $_SESSION['userid'] = $row['id'];
				header("location:main.php");
  			exit;
		} 
		else 
		{
			$_SESSION['msg'] = "Login Failed, Invalid Username/Password.";
	    header("location:index.php");
  		exit;
		}
	}
?>
