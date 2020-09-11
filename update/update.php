<?php
include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");

//ENTER THE RELEVANT INFO BELOW
$mysqlUserName      = $dbname;
$mysqlPassword      = $dbpass;
$mysqlHostName      = $dbhost;
$DbName             = $dbname;
$backup_name        = date("Y_m_d__H_i_s")."___db_backup.sql";
$tables             = false;

//or add 5th parameter(array) of specific tables:    array("mytable1","mytable2","mytable3") for multiple tables

Export_Database($mysqlHostName,$mysqlUserName,$mysqlPassword,$DbName,  $tables=false, $backup_name );

function Export_Database($host,$user,$pass,$name,  $tables=false, $backup_name=false )
{
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
	/* 	$mysqli = new mysqli($host,$user,$pass,$name); 
	$mysqli->select_db($name); 
	$mysqli->query("SET NAMES 'utf8'");
 */
	// 	$queryTables    = $mysqli->query('SHOW TABLES'); 
	$queryTables=mysqli_query($verbindung,'SHOW TABLES');
	// 	while($row = $queryTables->fetch_row()) 
	while($row = mysqli_fetch_row ( $queryTables )) 
	{ 
		$target_tables[] = $row[0]; 
	}   
	if($tables !== false) 
	{ 
		$target_tables = array_intersect( $target_tables, $tables); 
	}
	foreach($target_tables as $table)
	{
		$dropTable= 'DROP TABLE IF EXISTS'.$table.';';

		$result         =   mysqli_query($verbindung,'SELECT * FROM '.$table);
		$fields_amount  =   mysqli_num_rows($result);
		$rows_num		=	mysqli_affected_rows ( $verbindung );     
		$res            =   mysqli_query($verbindung,'SHOW CREATE TABLE '.$table);
		$TableMLine     =   mysqli_fetch_row ( $res );
		$content        = (!isset($content) ?  '' : $content) . "\n\n" . $dropTable. "\n\n" . $TableMLine[1].";\n\n";

		for ($i = 0, $st_counter = 0; $i < $fields_amount;   $i++, $st_counter=0) 
		{
			while($row = mysqli_fetch_row ( $result ))  
			{ //when started (and every after 100 command cycle):
				if ($st_counter%100 == 0 || $st_counter == 0 )  
				{
					$content .= "\nINSERT INTO ".$table." VALUES";
				}
				$content .= "\n(";
				for($j=0; $j<$fields_amount; $j++)  
				{ 
					$row[$j] = str_replace("\n","\\n", addslashes($row[$j]) ); 
					if (isset($row[$j]))
					{
						$content .= '"'.$row[$j].'"' ; 
					}
					else 
					{   
						$content .= '""';
					}     
					if ($j<($fields_amount-1))
					{
						$content.= ',';
					}      
				}
				$content .=")";
				//every after 100 command cycle [or at last line] ....p.s. but should be inserted 1 cycle eariler
				if ( (($st_counter+1)%100==0 && $st_counter!=0) || $st_counter+1==$rows_num) 
				{   
					$content .= ";";
				} 
				else 
				{
					$content .= ",";
				} 
				$st_counter=$st_counter+1;
			}
		} $content .="\n\n\n";
	}
	//$backup_name = $backup_name ? $backup_name : $name."___(".date('H-i-s')."_".date('d-m-Y').")__rand".rand(1,11111111).".sql";
	// 	$backup_name = $backup_name ? $backup_name : $name.".sql";
	// 	header('Content-Type: application/octet-stream');   
	// 	header("Content-Transfer-Encoding: Binary"); 
	// 	header("Content-disposition: attachment; filename=\"".$backup_name."\"");  
	$handle = fopen("backup/".$backup_name,'w+');
	fwrite($handle,$content);
	fclose($handle);

	// 	echo $content; 
	exit;
}



if(is_file($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/update/sql/update.sql")){
	$query=file_get_contents($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/update/sql/update.sql");
	mysqli_multi_query ( $verbindung , $query );
}