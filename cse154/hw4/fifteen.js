// NINGHE ZHANG
// CSE154
// This is the file contains multiple function implementations used by fifteen puzzels
// game, which can create fifteen tiles, shuffle the tiles and moving the tiles to play
// with.
// Extra feature #1 : see the function testWin

(function() {
	"use strict";
	var emptyLeft = 3;  // column number for the empty sqaure
	var emptyTop = 3;  // row number for the empty square

	// initializing the page by creating squares and attach event handles
	// to shuffle button
	window.onload = function() { 	
	    createSquare();
	    var shuffle = document.getElementById("shufflebutton");
	    shuffle.onclick = shuffleGame;
	};

	// creating 15 squares in order, attaching event handlers to each of them
	function createSquare() {
		for (var i = 1; i <= 15; i++) {
			var tile = document.createElement("div");
			tile.innerHTML = i;
			tile.classList.add("tiles");
			var x = (i - 1) % 4;
			var y;
			if (i % 4 == 0) {
				y = i / 4 - 1;
			} else {
				y = Math.floor(i / 4);
			} 
			tile.id = "square_" + y + "_" + x; 
			x = x * (-100);
			y = y * (-100);
			tile.style.backgroundPosition = x + "px " + y + "px";
			tile.style.left = (-1) * x + "px";
			tile.style.top = (-1) * y + "px";
	        // attach event handlers for each tile
	        tile.onclick = move;
	        tile.onmousemove = changeColor;
	        tile.onmouseout = setBack;
			document.getElementById("puzzlearea").appendChild(tile);
		}
	}

	// get a list of all movable squares and return it 
	function getNeighbors() {
		var neighbor = [];
		var up = document.getElementById("square_" + (emptyTop - 1) + "_" + emptyLeft);
		var down = document.getElementById("square_" + (emptyTop + 1) + "_" + emptyLeft);
		var left = document.getElementById("square_" + emptyTop + "_" + (emptyLeft - 1));
		var right = document.getElementById("square_" + emptyTop + "_" + (emptyLeft + 1));
		if (up) {
			neighbor.push(up);
		}
		if (down) {
			neighbor.push(down);
		}
		if (left) {
			neighbor.push(left);
		}
		if (right) {
			neighbor.push(right);
		}
		return neighbor;
	}

	// check whether a passed in sqaure is the neighbor of the empty square
	// can be moved or not
	function isNeighbor(tile) {
		var canMove = getNeighbors();
		for (var i = 0; i < canMove.length; i++) {
			if (canMove[i] == tile) {
				return true;
			}
		}
		return false;
	}

	// if the sqaure can be moved, trigger the function to move this square
	function move() {
		if (isNeighbor(this)) {
			moveToEmpty(this);
			testWin();
		}
		
	}

	// moving the passed in sqaure to the empty position
	function moveToEmpty(tile) {	
		var thisLeft = parseInt(window.getComputedStyle(tile).left);
		var thisTop = parseInt(window.getComputedStyle(tile).top);
		tile.style.left = 100 * emptyLeft + "px";
		tile.style.top = 100 * emptyTop + "px";
		tile.id = "square_" + emptyTop + "_" + emptyLeft;
		emptyLeft = thisLeft / 100;
		emptyTop = thisTop / 100;
	}

	// change the style of movable square when user hovers on it
	function changeColor() {
		if (isNeighbor(this)) {
			this.classList.add("hover");
		}
	}

	// set the style of movable square to original when user hovers out of it 
	function setBack() {
		this.classList.remove("hover");
	}

	// shuffling the position of all the tiles to a random position
	function shuffleGame() {
		for (var i = 0; i < 1000; i++) {
			var neighbors = getNeighbors();
			var randomNum = parseInt(Math.random() * neighbors.length);
			var target = neighbors[randomNum];
			moveToEmpty(target);
		}
		testWin();
	}

	// testing if the user has won the game or not. A winning message will pop up 
	// if the user win the game.
	function testWin() {
		var order = 1;
		var result = true;
		for (var i = 0; i < 4; i++) {
			for (var j = 0; j < 4; j++) {
				var block = document.getElementById("square_" + i + "_" + j);
				if (block) {
					var number = parseInt(block.innerHTML);
					if (number != order) {
						result = false;
					}
				}
				order++;
			}
		}
		if (result) {
			document.getElementById("output").innerHTML = "Congratulations! You Win!";
		} else {
			document.getElementById("output").innerHTML = "";
		}
	}

}());