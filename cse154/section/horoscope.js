// CSE 154 Ajax section pre-problem
// You should complete this file.
// Your code must be run on the Webster server (not on your local computer).

window.onload = function() {
	document.getElementById("go").onclick = goClick;
};

function goClick() {
	// write your solution here!
	// Your code needs to connect to: https://webster.cs.washington.edu/cse154/sections/9/horoscope-server.php
	var request = new XMLHttpRequest();
	request.onload = display;
	var month = document.getElementById("month").value;
	var day = document.getElementById("day").value;
	request.open("GET", "https://webster.cs.washington.edu/cse154/sections/9/horoscope/horoscope-server.php?month=" + month + "&day=" + day, true);
	request.send();
}

function display() {
	document.getElementById("results").innerHTML = this.responseText;
}
