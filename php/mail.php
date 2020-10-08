<?php

function sentMail($MessageArray){
//  	echo "Pos1: ";

	require_once ($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR'].'/includes/PHPMailer/PHPMailerAutoload.php');
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");

	$mail = new PHPMailer();
	$mail->IsSendmail();
//  	$mail->IsSMTP(); // telling the class to use SMTP
	$mail->CharSet = 'utf-8';
	$mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
	// 1 = errors and messages
	// 2 = messages only
// 	$mail->SMTPAuth   = $smtp_auth;                  // enable SMTP authentication
// 	$mail->Host       = $smtp_host;
// 	$mail->Port       = $smtp_port ;//$smtp_port;                    // set the SMTP port for the GMAIL server
// 	$mail->Username   = $smtp_username; // SMTP account username
// 	$mail->Password   = $smtp_password;        // SMTP account password

	$mail->SetFrom($MessageArray['from']['EmailFrom']);
	$mail->MsgHTML($MessageArray['nachricht']);
	$mail->Subject = $MessageArray['betreff'];
	if(isset($MessageArray['files'])){
		$getFileJson=json_decode($MessageArray['files']);
		if(count($getFileJson)>0){
			$getFileArr=$getFileJson->files;
			if(isset($getFileJson->files)){
				foreach($getFileArr as $file){
					$mail->AddAttachment( $file , basename ($file) );
				}
			}
		}
	}
	$empfaengerMail=$MessageArray['to']['EmailTo'];
//  	echo "Pos2: ";

// 	exit;
	foreach($empfaengerMail as $email_rep){
		$mail->AddCC($email_rep);
	}
	if(isset($MessageArray['to']['EmailToCC'])){
		foreach($MessageArray['to']['EmailToCC'] as $email_rep){
			$mail->AddCC($email_rep);
		}
	}

	if(isset($MessageArray['to']['EmailToBCC'])){
		foreach($MessageArray['to']['EmailToCC'] as $email_rep){
			$mail->AddBCC($email_rep);
		}
	}
	/* 	if(isset($MessageArray['to']['EmailToBCC'])){
		$mail->AddBCC($MessageArray['to']['EmailToBCC']);
	}
 */
	$mail->charSet = "UTF-8";
	if(!$mail->Send()) {
// 		$mail->ErrorInfo;
	 	echo $mail->ErrorInfo;
		return false;
	}else{
// 		echo "Emails wurden erfolgreich versendet. Sie können dieses Fenster jetzt schließen!<br>";
				return true;

	}

	// 	$mail->Send();
// 	 	echo $mail->ErrorInfo;
}


function email_versenden($from,$to_arr,$subject,$message,$toCC_arr=array()){
	// $to_arr=array("email1","email2","email3");

	include_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/php/mail.php");
	$MessageArray['from']['EmailFrom']=$from;
	// 	$MessageArray['from']=array("FromEmail"=> $from);
	$MessageArray['to']['EmailTo']= $to_arr; // $to_arr=array("ex1@test.de", "ex2@test.de")
	$MessageArray['to']['EmailToCC']= $toCC_arr; // $to_arr=array("ex1@test.de", "ex2@test.de")
	
	$MessageArray['betreff']=$subject;
	$MessageArray['nachricht']=$message;
	return sentMail($MessageArray);

}