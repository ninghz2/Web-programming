<?php
	# NINGHE ZHANG
	# CSE154
	# HW7
	# SECTION AJ
	#
	# This file stors functions that are shared by multiple other files.

	# display the top blue bars of the page
	function banner() {
	?>
		<!DOCTYPE html>
		<html>
			<head>
				<meta charset="utf-8" />
				<title>Remember the Cow</title>
				<link href="https://webster.cs.washington.edu/css/cow-provided.css" type="text/css" rel="stylesheet" />
				<link href="cow.css" type="text/css" rel="stylesheet" />
				<link href="https://webster.cs.washington.edu/images/todolist/favicon.ico" type="image/ico" rel="shortcut icon" />
			</head>
			<body>
				<div class="headfoot">
					<h1>
						<img src="https://webster.cs.washington.edu/images/todolist/logo.gif" alt="logo" />
						Remember<br />the Cow
					</h1>
				</div>
	<?php
	}

	# display te bottom blue bar of the page
	function footer() {
	?>
				<div class="headfoot">
					<p>
						<q>Remember The Cow is nice, but it's a total copy of another site.</q> - PCWorld<br />
						All pages and content &copy; Copyright CowPie Inc.
					</p>

					<div id="w3c">
						<a href="https://webster.cs.washington.edu/validate-html.php">
							<img src="https://webster.cs.washington.edu/images/w3c-html.png" alt="Valid HTML" /></a>
						<a href="https://webster.cs.washington.edu/validate-css.php">
							<img src="https://webster.cs.washington.edu/images/w3c-css.png" alt="Valid CSS" /></a>
					</div>
				</div>
			</body>
		</html>
	<?php
	}

	# check if the user is already logged in, direct them to thier to-do list
	function directTodolist() {
		session_start();
		if (isset($_SESSION["name"])) {
			header("Location: todolist.php");
			die();
		}
	}

	# direct user to start page
	function directToStart() {
		header("Location: start.php");
		die();
	}

	# check if the user is not logged in, direct them to start page
	function checkLogin() {
		session_start();
		if (!isset($_SESSION["name"])) {
			directToStart();
		}
	}
?>