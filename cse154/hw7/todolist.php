<?php
	# NINGHE ZHANG
	# CSE154
	# HW7
	# SECTION AJ
	#
	# This page display user's to-do list and allows user to add/delete
	# from it.

	include("common.php");
	checkLogin();
	$username = $_SESSION["name"];
	banner();
?>

<div id="main">
	<h2><?=$username ?>'s To-Do List</h2>

	<ul id="todolist">
		<?php
			# check if the file storing the user to-do list exists.
			# if it exists, print out the content
			# otherwise, create a new one
			$fname = "todo_" . $username . ".txt";
			if (file_exists($fname)) {
				$lines = file($fname, FILE_IGNORE_NEW_LINES);
				for ($i = 0; $i < count($lines); $i++) {
				?>
				<li>
					<form action="submit.php" method="post">
						<input type="hidden" name="action" value="delete" />
						<input type="hidden" name="index" value=<?=$i ?> />
						<input type="submit" value="Delete" />
					</form>
					<?=htmlspecialchars($lines[$i]) ?>
				</li>
				<?php
				}
			}			
		?>

		<li>
			<form action="submit.php" method="post">
				<input type="hidden" name="action" value="add" />
				<input name="item" type="text" size="25" autofocus="autofocus" />
				<input type="submit" value="Add" />
			</form>
		</li>
	</ul>

	<div>
		<a href="logout.php"><strong>Log Out</strong></a>
		<em>(logged in since <?=$_COOKIE["time"] ?>)</em>
	</div>

</div>

<?php
	footer();
?>
