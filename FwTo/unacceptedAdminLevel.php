<?php 
	if(empty($_SESSION) == TRUE OR $_SESSION["Credentials"] != "administrator")
  	{ 
  		session_destroy();
  		header("location:/FwTo/banned.php");
	}
?> 