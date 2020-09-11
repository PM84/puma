function createMark(filename, MarkID,MarkTXT="",Block, AllowDelete=1){

	var MarkWrap=document.createElement('div');
	MarkWrap.setAttribute('id',"MarkWrap_"+Block+"_"+filename+"_"+MarkID);

	var p1 = document.createElement('p');
	p1.innerHTML = "Markierung "+MarkID+":";

	if(AllowDelete==1){
		var trash = document.createElement('span');
		trash.setAttribute('class',"delTrash btn btn-danger glyphicon glyphicon-trash pull-right");
		trash.setAttribute('data',"MarkWrap_"+Block+"_"+filename+"_"+MarkID);
		$(p1).append(trash);
		// 		$('#bs_'+filename).append(p1);

	}
	$(MarkWrap).append(p1);
	var Input_MarkID = document.createElement('input');
	Input_MarkID.setAttribute('type',"hidden");
	Input_MarkID.setAttribute('id',"MarkID_"+filename);
	Input_MarkID.setAttribute('value',MarkID);
	Input_MarkID.setAttribute('name',"img_hov_MarkID_"+Block+"[]");
	// 		$('#bs_'+filename).append(Input_MarkID);
	$(MarkWrap).append(Input_MarkID);

	var IpFilename = document.createElement('input');
	IpFilename.setAttribute('type',"hidden");
	IpFilename.setAttribute('id',"IpFilename_"+filename);
	IpFilename.setAttribute('value',filename);
	IpFilename.setAttribute('name',"img_hov_filename_"+Block+"[]");
	// 		$('#bs_'+filename).append(IpFilename);
	$(MarkWrap).append(IpFilename);

	var Input_x = document.createElement('input');
	Input_x.setAttribute('type',"hidden");
	Input_x.setAttribute('id',"x_"+filename+"_"+MarkID);
	Input_x.setAttribute('name',"img_hov_x_"+Block+"[]");
	// 		$('#bs_'+filename).append(Input_x);
	$(MarkWrap).append(Input_x);

	var Input_y = document.createElement('input');
	Input_y.setAttribute('type',"hidden");
	Input_y.setAttribute('id',"y_"+filename+"_"+MarkID);
	Input_y.setAttribute('name',"img_hov_y_"+Block+"[]");
	// 		$('#bs_'+filename).append(Input_y);
	$(MarkWrap).append(Input_y);

	var Input_TXT = document.createElement('input');
	Input_TXT.setAttribute('class',"form-control TxtInput");
	Input_TXT.setAttribute('value',MarkTXT);
	Input_TXT.setAttribute('name',"img_hov_txt_"+Block+"[]");
	// 		$('#bs_'+filename).append(Input_TXT);
	$(MarkWrap).append(Input_TXT);

	$('#bs_'+filename).append(MarkWrap);

}

function SetMark(xPosRel,yPosRel,filename,MarkID){
	$("#x_"+filename+"_"+MarkID).val(xPosRel);
	$("#y_"+filename+"_"+MarkID).val(yPosRel);

	var ImgWidth=$("#"+filename).width();
	var ImgHeight=$("#"+filename).height();
	var xPos=Math.round(parseInt(ImgWidth)*(parseFloat(xPosRel)/100))-14;
	var yPos=Math.round(parseInt(ImgHeight)*(parseFloat(yPosRel)/100))-12;


	var a = document.createElement('span');
	a.setAttribute('class',"ImgMarker");
	a.innerHTML =MarkID;
	a.setAttribute('style',"top:"+yPos+"; left:"+xPos);

	$('#image_'+filename).append(a);

}

function deleteMark(id){
	$( "#"+id ).remove();
}