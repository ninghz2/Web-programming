"use strict";
window.onload = function() {
	var button = document.getElementById("validate");
	button.onclick = check;
}

function check() {
	var list = document.querySelectorAll("input");
	for (var i = 0 ; i < list.length; i++) {
		if (list[i].value == "") {
			list[i].style.backgroundColor = "red";
		} else {
			list[i].style.backgroundColor = "";
		}
	}
}
