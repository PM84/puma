<?php

function Get_Sim_Liste(){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/system.php");
	//Quelle wird in der config.php Datei angegeben.
	$indexContet=file_get_contents_utf8($index_Sim_path);
	$Index=json_decode($indexContet);
	return $Index;
}

function Get_SimThemen(){
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/system.php");
	//Quelle wird in der config.php Datei angegeben.
	$indexContet=file_get_contents_utf8($index_themen_path);
	$Index=json_decode($indexContet);
	return $Index;
}

function Get_SimInfos_By_vID($SimsArr,$simID){
	// Eingabe: z.B. return value von Get_Sim_Liste
	foreach($SimsArr as $Sim){
		if($Sim->simID==$simID){
			return $Sim;
		}
	}
}