<?php
	// CSE 154
	// NINGHE ZHANG
	// This is a php file for bestreads website. handling request and display the books info,
	// description and reviews.

	$mode = $_GET["mode"];
	$book = $_GET["title"];
	# if mode is info, display the books info in Json.
	if ($mode == "info") {
		$lines = file("books/$book/info.txt");
		createJson($lines);
	} else if ($mode == "description") {
		# print the descroption in txt to the page
		print(file_get_contents("books/$book/description.txt"));
	} else if ($mode == "reviews") {
		# get all the files in the books directory, and output its reviews in the html
		$files = glob("books/$book/review*.txt");
		foreach ($files as $file) {
			outputHTML($file);
		}
		header("Content-type: text/html");
	} else if ($mode == "books") {
		// scan all the books in the directory, and output its info in XML
		$allBooks = scandir("books");
		$dom = new DOMDocument();
		$books = $dom->createElement("books");
		$dom->appendChild($books);
		for($i = 2; $i < count($allBooks); $i++) {
			$oneBook = $allBooks[$i];
			createXML($oneBook, $books, $dom);
			
		}
		header("Content-type: text/xml");
		print($dom->saveXML());
	}

	# this function parse the information of the book in JSon 
	function createJson($lines) {
		$data = array("title" => $lines[0],
					  "author" => $lines[1],
					  "stars" => $lines[2]);
		header("Content-type: application/json");
		print(json_encode($data));
	}

	# this function parse the needed info of the book in XML
	function createXML($oneBook, $books, $dom) {
		$bookTag = $dom->createElement("book");
		$books->appendChild($bookTag);
		$title = $dom->createElement("title");
		$info = file("books/$oneBook/info.txt", FILE_IGNORE_NEW_LINES);

		$titleText = $dom->createTextNode($info[0]);
		$title->appendChild($titleText);
		$bookTag->appendChild($title);

		$folder = $dom->createElement("folder");
		$folderName = $dom->createTextNode($oneBook);
		$folder->appendChild($folderName);
		$bookTag->appendChild($folder);
	}
?>

<?php
	# this function parse the reviews of book in HTML format
	function outputHTML($file) { 
		$content = file($file);
		?>
		<h3><?=$content[0] ?><span><?=$content[1] ?></span></h3>
		<p><?=$content[2] ?></p>
	<?php
	}
?>