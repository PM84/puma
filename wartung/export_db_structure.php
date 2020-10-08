<?php

backup_tables();

/* backup the db OR just a table */
function backup_tables($tables = '*')
{
	include($_SERVER['DOCUMENT_ROOT'].$_SESSION['DOCUMENT_ROOT_DIR']."/config.php");
$return="";

	//get all of the tables
	if($tables == '*')
	{
		$tables = [];
		$result = mysqli_query($verbindung,'SHOW TABLES');
		while($row = mysqli_fetch_row($result))
		{
			$tables[] = $row[0];
		}
	}
	else
	{
		$tables = is_array($tables) ? $tables : explode(',',$tables);
	}
	
	//cycle through
	foreach($tables as $table)
	{
		$result = mysqli_query($verbindung,'SELECT * FROM '.$table);
		$num_fields = mysqli_num_fields($result);
		
		$row2 = mysqli_fetch_row(mysqli_query($verbindung,'SHOW CREATE TABLE '.$table));
		$return.= "\n\n".$row2[1].";\n\n";

		$return.="\n\n\n";
	}

	$return = str_replace('CREATE TABLE', 'ALTER TABLE', $return);
	//save file
	$handle = fopen('db-backup-'.time().'-'.(md5(implode(',',$tables))).'.sql','w+');
	fwrite($handle,$return);
	fclose($handle);
}