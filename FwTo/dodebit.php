<?php include 'db_connect.php';?><!-- σύνδεση με βάση -->

<?php
	session_start();
	include 'unaccepted.php'; // μη αποδεκτή κίνηση

	$Id = $_SESSION['Id'];
	$user = $_SESSION["Owner"];

	$a4pgs = $_POST["a4pgs"];
	$a4clsheets = 0; //$_POST["a4clsheets"];
	$a3pgs = $_POST["a3pgs"];
	$a3clsheets = 0; //$_POST["a3clsheets"];
	$comments = $_POST["comments"];
	$a4 = "A4";
	$a3 = "A3";
	
	if($a4pgs != 0){
		$sql  = "INSERT INTO ManualDebit (IdUser, PrintedPages, ColorPages, Size, DescriptionOfJobs) VALUES ('$Id', '$a4pgs', '$a4clsheets', '$a4', '$comments')";
		$result = mysqli_query($mysqli, $sql, MYSQLI_USE_RESULT)
		or die("Error: ".mysqli_error($mysqli));
	}

	if($a3pgs != 0){

		$sql  = "INSERT INTO ManualDebit (IdUser, PrintedPages, ColorPages, Size, DescriptionOfJobs) VALUES ('$Id', '$a3pgs', '$a3clsheets', '$a3', '$comments')";
		$result = mysqli_query($mysqli, $sql, MYSQLI_USE_RESULT)
		or die("Error: ".mysqli_error($mysqli));
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Φω.Το. | Σύστημα Χρεώσεων</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="css/yeti.bootstrap.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

</head>
<body>


<!-- navbar start -->

<div class="navbar navbar-default navbar-static-top" role="navigation">
  <div class="container">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="profile.php" title='Λεφτά, λεφτά, λεφτά...!'><i class="fa fa-print"></i> | Σύστημα Χρεώσεων</a>
    </div>

    <div class="navbar-collapse collapse">  
        <ul class="nav navbar-nav">
            <li>
                <a href="menu.php">Τιμοκατάλογος</a>
            </li>
            <li>
                <a href="help.php">Οδηγίες</a>
            </li>
            <li>
                <a href="contact.php">Επικοινωνία</a>
            </li>
            <li>
                <a href="who.php">Ποιοι είμαστε</a>
            </li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
         <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $user; ?>   <span class="glyphicon glyphicon-ok-circleglyphicon glyphicon-user"></span> <span class="caret"></span> </a>
            <ul class="dropdown-menu" role="menu">
            	<li><a href="debitform.php">Νέα Χρέωση</a></li>
	          <li class="divider"></li>
	          <li><a href="profile.php">Λογαριασμός</a></li>
	          
	          <li class="divider"></li>
	          <li><a href="signout.php">Αποσύνδεση</a></li>
            </ul>
          </li>
        </ul>
    </div>
  </div> 
</div>

<!-- navbar end -->

	

	<div class="container">
	  <div class="jumbotron">
	    <h1>Τα κατάφερες!</h1>
	    <p>Η κίνηση σου καταχωρύθηκε με επιτυχία</p>
	    <h1><span class="fa fa-thumbs-up" style="font-size: 200px"></span> </h1>        
	  </div>
	</div>


<!-- footer start -->

<div class="container">

<br>

<footer>
        <div class="row">
          <div class="col-lg-12">

            
            <p class="text-center"><small>Made by <a href="http://thomaspark.co" rel="nofollow">Xrfr</a>. Contact them at Niko30 celar!<br>
            Code released under the <a href="https://github.com/thomaspark/bootswatch/blob/gh-pages/LICENSE">MIT License</a>.<br>Based on <a href="http://getbootstrap.com" rel="nofollow">Bootstrap</a>. Icons from <a href="http://fortawesome.github.io/Font-Awesome/" rel="nofollow">Font Awesome</a>. Web fonts from <a href="http://www.google.com/webfonts" rel="nofollow">Google</a>.</small></p>

          </div>
        </div>

      </footer>
</div>

<!-- footer end -->
	

</body>
</html>

