<?php
include_once($_SERVER['DOCUMENT_ROOT']."/module/mod_bausteine/php/wordcloud.php");
$WC_name="WordCloud_".$Block;
$jsonWort=html_entity_decode (get_WC_WortArray($_SESSION['fID'],$WC_name), ENT_QUOTES , "UTF-8");


?>

<script src="/plugins/d3Cloud/d3.v3.min.js"></script>
<script src="/plugins/d3Cloud/d3.layout.cloud.js"></script>
<script src="/plugins/d3Cloud/removeStopWords.js"></script>
<script src="/plugins/d3Cloud/underscore-min.js"></script>
<div id="word_cloud"></div>

<script>

	//Simple animated example of d3-cloud - https://github.com/jasondavies/d3-cloud
	//Based on https://github.com/jasondavies/d3-cloud/blob/master/examples/simple.html
	//& http://bl.ocks.org/jwhitfieldseed/9697914 for the animation
	//Remove Stopwords by GeekLad http://geeklad.com


	var words=<?php echo $jsonWort;?>

	// First, remove the stopwords from the text
	var cleanwords = [];
	for(var j=0; j < words.length; j++) {
		cleanwords[j] = removeStopWords(words[j].replace(/[!\.,:;\?\']/g, ''));
	}

/* 	for(var i = 0; i < json.length; i++) {
		var obj = json[i];

		console.log(obj.id);
	} */

	// Then, select the 20 most frequent words
	function getwords(i) {
		var wordSize = 1000;
// 		var list = cleanwords[i].split(' ');
		var list = cleanwords;
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

		console.log(frequency_list);

/* 		for(i in frequency_list){
			if(frequency_list[i].freq*wordSize > 160)   
				wordSize = 1;
		}
 */
// 		frequency_list = frequency_list.slice(1,20);

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

	//Start cycling through the words
	newproject(wordcloud);


	function makewordcloud(selector) {
		var w = 600;
		var h = 500;
		var fill = d3.scale.category20();

		// Create word cloud svg
		var svg = d3.select(selector).append("svg")
		.attr("width", w)
		.attr("height", h)
		.append("g")
		.attr("transform", "translate(250,250)");

		// Draw the word cloud
		function draw(words) {
			// Load the text
			var cloud = svg.selectAll("g text").data(words, function(d) {return d.text; })

			// Create a scale based on the frequency words appear (variable in the data)

			var sizeScale = d3.scale.linear()
			.domain([0, d3.max(words, function(d) { return d.freq} )])
			.range([10, 50]); 

/* 							var margin = {top: 40.5, right: 40.5, bottom: 50.5, left: 60.5},
					width = 960 - margin.left - margin.right,
					height = 500 - margin.top - margin.bottom;

				var sizeScale = d3.scale.log()
				.base(10)
				.domain([Math.exp(0), Math.exp(9)])
				.range([15,150]); */

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
	}

</script>