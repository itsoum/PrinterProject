<?php 
	if(empty($_SESSION) == TRUE)
  	{ 
  		session_destroy();
  		header("location:/FwTo/banned.php");
	}
?>