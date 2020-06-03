<?php
session_start();
  /*******************************************************
   * Only these origins will be allowed to upload images *
   ******************************************************/
  $accepted_origins = array("localhost", "www.jdev-pemasoft.de", "www.physik-workshop.de",$_SERVER['HTTP_HOST']);

  /*********************************************
   * Change this line to set the upload folder *
   *********************************************/
//   $imageFolder = "images/".$_SESSION['uID']."/";
  $imageFolder = "uploads/".$_SESSION['uID']."/";
  if(!is_dir ( $imageFolder )){mkdir($imageFolder);}

  reset ($_FILES);
  $temp = current($_FILES);
// echo $_FILES['name'];
// echo $temp['name']."<br>".$temp['tmp_name'];
  if (is_uploaded_file($temp['tmp_name'])){
    if (isset($_SERVER['HTTP_HOST'])) {
      // same-origin requests won't set an origin. If the origin is set, it must be valid.
      if (in_array($_SERVER['HTTP_HOST'], $accepted_origins)) {
        header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_HOST']);
      } else {
        header("HTTP/1.0 403 Origin Denied ".$_SERVER['HTTP_HOST']);
        return;
      }
    }

    /*
      If your script needs to receive cookies, set images_upload_credentials : true in
      the configuration and enable the following two headers.
    */
    // header('Access-Control-Allow-Credentials: true');
    // header('P3P: CP="There is no P3P policy."');

    // Sanitize input
    if (preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $temp['name'])) {
        header("HTTP/1.0 500 Invalid file name.");
        return;
    }

    // Verify extension
// 	  echo strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION));
    if (!in_array(strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION)), array("gif", "jpg", "png"))) {
        header("HTTP/1.0 500 Dateierweiterung nicht erlaubt! Es sind nur gif, jpg, png Dateien erlaubt!");
        return;
    }
$extension=pathinfo($temp['name'], PATHINFO_EXTENSION);
	  $uniqid=uniqid();
    // Accept upload if there was no origin, or if it is an accepted origin
//     $filetowrite = $imageFolder . $temp['name'];
    $filetowrite = $imageFolder . $uniqid.".".$extension;
    move_uploaded_file($temp['tmp_name'], $filetowrite);

    // Respond to the successful upload with JSON.
    // Use a location key to specify the path to the saved image resource.
    // { location : '/your/uploaded/image/file'}
    echo json_encode(array('location' => $filetowrite));
// 	  exit;
  } else {
    // Notify editor that the upload failed
    header("HTTP/1.0 500 Server Error - Fehler bei der Übertragung, bitte entfernen Sie das Bild und fügen es erneut ein!");
  }
?>