<?php
	# NINGHE ZHANG
	# CSE154
	# HW8
	# SECTION AJ
	#
	# This page showing search results for all films by a given actor. 

	include("common.php");
	banner();
	# check if the actor's first and last name are passed in
	check_parameters();
		
	$firstname_input = htmlspecialchars($_GET['firstname']);
	$lastname_input = htmlspecialchars($_GET['lastname']);
	try {
		$db = setup_db();
		// check if the database has this actor
		$actor_id = get_actor_id($db, $firstname_input, $lastname_input);
		if ($actor_id == NULL) {
			?>
			<p>Actor <?=$firstname_input . " " . $lastname_input?> not found</p>
		<?php
		} else { 
		?>

			<h1>Results for <?=$firstname_input . " " . $lastname_input?></h1>
			<table>
				<caption>All Films</caption>
				<tr><th>#</th><th>Title</th><th>Year</th></tr>
			<?php

			// search for all the movies and corresponding years the actor acts in
			$rows = $db->query("SELECT m.name, m.year
							FROM movies m
							JOIN roles r ON m.id = r.movie_id
							JOIN actors a ON r.actor_id = a.id
							WHERE a.id = {$actor_id}
							ORDER BY m.year desc, m.name;");

			print_table_content($rows);
		}
		form_and_footer();
	} catch (PDOException $ex) {
		error_message($ex);
	}
?>
