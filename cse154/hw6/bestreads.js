// CSE 154
// NINGHE ZHANG
// This is the javascript file for the bestreads website. It handles the events on the page
// and making request to display the requested information of the book.

(function() {
	"use strict";

	// loading all of the books and attach the event handler to the back button
	window.onload = function() {
		document.getElementById("singlebook").style.display = "none";
		loadBooks();
		document.getElementById("back").onclick = loadBooks;
	};

	// given the mode and event funtion name, making the request to get 
	// corresponding data
	function ajaxRequest(mode, func) {
		var request = new XMLHttpRequest();
		request.onload = func;
		request.open("GET", "bestreads.php?" + mode, true);
		request.send();
	}

	// request the cover and title of all the books and display them
	function loadBooks() {
		document.getElementById("allbooks").innerHTML = "";
		document.getElementById("singlebook").style.display = "none";
		ajaxRequest("mode=books", displayBooks);
	}

	// create the page for display all the books, 
	// attach the event handles to the cover and title
	function displayBooks() {
		var response = this.responseXML;
		var bookList = response.querySelectorAll("book");
		for (var i = 0; i < bookList.length; i++) {
			var div = document.createElement("div");
			var paragraph = document.createElement("p");
			var img = document.createElement("img");
			var folder = bookList[i].querySelector("folder").textContent;
			img.src = "books/" + folder + "/cover.jpg";
			img.alt = folder;
			img.setAttribute("folder", folder);
			img.onclick = displaySingle;
			paragraph.innerHTML = bookList[i].querySelector("title").textContent;
			paragraph.setAttribute("folder", folder);
			paragraph.onclick = displaySingle;
			div.appendChild(img);
			div.appendChild(paragraph);
			document.getElementById("allbooks").appendChild(div);
		}
	}

	// create the page for display the single book, including its infomation, 
	// descritption, and reader reviews
	function displaySingle() {
		document.getElementById("singlebook").style.display = "block";
		document.getElementById("allbooks").innerHTML = "";
		var folder = this.getAttribute("folder");
		document.getElementById("cover").src = "books/" + folder + "/cover.jpg";
		ajaxRequest("mode=info&title=" + folder, displayInfo);
		ajaxRequest("mode=description&title=" + folder, displayDescription);
		ajaxRequest("mode=reviews&title=" + folder, displayReview);
	}

	// display the informatin of the requested book
	function displayInfo() {
		var response = JSON.parse(this.responseText);
		document.getElementById("title").innerHTML = response.title;
		document.getElementById("author").innerHTML = response.author;
		document.getElementById("stars").innerHTML = response.stars;
	}

	// display the description of the requested book
	function displayDescription() {
		document.getElementById("description").innerHTML = this.responseText;
	}

	// display the reviews of the requested book
	function displayReview() {
		document.getElementById("reviews").innerHTML = this.responseText;
	}

})();