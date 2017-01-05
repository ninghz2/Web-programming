// NINGHE ZHANG
// CSE154
// ASSIGNMENT 3
// This is a speedReader animation for speed reading.

(function() {	
	"use strict";
	var index = 0;
	var time = null;
	var twice = 0;
	var currSpeed = 171;
    var startAni = false; //indicator whether the animation is in progress

	window.onload = function () {
		document.getElementById("stop").disabled = true;
		var start = document.getElementById("start");
		start.onclick = timer;
		var font = document.getElementById("font");
		font.onchange = changeFont;
		var stop = document.getElementById("stop");
		stop.onclick = pause;
		var speed = document.getElementById("speed");
		speed.onchange= changeSpeed;
	};
	//set timer
	function timer() {
		if (!time) {
			time = setInterval(read, currSpeed);
			startAni = true;
		}
	}
	//start the reading mode 
	function read() {
		document.getElementById("stop").disabled = false;
		document.getElementById("start").disabled = true;
		document.getElementById("input").disabled = true;
		var textBox = document.getElementById("input").value;
		var textArray = textBox.split(/[ \t\n]+/);
		var displayBox = document.getElementById("display");
		if(index < textArray.length) {
			var word = textArray[index];
			var lastC = word.charAt(word.length -1);
			//remove the last piece of punctuation
			if((lastC === ',')||(lastC === '.')||(lastC === '!')||(lastC === '?')||(lastC === ';')||(lastC ===':')) {
				word = word.substring(0, word.length - 1);
				//if this is the first time displaying this word, make index still pointing at this word next time
				//in order to show it twice
				if(twice == 0) {
					index--;
					twice = 1;
				} else { // the word alread be shown twice, set flag to false
					twice = 0;
				}
			}
			index++;
			displayBox.innerHTML = word;	
		} else {
			pause();
		}
	}
	//change the font 
	function changeFont() {
		var displayBox = document.getElementById("display");
		if (document.getElementById("medium").checked) {
			displayBox.style.fontSize = "36pt";
		} else if (document.getElementById("big").checked) {
			displayBox.style.fontSize = "48pt";
		} else {
			displayBox.style.fontSize = "60pt";
		} 
	}
	//stop animation
	function pause() {
		document.getElementById("start").disabled = false;
		document.getElementById("stop").disabled = true;
		document.getElementById("input").disabled = false;
		document.getElementById("display").innerHTML = "";
		clearInterval(time);
		time = null;
		startAni = false;
	}
	//change the speed of reader
	function changeSpeed() {
		currSpeed = parseInt(document.getElementById("speed").value);
		clearInterval(time);
		time = null;
		//only reset the timer and continue animation when the animation already started
		if(startAni) {
			timer();
		}
	}
}());	
