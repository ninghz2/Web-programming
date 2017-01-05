<!--
CSE 154
Login page that allows a user to login with their id and password
Shows and error if they have logged in incorrectly. 
-->

<!--
CSE 1454
The top of all of our turin and login pages
-->

<!DOCTYPE html>
<html>
	<head>
		<title>CSE 154 homework Turnin</title>
	</head>
	<body>
<form action="login-submit.php" method="post">
			<div>There was an error logging in. Please try again</div>
		
	<fieldset>
		<legend>Login form</legend>

		<div>
			Student id: <input type="text" name="id" maxlength="7" />
		</div>

		<div>
			Password: <input type="password" name="password" />
		</div>
		<div>
			<input type="submit" value="login" />
		</div>
	</fieldset>
</form>

</body>
</html>