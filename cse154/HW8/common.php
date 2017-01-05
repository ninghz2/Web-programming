<?php
	# NINGHE ZHANG
	# CSE154
	# HW8
	# SECTION AJ
	#
	# This file contains functions that used by multiple php files.

	# display the banner for the page
	function banner() {
	?>
		<!DOCTYPE html>
			<html> 
				<head>
					<title>My Movie Database (MyMDb)</title>
					<meta charset="utf-8" />
					<link href="https://webster.cs.washington.edu/images/kevinbacon/favicon.png" type="image/png" rel="shortcut icon" />

					<!-- Link to your CSS file that you should edit -->
					<link href="bacon.css" type="text/css" rel="stylesheet" />
				</head>

				<body>
					<div id="frame">
						<div id="banner">
							<a href="mymdb.php"><img src="https://webster.cs.washington.edu/images/kevinbacon/mymdb.png" alt="banner logo" /></a>
							My Movie Database
						</div>
					<div id="main">
	<?php
	}

	# display the two searching areas and footer for the page
	function form_and_footer() {
	?>
				<!-- form to search for every movie by a given actor -->
				<form action="search-all.php" method="get">
					<fieldset>
						<legend>All movies</legend>
						<div>
							<input name="firstname" type="text" size="12" placeholder="first name" autofocus="autofocus" /> 
							<input name="lastname" type="text" size="12" placeholder="last name" /> 
							<input type="submit" value="go" />
						</div>
					</fieldset>
				</form>
				<!-- form to search for movies where a given actor was with Kevin Bacon -->
						<form action="search-kevin.php" method="get">
							<fieldset>
								<legend>Movies with Kevin Bacon</legend>
								<div>
									<input name="firstname" type="text" size="12" placeholder="first name" /> 
									<input name="lastname" type="text" size="12" placeholder="last name" /> 
									<input type="submit" value="go" />
								</div>
							</fieldset>
						</form>
					</div> <!-- end of #main div -->
				
					<div id="w3c">
						<a href="https://webster.cs.washington.edu/validate-html.php"><img src="https://webster.cs.washington.edu/images/w3c-html.png" alt="Valid HTML5" /></a>
						<a href="https://webster.cs.washington.edu/validate-css.php"><img src="https://webster.cs.washington.edu/images/w3c-css.png" alt="Valid CSS" /></a>
					</div>
				</div> <!-- end of #frame div -->
			</body>
		</html>
	<?php
	}

	# check if the first and last name of the actor has been appropriately passed in
	function check_parameters() {
		if (!isset($_GET['firstname']) || !isset($_GET['lastname']) ||
		$_GET['firstname'] == "" || $_GET['lastname'] == "") {
			?>
			<p id="error">Please enter first and last name of the actor to begin search !</p>
			<?php
			form_and_footer();
			die();
		}
	}

	# get the id of the actor the user wants to search in database.
	# if the several actors have the same name, select the one whose last name
	# exactly matches user input, or acts in more moives, breaking ties by lower-numbered ID.
	function get_actor_id($db, $firstname_input, $lastname_input) {
		// get rid of bad injections
		$firstname = $db->quote($firstname_input . "%");
		$lastname = $db->quote($lastname_input);
		// search for best matched actor's ID in the database
		$actorID = $db->query("SELECT id
								FROM actors
								WHERE last_name = {$lastname} AND first_name LIKE {$firstname}
								ORDER BY film_count desc, id
								LIMIT 1;");
		if ($actorID -> rowCount() == 0) {
			return NULL;
		} else {
			$actor_id = $actorID -> fetch();
			return $actor_id["id"];
		}
	}

	# print the contents of the table
	function print_table_content($rows) {
		$order = 1;
		foreach ($rows as $row) {
		?>
			<tr><td><?=$order?></td><td><?=$row["name"]?></td><td><?=$row["year"]?></td></tr>
			<?php
			$order++;
		}
		?>
		</table>
		<?php
	}

	# connect to the database
	function setup_db() {
		$db = new PDO("mysql:dbname=imdb;host=localhost;charset=utf8", "ninghz2", "5mtiee2Res");
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $db;
	}

	# display error message if an error occurs on database
	function error_message($ex) {
		?>
			<p>Sorry, a database error occurred. Please try again later.</p>
			<p>(Error details: <?= $ex->getMessage() ?>)</p>
		<?php
	}
?>