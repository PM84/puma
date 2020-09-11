<?php

function file_get_contents_utf8($fn) {
	$content = file_get_contents($fn);
	return mb_convert_encoding($content, 'UTF-8',mb_detect_encoding($content, 'UTF-8, ISO-8859-1', true));
}

function mynl2br($text) { 
	// 	return strtr($text, array("\r\n" => '<br />', "\r" => '<br />', "\n" => '<br />')); 
	return strtr($text, array("\r\n" => '', "\r" => '', "\n" => '')); 
}

function form_safe_json($json) {
	$json = empty($json) ? '[]' : $json ;
	$search = array('\\',"\n","\r","\f","\t","\b","'") ;
	$replace = array('\\\\',"\\n", "\\r","\\f","\\t","\\b", "&#039");
	$json = str_replace($search,$replace,$json);
	return $json;
}

function removeWhiteSpacesVorKomma($text) { 
	// 	return strtr($text, array("\r\n" => '<br />', "\r" => '<br />', "\n" => '<br />')); 
	return strtr($text, array(", " => ',', ", " => ',', "  " => ' ')); 
}

function formatSizeUnits($bytes)
{
	if ($bytes >= 1073741824)
	{
		$bytes = number_format($bytes / 1073741824, 2) . ' GB';
	}
	elseif ($bytes >= 1048576)
	{
		$bytes = number_format($bytes / 1048576, 2) . ' MB';
	}
	elseif ($bytes >= 1024)
	{
		$bytes = number_format($bytes / 1024, 2) . ' kB';
	}
	elseif ($bytes > 1)
	{
		$bytes = $bytes . ' bytes';
	}
	elseif ($bytes == 1)
	{
		$bytes = $bytes . ' byte';
	}
	else
	{
		$bytes = '0 bytes';
	}

	return $bytes;
}

function check_if_url_exists($url){
	$url_headers = @get_headers($url);
	if(!$url_headers || $url_headers[0] == 'HTTP/1.1 404 Not Found') {
		$exists = false;
	}
	else {
		$exists = true;
	}
	return $exists;
}

function get_siteInfo($info){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$infoFile=$_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/info.txt";
	$indexContet=file_get_contents_utf8($infoFile);
	$siteInfo=json_decode($indexContet,true);
	return $siteInfo[$info];
}


function get_col_titel_from_first_row($firstRowArr){
		include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	$notwendige_zellen=array("SkalaTyp"=>0,"FrageTXT"=>0,"FrageTipp"=>0,"FrageLabMax"=>0,"FrageMax"=>0,"FrageLabMin"=>0,"FrageMin"=>0,"FrageGruppe"=>0,"initVal"=>0,"initToolTip"=>0,"noAnswer"=>0);

	foreach($firstRowArr as $key => $cellTitel){
// 		str_replace ( "#65279;" , "" , $cellTitel );
		$cellTitel=mysqli_real_escape_string ($verbindung, htmlentities (mynl2br($cellTitel), ENT_QUOTES , "UTF-8"));
// echo $cellTitel;
		if(in_array ( trim($cellTitel) , $notwendige_zellen )){
			$notwendige_zellen[$cellTitel]=$key;
		}else{
			return false;
		}
	}
	return $notwendige_zellen;
}

function reconstruct_url($url){    
    $url_parts = parse_url($url);
    $constructed_url = $url_parts['scheme'] . '://' . $url_parts['host'] . (isset($url_parts['path'])?$url_parts['path']:'');
	if(isset($url_parts['scheme'])){


	}else{
		    $constructed_url =  $url_parts['host'] . (isset($url_parts['path'])?$url_parts['path']:'');

	}
    return $constructed_url;
}

function shuffle_assoc($array) { 
	if (!is_array($array)) return $array; 

	$keys = array_keys($array); 
	shuffle($keys); 
	$random = array(); 
	foreach ($keys as $key) { 
		$random[$key] = $array[$key]; 
	}
	return $random; 
} 
