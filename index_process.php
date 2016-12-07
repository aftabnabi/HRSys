<?php 
	session_start();
	include("dbconfig.php");
	
	if(($_POST['username'])&&($_POST['password']) )
	{
		
		$user=$_POST['username'];

		$sql = 'SELECT users_id, first_name, last_name, user_name, password, user_roles_id, users.department_id,' 				   
			  .' email_id, departments.division_id '
			  .' FROM users '
			  .' INNER JOIN departments on users.department_id=departments.department_id '
			  .' INNER JOIN divisions on departments.division_id=divisions.division_id  '
			  .' WHERE user_name = "'.$user.'" and password ="'.md5($_POST["password"]).'"';

		$res = mysql_query($sql) or die("error: ".mysql_error());
		$row = mysql_fetch_array($res);
	
		if (mysql_num_rows($res)) 
		{
		    $_SESSION['authorized']		= true;
		    $_SESSION['userid'] 		= $row['users_id'];
			$_SESSION['username']		= stripslashes($row['user_name']);
			$_SESSION['first_name']		= stripslashes($row['first_name']);
			$_SESSION['last_name']		= stripslashes($row['last_name']);
			$_SESSION['user_role']		= $row['user_roles_id'];
			$_SESSION['department_id'] 	= $row['department_id'];
			$_SESSION['division_id']	= $row['division_id'];
			$_SESSION['email_id'] 		= stripslashes($row['email_id']);
			$target = "";	
			if($row['user_roles_id']==2)
			{
				$target = "HR Dashboard";
			}
			else
			{
				$target = "Line Manager Dashboard";
			}	
			
			header("location: index.php?act=login&resp=success&target=".$target);
  			exit;
		} 
		else 
		{
			header("location: index.php?act=login&resp=fail");
  			exit;
		}
	}
	else
	{
		header("location: index.php?act=login&resp=fail");
		exit;
	}
?>