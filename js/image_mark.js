	function getSrc(object) {
		var temporaryElement = document.createElement('img');
		temporaryElement.innerHTML = object.innerhtml();
		var images = temporaryElement.getElementsByTagName('img');
		var output = [];
		for (var i = 0; i < images.length; i++) {
			output.push(images[i].src);
		}
		return output;
	}

	function SetMark(xPosRel,yPosRel,filename,MarkID,txt,Block){
		$("#x_"+filename+"_"+MarkID).val(xPosRel);
		$("#y_"+filename+"_"+MarkID).val(yPosRel);

		var ImgWidth=$("#"+filename).width();
		var ImgHeight=$("#"+filename).height();
		var xPos=Math.round(parseInt(ImgWidth)*(parseFloat(xPosRel)/100));
		var yPos=Math.round(parseInt(ImgHeight)*(parseFloat(yPosRel)/100));


		var a = document.createElement('span');
		a.setAttribute('class',"ImgMarker");
		a.innerHTML =MarkID;
		a.setAttribute('style',"top:"+yPos+"; left:"+xPos);
		a.setAttribute('id',"HV_"+Block+"_"+MarkID);
		$('#image_'+filename).append(a);


		var tt = document.createElement('span');
		var yPos_tt=yPos+25;
		var xPos_tt=xPos;
		tt.setAttribute('class',"TT_HV_"+Block+"_"+MarkID +" ImgTT tooltiptext hidden");
		tt.setAttribute('id',"TT_HV_"+Block+"_"+MarkID);
		tt.innerHTML = txt;
		tt.setAttribute('style',"top:"+yPos_tt+"; left:"+xPos_tt);
		$('#image_'+filename).append(tt);
	}