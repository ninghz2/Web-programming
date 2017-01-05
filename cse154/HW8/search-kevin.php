<?php
	# NINGHE ZHANG
	# CSE154
	# HW8
	# SECTION AJ
	#
	# This page showing search results for all films with the given actor and kevin bacon. 

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
			// get the kevin bacon's id and the searched actor's id
			$kevin_bacon_id = get_actor_id($db, "kevin", "bacon");

			// search the movies they both acted in 
			$rows = $db->query("SELECT m.name, m.year
								FROM movies m
								JOIN roles r1 ON m.id = r1.movie_id
								JOIN roles r2 ON m.id = r2.movie_id
								WHERE r1.actor_id = {$kevin_bacon_id} AND r2.actor_id = {$actor_id}
								ORDER BY m.year desc, m.name;");
			// if the result is empty, printing message showing they didn't act in any film together
			if ($rows->rowCount() == 0) {
			?>
				<p><?=$firstname_input . " " . $lastname_input?> wasn't in any films with Kevin Bacon.</p>
				<?php
				form_and_footer();
				die();
			}
			?>
			<h1>Results for <?=$firstname_input . " " . $lastname_input?></h1>
			<table>
				<caption>Films with <?=$firstname_input . " " . $lastname_input?> and Kevin Bacon</caption>
				<tr><th>#</th><th>Title</th><th>Year</th></tr>
			<?php	
			print_table_content($rows);
		}
		form_and_footer();
	} catch (PDOException $ex) {
		error_message($ex);
	}
	
?>
