<?php
include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/module/mod_bausteine/php/wordcloud.php");
$WC_name="WordCloud_".$Block;
$jsonWort=html_entity_decode (get_WC_WortArray($_SESSION['fID'],$WC_name), ENT_QUOTES , "UTF-8");
$aktNbr=count(json_decode($jsonWort));

?>

<!--<script src="<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/plugins/d3Cloud/d3.v3.min.js"></script>
<script src="<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/plugins/d3Cloud/d3.layout.cloud.js"></script>
<script src="<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/plugins/d3Cloud/removeStopWords.js"></script>
<script src="<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/plugins/d3Cloud/underscore-min.js"></script>
//-->
<p class="lead">Die am häufigsten genannten Begriffe:</p>
<div style='width:100%;' id="word_cloud_<?php echo $Block;?>"></div>

<script>

	window.setInterval(function(){
		$.post("<?php echo $_SESSION['DOCUMENT_ROOT_DIR']; ?>/module/mod_bausteine/php/wordcloud.php", {
			fkt: "get_numberOfWords", fID:<?php echo $_SESSION['fID']; ?>, aktNbr:<?php echo $aktNbr; ?>,BlockName:'<?php echo $WC_name; ?>' })
			.done(function(data)
				  {
			if(data==1){
				console.log("neue Daten verfügbar: " + data);
				location.reload();
			}
		});
	}, 5000);




	// alert($('#word_cloud').width());
	var container = "svg_<?php echo $Block;?>";

	var w = Math.round($('#word_cloud_<?php echo $Block;?>').width());
	var h =  Math.round(w*0.75);

// 	alert(w);
// 	alert(h);
	if($( window ).width()<400){
		var maxRange=20;
	}else if($( window ).width()<800){
		var maxRange=40;
	}else if($( window ).width()<1200){
		var maxRange=60;
	}else if($( window ).width()>=1200){
		var maxRange=95;
	}

	var list_<?php echo $Block;?>="<?php echo $jsonWort; ?>;

	var wordSize=12;
	var layout;

	generate_<?php echo $Block;?>(list_<?php echo $Block;?>);



	/* 	function filter(oldArr,blacklist){
		oldArr = oldArr.filter( function( el ) {
			return !blacklist.indexOf( el ) < 0;
		} );
	} */


	function generate_<?php echo $Block;?>(list) {

		//Blacklist wird gefiltert!
		var blacklist=["ein","sind"];
		list=list.filter(function(x) { return blacklist.indexOf(x) < 0 });

		// Liste wird verarbeitet
		result = { };
		for(i = 0; i < list.length; ++i) {
			if(!result[list[i]])
				result[list[i]] = 0;
			++result[list[i]];
		}

		var newList = _.uniq(list);



		var frequency_list = [];
		var len = newList.length;
		for (var i = 0; i < len; i++) {

			var temp = newList[i];
			frequency_list.push({
				text : temp,
				freq : result[newList[i]],
				time : 0 
			});

		}
		frequency_list.sort(function(a,b) { return parseFloat(b.freq) - parseFloat(a.freq) } );  


		for(var t = 0 ; t < len ; t++)
		{
			var addTime = (100 * t) +500;
			frequency_list[t].time=addTime;
		}


		for(i in frequency_list){
			if(frequency_list[i].freq*wordSize > 160)	
				wordSize = 3;
		}


		var sizeScale = d3.scale.linear().domain([0, d3.max(frequency_list, function(d) { return d.freq} )]).range([5, maxRange]);
		// 		var sizeScale = d3.scale.linear().domain([0, d3.max(frequency_list, function(d) { return d.freq} )]).range([10, 80]);
		// 95 because 100 was causing stuff to be missing
// alert("bis hier ok");
		layout= d3.layout.cloud().size([w, h])
			.words(frequency_list)
			.padding(5)
			.rotate(function() { return ~~(Math.random() * 2) * 90; })
			.font("Impact")
			.fontSize(function(d) { return sizeScale(d.freq); })
			.on("end",draw)
			.start();
	}


	function draw(words) {

		var fill = d3.scale.category20();

		d3.select(container).remove();
// 		alert(w +" => h: "+ h);

		d3.select("#word_cloud_<?php echo $Block;?>").append(container)
			.attr("width", w)
			.attr("height", h) 
			.append("g")
			.attr("transform", "translate(" + [w/2, h/2] + ")")
			.selectAll("text")
			.data(words)
			.enter().append("text")

			.transition()
			.duration(function(d) { return d.time}  )
			.attr('opacity', 1)
			.style("font-size", function(d) { return d.size + "px"; })
			.style("font-family", "Impact")
			.style("fill", function(d, i) { return fill(i); })
			.attr("text-anchor", "middle")
			.attr("transform", function(d) {
			return "rotate(" + d.rotate + ")";
		})
			.attr("transform", function(d) {
			return "translate(" + [d.x, d.y] + ")rotate(" + d.rotate + ")";
		})
			.text(function(d) { return d.text; });
	}





</script>