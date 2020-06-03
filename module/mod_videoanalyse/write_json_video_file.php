<?php
echo __DIR__;
$file=__DIR__."/../../tmp_video/exit_files.txt";
$content=file_get_contents($file);
$jsonArr=json_decode($content,true);
$filename=$_POST['fileName'];
$jsonArr[$filename]=array();

$json_string=json_encode($jsonArr);

$fp=fopen($file,"w")or die("Unable to open file!");;
fwrite($fp,$json_string);
fclose($fp);
// echo $json_string;