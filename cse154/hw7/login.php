<?php
	# NINGHE ZHANG
	# CSE154
	# HW7
	# SECTION AJ
	#
	# This file accepts the user name and password from start.php, and redirects
	# user to another page. If the user login successful, direct to todolist page.
	# if login failed, direct to start page. If the parameters are not passed in 
	# appropriately, display an error message.

	include("common.php");
	// if user already logged in, redirect to the todolist
	directTodolist();
	// parameters correctly passed in
	if (isset($_POST["name"]) && isset($_POST["password"])
		&& $_POST["name"] != "" && $_POST["password"] != "") {
		$currName = $_POST["name"];
		$currPassword = $_POST["password"];
		$lines = file("users.txt", FILE_IGNORE_NEW_LINES);
		// checks if has the user name recorded, and to see if password matches
		foreach($lines as $line) {
			list($tempName, $tempPass) = explode(":", $line, 2);
			if ($tempName == $currName) {
				if ($tempPass != $currPassword) {  // has the user but wrong password
					directToStart();
				} else {  // login success
					goToList($currName);
				}
			}
		}
		// create the user and password, if passes validation, store them
		// and direct to todolist. otherwise, back to start page. 
		if (preg_match("/^[a-z]([a-z]|[0-9]){2,7}$/", $currName) 
			&& preg_match("/^[0-9].{4,10}\W$/", $currPassword)) {
			$added = $currName . ":" . $currPassword . "\n";
			file_put_contents("users.txt", $added, FILE_APPEND);
			goToList($currName);
		} else {
			directToStart();
		}	
	} else {
		die("Please enter your name and password to log in :)");
	}

	// store the current login time and the login status, direct user to
	// todolist page.
	function goToList($currName) {
		setcookie("time", date("D y M d, g:i:s a"), time() + 7 * 24 * 60 * 60);
		session_start();
		$_SESSION["name"] = $currName;
		header("Location: todolist.php");
		die();
	}
?>