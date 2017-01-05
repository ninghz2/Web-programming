<?php
	# NINGHE ZHANG
	# CSE154
	# HW7
	# SECTION AJ
	#
	# This file logs user out and direct to the start page immediately.
	
	include("common.php");
	checkLogin();
	session_destroy();
	session_regenerate_id(TRUE); 
	directToStart();
?>