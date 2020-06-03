<?php
// session_start();
include_once($_SERVER['DOCUMENT_ROOT']."/php/frage.php");
include_once($_SERVER['DOCUMENT_ROOT']."/php/abgabe.php");
$abRow=getAbgabeInfo($_SESSION['fID'],$_SESSION['t']);
$abInfo=json_decode($abRow['parameter'],true);

switch($abgegeben){
	default:
?>
<div id="fragenBox">
	<div class="row">
		<p>
			Der Zugiff auf die Auswertung ist nicht gestattet!
		</p>
	</div>
</div>
<?php
		break;
	case 2:
?>
<div id="fragenBox"><?php //echo $Block."<=="; ?>
	<div class="row">
		<div class="col-sm-5"></div>
		<div class="col-sm-7"><a href="/module/mod_preasentation/export_evaluation.php?Block=<?php echo $Block; ?>" target="_blank"><button class="btn btn-primary btn-block">Daten dieses Blocks als CSV exportieren</button></a></div>
	</div>
	<div class="row">
		<div class="col-sm-6 col-md-8"></div>
		<div id='parent_<?php echo $Block; ?>' class="col-sm-6 col-md-4"></div>
	</div>
</div>
<script>
	$( document ).ready(function() {GetFeedback();});
</script>
<?php
		break;
}
?>
<script>
	// 	$( document ).ready(function() {GetFeedback(<?php echo $Block; ?>);});
</script>
<script>

	function GetFeedback(){
		//  				alert("Hallo");
		// 										alert("F:"+FrageID+"& A:"+aufgabeID);
		jQuery.ajax({
			type: 'POST',
			url: '/php/statistik.php',
			data: {
				PostFktn:"GetKonfidentsChart_Evaluation",
				fID:'<?php echo $_SESSION['fID']; ?>',
				Block:'<?php echo $Block; ?>'
			},
			dataType: 'json',
			success: function (data) {
				console.log(data);
				console.log(data['FragenInfoArr']);

				$.each(data['FragenInfoArr'], function(key, value) {
					console.log(value);
					var FrageID=key;
					window.WidthCanvas=$("#parent_<?php echo $Block; ?>").width();
					var row=document.createElement('div');
					row.setAttribute('class','row');
					row.setAttribute('style','width:100%; border-bottom: 1px lightgray solid;padding:5px;');

					var CellLeft=document.createElement('div');
					CellLeft.setAttribute('class','col-sm-6 col-md-8');
					CellLeft.setAttribute('id','txt_'+FrageID);
					CellLeft.innerHTML = data['FragenInfoArr'][FrageID][0]['FrageTXT'];

					var CellRight=document.createElement('div');
					CellRight.id=FrageID;
					CellRight.setAttribute('class','col-sm-6 col-md-4');
					// 					CellRight.appendChild(canvas);
					CellRight.setAttribute('Style','height:60px; min-width:'+WidthCanvas+'px;');

					var fBox=document.getElementById("fragenBox");
					row.appendChild(CellLeft);
					row.appendChild(CellRight);
					fBox.appendChild(row);
				})

				// 				console.log("Arr: "+input_Arr);

				$.each(data['input_Arr'], function(key, value) {
// 					console.log(data['input_Arr'][key]);	
					
					$.each( data['input_Arr'][key], function( key2, value2 ) {
// 						alert( key + ": " + value );
					$("#"+key).append(value2+"<br>");

					});

				})

				for(var i in data){
					if (typeof data[i] != 'undefined'){
						var FrageID=data[i]['FrageID'];
						var n=data[i]['n'];
						var MW=data[i]['MW'];
						var StdAbw=data[i]['StdAbw'];
						var Varianz=data[i]['Varianz'];
						var FragenInfoArr=data[i]['FragenInfoArr'];
						if (typeof data['own'] != 'undefined'){var own_values=data['own'];}else{own_values[FrageID]=0;}
						// 						alert(FrageID+"=>"+FragenInfoArr[FrageID][0]['FrageMax']);
						if (typeof FragenInfoArr[FrageID][0]['FrageMax'] != 'undefined'){var maxValue=FragenInfoArr[FrageID][0]['FrageMax'];}else{maxValue=100;}
						var FrageLabMax=decodeEntities(FragenInfoArr[FrageID][0]['FrageLabMax']);
						var FrageLabMax_Arr=FrageLabMax.split("<br>");
						var FrageLabMin=decodeEntities(FragenInfoArr[FrageID][0]['FrageLabMin']);
						var FrageLabMin_Arr=FrageLabMin.split("<br>");
						var MiddleLine=15;
						var canvas=document.createElement('canvas');
						canvas.setAttribute('Style','background: lightgray; border: 2px white; border-radius:5px;');
						canvas.setAttribute('width',WidthCanvas);
						canvas.setAttribute('height','60');

						var ctx = canvas.getContext("2d");
						ctx.font = "bold 12px Arial";
						var y0=0;
						FrageLabMin_Arr.forEach(function(entry) {
							ctx.fillText(entry,5,35+y0,100);
							y0=y0+13;
						});
						ctx.font = "bold 12px Arial";
						ctx.textAlign="right"; 
						var y0=0;
						FrageLabMax_Arr.forEach(function(entry) {
							ctx.fillText(entry,WidthCanvas-5,35+y0,100);
							y0=y0+13;
						});
						ctx.font = "12px Arial";
						ctx.textAlign="center"; 

						ctx.fillText("n="+n + "     E="+Math.round(MW*10)/10 +  "     s="+Math.round(StdAbw*10)/10,WidthCanvas/2,45,WidthCanvas);
						ctx.moveTo(0,MiddleLine);
						ctx.lineTo(WidthCanvas,MiddleLine);
						ctx.stroke();

						ctx.beginPath();
						ctx.arc(WidthCanvas/maxValue*MW,MiddleLine,5,0,2*Math.PI);
						ctx.fill();
						ctx.stroke();

						ctx.moveTo(WidthCanvas/maxValue*(MW-StdAbw),MiddleLine-5);
						ctx.lineTo(WidthCanvas/maxValue*(MW-StdAbw),MiddleLine+5);
						ctx.stroke();

						ctx.moveTo(WidthCanvas/maxValue*(MW+StdAbw),MiddleLine-5);
						ctx.lineTo(WidthCanvas/maxValue*(MW+StdAbw),MiddleLine+5);
						ctx.stroke();

						ctx.moveTo(WidthCanvas/maxValue*(MW-StdAbw),MiddleLine);
						ctx.lineTo(WidthCanvas/maxValue*(MW+StdAbw),MiddleLine);
						ctx.lineWidth = 5;
						ctx.stroke();
					}


					if(own_values!=null){
						ctx.beginPath();
						ctx.arc(WidthCanvas/maxValue*own_values[FrageID],MiddleLine,2,0,2*Math.PI);
						ctx.fillStyle="lime";
						ctx.fill();
						ctx.strokeStyle="lime";
						ctx.stroke();
						ctx.fillStyle="black";
					}

					if (typeof data["dozent"][i] != 'undefined'){
						var FrageID=data["dozent"][i]['FrageID'];
						var n=data["dozent"][i]['n'];
						var MW=data["dozent"][i]['MW'];
						var StdAbw=data["dozent"][i]['StdAbw'];
						var Varianz=data["dozent"][i]['Varianz'];
						var FragenInfoArr=data["dozent"][i]['FragenInfoArr'];

						ctx.beginPath();
						ctx.arc(WidthCanvas/maxValue*MW,MiddleLine,2,0,2*Math.PI);
						ctx.fill();
						ctx.strokeStyle = '#ff0000';

						ctx.stroke();

						ctx.moveTo(WidthCanvas/maxValue*(MW-StdAbw),MiddleLine-5);
						ctx.lineTo(WidthCanvas/maxValue*(MW-StdAbw),MiddleLine+5);
						ctx.lineWidth = 2;
						ctx.strokeStyle = '#ff0000';
						ctx.stroke();

						ctx.moveTo(WidthCanvas/maxValue*(MW+StdAbw),MiddleLine-5);
						ctx.lineTo(WidthCanvas/maxValue*(MW+StdAbw),MiddleLine+5);
						ctx.lineWidth = 2;
						ctx.strokeStyle = '#ff0000';
						ctx.stroke();

						ctx.moveTo(WidthCanvas/maxValue*(MW-StdAbw),MiddleLine);
						ctx.lineTo(WidthCanvas/maxValue*(MW+StdAbw),MiddleLine);
						ctx.lineWidth = 2;
						ctx.strokeStyle = '#ff0000';
						ctx.stroke();
					}

					$("#"+FrageID).append(canvas);
				}



			},
			error:function(xhr, ajaxOptions, thrownError){
				console.log(xhr);
				alert(xhr);
				alert(thrownError);
			},
			async:true
		});
	}

	function decodeEntities(encodedString) {
		var textArea = document.createElement('textarea');
		textArea.innerHTML = encodedString;
		return textArea.value;
	}

	// console.log(decodeEntities('1 &amp; 2'));
</script>