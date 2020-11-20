<?php 
	session_start();
	
	//ajax response handling from index_process to 
	if ($_GET['act'] == "login") {
	
		if ($_GET['resp'] == "success") {
			echo "SUCCESS:Login Successful, redirecting to '".$_GET['target']."'.";
			exit;
		}
		else {
			echo "ERROR:Login Failed, Invalid Username/Password.";
			exit;
		}
	}

	//redirecting after successful login
	if (isset($_SESSION['userid']) && ($_SESSION['userid']!="")) {
		if ($_SESSION['user_role'] == 1) {
			header("location: lm.php");
			exit;
		}
		if ($_SESSION['user_role'] == 2) {
			header("location: hr.php");
			exit;
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mobilink Sourcing System</title>
<?php include("header.php");?>
<script>
$(function(){

	$("input#username").focus();
	
	function handleResponse(responseText, statusText, xhr, $form)  { 
		var resp = responseText.split(":");
		showResponse(resp[0], resp[1], resp[0], "div.message");
		if (resp[0] == "SUCCESS") {
			window.location = "index.php";
		}
	} 	

	var options = { 
        success: handleResponse  // post-submit callback 
    }; 
	$("#login-form").ajaxForm(options);
	
});
</script>
</head>
<body>
<div class="ui-tabs ui-widget ui-widget-content ui-corner-all" id="login-form-container">
	<div class="message"><?php echo $_SESSION['message']; ?></div>
	<form action="index_process.php" method="post" id="login-form">
		<div><label for="username">UserName:</label><input name="username" type="text" id="username"/></div>
		<div><label for="password">Password:</label><input name="password" type="password" /></div>
		<div class="ui-form-button"><input type="submit" value="Submit" /><input type="reset" value="Reset" /></div>
	</form>
</div>
<?php include("footer.php");?>
</body>
</html>