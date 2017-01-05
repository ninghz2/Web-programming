<?php
	# NINGHE ZHANG
	# CSE154
	# HW7
	# SECTION AJ
	#
	# This file modifies the user's to-do text file appropriately 
	# and then immediately redirect back to to-do list page.

	include("common.php");
	checkLogin();
	$fname = "todo_" . $_SESSION["name"] . ".txt";
	# add the new item into the end of the file
	if (isset($_POST["action"]) && $_POST["action"] == "add" && isset($_POST["item"])) {
		file_put_contents($fname, $_POST["item"] . "\n", FILE_APPEND);
	} else if (isset($_POST["action"]) && $_POST["action"] == "delete" && isset($_POST["index"])) {
		$index = $_POST["index"];
		$lines = file($fname);
		# check if the index passed in is appropriate
		if ($index < 0 || $index >= count($lines) || !preg_match("/^[0-9]{1,}$/", $index)) {
			die("Your index is not valid. Please select again.");
		}
		#delete the item from the file
		unset($lines[$index]);
		file_put_contents($fname, $lines);
	} else {
		die("Your are missing required parameter.");
	}
	header("Location: todolist.php");
?>