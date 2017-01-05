// NINGHE ZHANG
// CSE 154
// This is the javascript file for the weather.html, which fetches data in the form of XML and JSON,
// and display the weather forecast for the city user searched.

(function (){
	"use strict";

	// when page opens, trigger the events of loading city names, and set event handler
	// for search button 
	window.onload = function() {
		document.getElementById("citiesinput").setAttribute("disabled", true);
		sendRequest("mode=cities", displayCities);
		document.getElementById("search").onclick = search;
	};

	// if request sucess, list the city names in drop down menu for user search
	// otherwise, show the error message
	function displayCities() {
		if (this.status == 200) {
			var list = this.responseText.split("\n");
			for (var i = 0; i < list.length; i++) {
				var option = document.createElement("option");
				option.innerHTML = list[i];
				document.getElementById("cities").appendChild(option);
			}
		} else {  
			document.getElementById("errors").innerHTML = "Error: " + this.status;
		}
		document.getElementById("loadingnames").style.display = "none";
		document.getElementById("citiesinput").removeAttribute("disabled");
	}

	// send two requests, one for fetching whole day temperature data for searched city
	// one for fetching the prediction of the following week temperatures.
	function search() {
		// reset all fields to empty for subsequent searchings
		document.getElementById("nodata").style.display = "none";
		document.getElementById("location").innerHTML = "";
		document.getElementById("currentTemp").innerHTML = "";
		document.getElementById("graph").innerHTML = "";
		document.getElementById("forecast").innerHTML = "";
		document.getElementById("loadinglocation").style.display = "block";
		document.getElementById("loadinggraph").style.display = "block";
		document.getElementById("loadingforecast").style.display = "block";

		// make a request to get the one day temperature info and display it
		document.getElementById("resultsarea").style.display = "block";
		var target = document.getElementById("citiesinput").value;
		target = target.replace(/\s/g, '');  // remove spaces in city names
		sendRequest("mode=oneday&city=" + target, displayInfo);

		// make a request to get the one week temperature info and display it
		sendRequest("mode=week&city=" + target, displayWeek);
	}

	// display the weather information for the searched city, set the event handlers for
	// slider and temp button  
	function displayInfo() {
		if (this.status == 410) {
			document.getElementById("nodata").style.display = "block";
			nodata();
		} else if (this.status == 200) {
			var response = this.responseXML;
			
			showCityInfo(response);

			// store the whole day temperatures, predicted in every three hours 
			var templist = response.querySelectorAll("temperature");
			var slider = document.getElementById("slider");
			slider.value = 0;
			slider.onchange = function() {
				showTemp(this.value, templist);
			};
			document.getElementById("temp").onclick = reappear;

			getPreciptation(response);
			
		} else {  // other error codes besides 410 receives
			nodata();
			document.getElementById("errors").innerHTML = "Error: " + this.status;
		}
	}

	// display the city name, current time, weather description and current temperature
	// for the seached city.
	function showCityInfo(response) {
		// display the name of typed in city
		var name = response.querySelector("name").textContent;
		var nameP = document.createElement("p");
		nameP.innerHTML = name;
		nameP.classList.add("title");
		document.getElementById("location").appendChild(nameP);

		// display the current time
		var dateP = document.createElement("P");
		dateP.innerHTML = Date();
		document.getElementById("location").appendChild(dateP);

		// display weather description
		var weather = response.querySelector("time symbol").getAttribute("description");
		var weatherP = document.createElement("p");
		weatherP.innerHTML = weather;
		document.getElementById("location").appendChild(weatherP);
		document.getElementById("loadinglocation").style.display = "none";

		// display current temperature, first one in the response file
		var temp = response.querySelector("temperature").textContent;
		document.getElementById("currentTemp").innerHTML = Math.round(temp) + "&#8457";
	}

	// getting the preciptation data, draw the graph and attach the event handler for 
	// preciptation button
	function getPreciptation(response) {
		// computed precipitaton data for the table, but hide it initially
		document.getElementById("graph").style.display = "none";
		var precipitaton = response.querySelectorAll("clouds");
		var row = document.getElementById("graph").insertRow(0);
		for (var i = 0; i < precipitaton.length; i++) {
			var cell = parseInt(precipitaton[i].getAttribute("chance"));
			var td = row.insertCell(i);
			var div = document.createElement("div");
			div.style.height = cell + "px";
			div.innerHTML = cell + "%";
			td.appendChild(div);
		}
		document.getElementById("loadinggraph").style.display = "none";
		// show the data until user click the precipitation button
		document.getElementById("precip").onclick = showTable;
	}

	// show the graph for precipitation, hide the slider
	function showTable() {
		document.getElementById("graph").style.display = "table";
		document.getElementById("temps").style.display = "none";
	}

	// change the temperature number that is displayed when move the slider
	function showTemp(value, templist) {
		document.getElementById("currentTemp").innerHTML = Math.round(templist[value / 3].textContent) + 
																		"&#8457";
	}

	// show the slider again when click temperature button after clicking 
	// precipitation button
	function reappear() {
		document.getElementById("temps").style.display = "block";
		document.getElementById("graph").style.display = "none";
	}

	// drawing the table for this week's temperature forecast
	function displayWeek() {
		if (this.status == 200) {
			var reply = JSON.parse(this.responseText);
			var row1 = document.getElementById("forecast").insertRow(0);
			var row2 = document.getElementById("forecast").insertRow(1);
			for (var i = 0; i < reply.weather.length; i++) {
				var cell1 = row1.insertCell(i);
				var img = document.createElement("img");
				img.src = "https://openweathermap.org/img/w/" + reply.weather[i].icon + ".png";
				cell1.appendChild(img);

				var cell2 = row2.insertCell(i);
				cell2.innerHTML = Math.round(reply.weather[i].temperature) + "&#176;" ;
			}
			document.getElementById("loadingforecast").style.display = "none";
		} else if (this.status != 410) {
			nodata();
			document.getElementById("errors").innerHTML = "Error: " + this.status;
		}
	}

	// send the request to fetch data
	function sendRequest(param, func) {
		var request = new XMLHttpRequest();
		request.onload = func;
		request.open("GET", "https://webster.cs.washington.edu/cse154/weather.php?" + param, true);
		request.send();
	}

	// hide the three loading images where there is error happens
	function nodata() {
		document.getElementById("loadinglocation").style.display = "none";
		document.getElementById("loadinggraph").style.display = "none";
		document.getElementById("loadingforecast").style.display = "none";
	}
})();