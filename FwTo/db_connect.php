<?php
	$mysqli = new mysqli("localhost", "root", "Web@dminUb", "Fw.To");

	if(mysqli_connect_errno())
	{
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}
	
	//mysqli_set_charset($mysqli, "utf8");
	mysqli_query($mysqli, "SET NAMES 'utf8'");
?>
