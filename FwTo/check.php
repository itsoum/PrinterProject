<?php include 'db_connect.php';?><!-- σύνδεση με βάση -->


<?php

		$username=$_POST["username"]; 
		$password=$_POST["password"];

		session_start();

		$sql = "SELECT * FROM Users WHERE Id='$username' AND Password='$password'";
		$result = mysqli_query($mysqli, $sql);
		$rowsselectfrombase = mysqli_num_rows($result); 

		while($rows = mysqli_fetch_array($result, MYSQLI_ASSOC))
		{
			$_SESSION["Id"] = $rows['Id'];
			$_SESSION["Owner"] = $rows['Owner'];
			$_SESSION["Credentials"] = $rows['Credentials'];
		
		}
		
		if (isset($_SESSION['Id'])){
			mysqli_free_result($result);
			$Id=$_SESSION["Id"];
			$Cred = $_SESSION["Credentials"];
		}
		
		
		if($rowsselectfrombase > 0)
		{
			
			if($Cred == "administrator")
			{
				if (isset($_POST['submitform']))
				{   
					header("location:/FwTo/adminSearch.php")
					?>
					<!--<script type="text/javascript">
						window.location = "admin.php"
						</script> -->
						  
					<?php
				}
			}
			else
			{
				if (isset($_POST['submitform']))
				{   
					header("location:/FwTo/debitform.php")
					?>
					<!--<script type="text/javascript">
						window.location = "debitform.php";
						</script> -->      
					<?php
				}
			}
		}
		else
		{
			if (isset($_POST['submitform']))
			{ 
			?>
				<script type="text/javascript">
				window.location = "index.html";
				</script>      
			<?php
			}
		}
			
?>