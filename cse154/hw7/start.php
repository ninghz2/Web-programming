<?php
	# NINGHE ZHANG
	# CSE154
	# HW7
	# SECTION AJ
	#
	# This is the initial page describing the site with a form for the user to
	# log in or register. Direct already logged in user to their todolist, 
	# and create an account to new user.

	include("common.php");
	// direct to todolist if the user already logged in
	directTodolist();
	banner();
?>

<div id="main">
	<p>
		The best way to manage your tasks. <br />
		Never forget the cow (or anything else) again!
	</p>

	<p>
		Log in now to manage your to-do list. <br />
		If you do not have an account, one will be created for you.
	</p>

	<form id="loginform" action="login.php" method="post">
		<div><input name="name" type="text" size="8" autofocus="autofocus" /> <strong>User Name</strong></div>
		<div><input name="password" type="password" size="8" /> <strong>Password</strong></div>
		<div><input type="submit" value="Log in" /></div>
	</form>
	<?php
		# if exists record for last time log in, display it
		if (isset($_COOKIE["time"])) {
		?>
			<p>
				<em>(last login from this computer was <?=$_COOKIE["time"] ?>)</em>
			</p>
		<?php
		}
	?>
</div>

<?php
	footer();
?>
	