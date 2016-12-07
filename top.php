<div class="top">
	<div class="userinfo">
		<p>Welcome <?php echo $_SESSION['first_name']."&nbsp;".$_SESSION['last_name']."&nbsp;[".$_SESSION['username']."]"?></p>
	</div>
	<div class="logout ui-form-button"><a href="logout.php">Logout</a></div>
	<div style="clear: both;"></div>
    <div id="response-message" style="display: none;"></div>
</div>