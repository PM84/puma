<!DOCTYPE html>
<meta charset="utf-8">
<script src="d3.v3.min.js"></script>
<script src="d3.layout.cloud.js"></script>
<script src="removeStopWords.js"></script>
<script src="underscore-min.js"></script>
<body>
	<div id="word_cloud"></div>

	<script>

		//Simple animated example of d3-cloud - https://github.com/jasondavies/d3-cloud
		//Based on https://github.com/jasondavies/d3-cloud/blob/master/examples/simple.html
		//& http://bl.ocks.org/jwhitfieldseed/9697914 for the animation
		//Remove Stopwords by GeekLad http://geeklad.com

		//List of projects. The first word must be the name of the project.
		var projects = [
			"Moves platform Schultz + Grassov is a landscape architect company based primarily in Copenhagen, but with international projects. The first project I was involved in with them was in DTU (Copenhagen, DK), then in WUSTL (Saint Louis, US).  I built a platform to monitor volunteers’ movements for a short period of time. The platform collects two types of data: the tracks, places and activities from Moves, but also data related to the volunteers’ demographics or commuting habits. GPS GPS  GPS  The  app is a smartphone application recording the location of the phone at regular intervals. It creates two types of geographic data: a track, which is the route followed by users, and a GPS GPS GPS GPS  GPS  GPS list of places, where the users has stayed during a significant amount of time. It also classify movements in terms of transport: walking, cycling, running and transport (=unclassified).  Positioning  The position is derived from the location through a GPS signal, 3G, or wi-fi. Its accuracy and precision depends on the phones, and no settings can modify the intervals at which the position is taken. From experience, iPhones record the location more frequently than Android phones. The only way to improve the quality of the records is to have as many sensors as possible on.  GPS  GPS signal is the most accurate outdoor, but requires to receive the signal from at least 3 satellites, and the precision of the position will depend on the number of satellites as well as the absence of cover (e.g. tall buildings, and cloud or forest covers can divert a GPS signal).  GPS This means that for a  app user with GPS location enabled, the quality of the location of the phone will depend on the surroundings. Typically, we’ve experienced that the users’ tracks can ‘cross’ buildings – therefore the quality of the tracks is stronger in open areas, but the bigger picture is considered as reliable for urban environments.  Network  3G and wi-fi signals can also help locating users; especially indoors where the GPS cannot reach the phones. Therefore keeping wi-fi and/or 3G in urban areas can significantly improve the location accuracy.  Communicating with Moves  The Moves API is a service from Moves to connect users with 3rd party applications, giving access to tracks, places, and activity types to 3rd parties approved by the user. These 3rd parties are called ‘Connected apps’, and Mobility Pal is one of them, albeit not a public app, and therefore is not in the available from the official connected apps in .     Strength of   The  is unique for multiple reasons:  It does not calculate the tracks and places in the phone, but sends the positions recorded during the day to the Moves servers at periodic intervals (when opening the application, or about once a day when the phone has a data connection – wi-fi or 3G). This means that battery usage is much lower than most applications offering this type of services.  creates two types of geographic datasets: tracks and places. It ‘guesses’ the type of transport based on the speed. It also links the places to foursquare places (if existing) It has an API, which means that for a programmer, it is possible to access tracks and places with the users’ permission."
		]

		// First, remove the stopwords from the text
		var cleanwords = [];
		for(var j=0; j < projects.length; j++) {
			cleanwords[j] = removeStopWords(projects[j].replace(/[!\.,:;\?\']/g, ''));
		}

		// Then, select the 20 most frequent words
		function getwords(i) {
			var wordSize = 50;
			var list = cleanwords[i].split(' ');
			result = { };
			for(i = 0; i < list.length; ++i) {
				if(!result[list[i]])
					result[list[i]] = 0;
				++result[list[i]];
			}
			var newList = _.uniq(list);
			var frequency_list = [];
			for (var i = 0; i < newList.length; i++) {

				var temp = newList[i];
				frequency_list.push({
					text : temp,
					freq : result[newList[i]],
					title: list[0]
				});
			}
			frequency_list.sort(function(a,b) { return parseFloat(b.freq) - parseFloat(a.freq) } );  


			for(i in frequency_list){
				if(frequency_list[i].freq*wordSize > 160)   
					wordSize = 3;
			}

			frequency_list = frequency_list.slice(1,20);

			return frequency_list;
		}

		// Redraw the cloud with a new set of words.
		function newproject(vis, i) {
			i = i || 0;
			vis.update(getwords(i ++ % cleanwords.length));
			// 			setTimeout(function() { newproject(vis, i + 1)}, 5000);
		}

		//Reset the word cloud visualisation.
		var wordcloud = makewordcloud('#word_cloud');

		//Start cycling through the projects
		newproject(wordcloud);


		function makewordcloud(selector) {
			var w = 500;
			var h = 500;
			var fill = d3.scale.category20();

			// Create word cloud svg
			var svg = d3.select(selector).append("svg")
			.attr("width", w)
			.attr("height", h)
			.append("g")
			.attr("transform", "translate(250,250)");

			// Draw the word cloud
			function draw(projects) {
				// Load the text
				var cloud = svg.selectAll("g text")
				.data(projects, function(d) {return d.text; })

// 				Create a scale based on the frequency words appear (variable in the data)
				var sizeScale = d3.scale.linear()
				.domain([0, d3.max(projects, function(d) { return d.freq} )])
				.range([10, 95]); 

				/* 				var margin = {top: 40.5, right: 40.5, bottom: 50.5, left: 60.5},
					width = 960 - margin.left - margin.right,
					height = 500 - margin.top - margin.bottom;

				var sizeScale = d3.scale.log()
				.base(10)
				.domain([Math.exp(0), Math.exp(9)])
				.range([15,150]);
 */
				// Enter and style each word
				cloud.enter()
					.append("text")
					.style("font-family", "Impact")
					.style("fill", function(d, i) { return fill(i); })
					.attr("text-anchor", "middle")
					.attr('font-size', 1)
					.text(function(d) { return d.text; });

				// Transitions between each drawing
				cloud.transition()
					.duration(600)
					.style("font-size", function(d) { return sizeScale(d.freq) + "px"; })
					.attr("transform", function(d) {
					return "translate(" + [d.x, d.y] + ")rotate(" + d.rotate + ")";
				})
					.style("fill-opacity", 1);

				// Exit the words by slowly reducing
				cloud.exit()
					.transition()
					.duration(200)
					.style('fill-opacity', 1e-6)
					.attr('font-size', 1)
					.remove();
			}
			// Udate the words to be shown
			return {
				update: function(frequency_list) {
					var sizeScale = d3.scale.linear()
					.domain([0, d3.max(frequency_list, function(d) { return d.freq} )])
					.range([10, 95]);
					//Update the title of the project               
					// 					document.getElementById('title').innerHTML = frequency_list[0].title;

					d3.layout.cloud().size([w, h])
						.words(frequency_list)
						.padding(5)
						.rotate(function() { return ~~(Math.random() * 2) * 90; })
						.font("Impact")
						.fontSize(function(d) { return sizeScale(d.freq); })
						.on("end",draw)
						.start();
				}
			}
		}//makewordcloud

	</script>