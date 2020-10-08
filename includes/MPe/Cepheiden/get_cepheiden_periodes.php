<?php
$path="data/0000_Cepheiden_uebersicht.csv";
function ParseCSV_to_AssocArray($path){
    $row = 1;
    $AssocArray=[];
    if (($handle = fopen($path, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 0, ";")) !== FALSE) {
            $num = count($data);
            if($row==1){$header=$data; $row++; continue;}
            array_push($AssocArray,array_combine ( $header , $data ));
            $row++;
        }
        fclose($handle);
    }
    return $AssocArray;
}
