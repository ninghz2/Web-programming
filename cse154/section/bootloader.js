"use strict";
window.onload = function () {
	document.getElementById("load").onclick = loading;
}

function loading() {
	var ajax = new XMLHttpRequest();
	ajax.onload = display;
	ajax.open("GET", "https://webster.cs.washington.edu/cse154/sections/9/bootloader/loader.php", true);
	ajax.send();
}

function display() {
	document.getElementById("boot").innerHTML = "";
	var img = document.createElement("img");
	img.src = this.responseText;
	document.getElementById("boot").appendChild(img);
}