"use strict";
window.onload = function() {
	document.getElementById("kitties").onclick = change;
	document.getElementById("puppies").onclick = change;
	
};
function change() {
	var ajax = new XMLHttpRequest();
	ajax.onload = display;
	var target;
	if (document.getElementById("kitties").checked) {
		target = "kitty";
	} else {
		target = "puppy";
	}
	ajax.open("GET", "https://webster.cs.washington.edu/cse154/sections/9/pets/ajaxpets.php?animal=" + target, true);
	ajax.send();
}

function display() {
	document.getElementById("pictures").innerHTML = this.responseText;
}