<?php 
include("../config.php");

$query = "SELECT * FROM media";
$ergebnis = mysqli_query($verbindung,$query);

while($row=mysqli_fetch_assoc($ergebnis)){
$filename = "uploads/".$row['dateiname'];
if(!file_exists ( $filename )){    
    $delquery =  "DELETE FROM media WHERE dateiname = '".$row['dateiname']."'";
    mysqli_query($verbindung,$delquery);
    echo $delquery."<br>";
}

}

?>