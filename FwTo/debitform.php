<?php include 'db_connect.php';?><!-- σύνδεση με βάση -->



<?php

	session_start();
	include 'unaccepted.php'; // μη αποδεκτή κίνηση

	$Id = $_SESSION['Id'];
	$user = $_SESSION["Owner"];
	
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

<!-- debitform start -->  

<div class="container">

	<div class="bs-docs-section">
		<div class="row">
			<div class="col-lg-12">
				<div class="page-header">
					<h1 id="forms">Χρέωση</h1>
				</div>
			</div>
		</div>

		      
		<form class="form-horizontal" action="dodebit.php" method="post">
			<div class="row">
				<div class="col-lg-8 col-lg-offset-2">
					<div class="well bs-component">
				
						<fieldset>
							<legend>Αναλυτικό Φύλλο Χρέωσης</legend>


							<div class="form-group">
								<label for="inputEmail" class="col-lg-2 control-label">Σελίδες Α4</label>
								<div class="col-lg-10">
									<div class="input-group">
										<span class="input-group-addon">#</span>
										<input class="form-control" type="number" name="a4pgs" min="0" max="2000">
									</div>
								</div>
							</div>					

							<div class="form-group">
								<label for="inputEmail" class="col-lg-2 control-label">Σελίδες Α3</label>
								<div class="col-lg-10">
									<div class="input-group">
										<span class="input-group-addon">#</span>
										<input class="form-control" type="number" name="a3pgs" min="0" max="2000">
									</div>
								</div>
							</div>

							<div class="form-group">
								<label for="textArea" class="col-lg-2 control-label">Περιγραφή εργασίας</label>
								<div class="col-lg-10">
									<textarea class="form-control" rows="3" id="textArea" name="comments"></textarea>
									<span class="help-block">Εδώ μπορείτε να δώσετε μια περιγραφή στην εκτυπωτική σας κίνηση ώστε να μπορείτε εύκολα να αναγνωρίσετε τον λόγο της εκτύπωσης σας αυτής στο μέλλον.</span>
								</div>
							</div>
							<div class="form-group">
								<div class="col-lg-10 col-lg-offset-2">
									<button type="reset" class="btn btn-default">Cancel</button>
									<button type="submit" class="btn btn-primary">Submit</button>
								</div>
							</div>
						</fieldset>
					</div>
				</div>
			</div>	
		</form>
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
