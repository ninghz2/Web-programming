<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		 <title>kitties</title>
	</head>
	<body>
		<div>
			<?php
				$animal = "";
				if (isset($_GET[$animal])) {
					$animal = $_GET[$animal];
				}
				$images = glob("images/{$animal}*.jpeg");
			?>
			<img src="images/kitty1.jpeg" alt="a picture" />
				<img src="images/kitty2.jpeg" alt="a picture" />
				<img src="images/kitty3.jpeg" alt="a picture" />
				<img src="images/kitty4.jpeg" alt="a picture" />
				<img src="images/kitty5.jpeg" alt="a picture" />
				<img src="images/pony1.jpeg" alt="a picture" />
				<img src="images/pony2.jpeg" alt="a picture" />
				<img src="images/pony3.jpeg" alt="a picture" />
				<img src="images/puppy1.jpeg" alt="a picture" />
				<img src="images/puppy2.jpeg" alt="a picture" />
				<img src="images/puppy3.jpeg" alt="a picture" />
				<img src="images/puppy4.jpeg" alt="a picture" />
				<img src="images/puppy5.jpeg" alt="a picture" />
			</div>
	</body>
</html>