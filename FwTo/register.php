<?php include 'db_connect.php';?><!-- σύνδεση με βάση -->

<?php
	
	$arrayids = array();
	$arrayowners = array();
	$sql = "SELECT * FROM Users";
	$result = mysqli_query($mysqli, $sql);
	while($rows = mysqli_fetch_array($result, MYSQLI_ASSOC))
		{
			
			array_push($arrayids, $rows['Id']);
			array_push($arrayowners, $rows['Owner']); 
		
		} 
		$i=0;
		
	while($i != count($arrayowners))
		{
			
			echo $arrayowners[$i];
			$i++;
		
		} 

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
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
        <a class="navbar-brand" href="index.html" title='Λεφτά, λεφτά, λεφτά...!'><i class="fa fa-print"></i> | Σύστημα Χρεώσεων</a>
    </div>

    <div class="navbar-collapse collapse">  
        <ul class="nav navbar-nav">
            <li>
                <a href="menu.html">Τιμοκατάλογος</a>
            </li>
            <li>
                <a href="help.html">Οδηγίες</a>
            </li>
            <li>
                <a href="contact.html">Επικοινωνία</a>
            </li>
            <li>
                <a href="who.html">Ποιοι είμαστε</a>
            </li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
         <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-ok-circleglyphicon glyphicon-user"></span></a>
            
          </li>
        </ul>
    </div>
  </div> 
</div>

<!-- navbar end -->

<!-- registerform start -->  

<div class="container">

	<div class="bs-docs-section">
		<div class="row">
			<div class="col-lg-12">
				<div class="page-header">
					<h1 id="forms">Εγγραφή</h1>
				</div>
			</div>
		</div>

		      
		<form class="form-horizontal" action="dodebit.php" method="post">
			<div class="row">
				<div class="col-lg-8 col-lg-offset-2">
					<div class="well bs-component">
				
						<fieldset>
							<legend>Φόρμα συμπλήρωσης προσωπικών στοιχείων</legend>


							<div class="form-group">
								<label for="inputEmail" class="col-lg-2 control-label">Αναγνωριστικό</label>
								<div class="col-lg-10">

									<input class="form-control" type="number" min="1" placeholder="μόνο νούμερα">
								</div>
							</div>

							<div class="form-group">
								<label class="col-lg-2 control-label">Κωδικός</label>
								<div class="col-lg-10">
									<input class="form-control" type="password" min="1" placeholder="μόνο νούμερα">
								</div>
							</div>

							<div class="form-group">
								<label class="col-lg-2 control-label">Ξανά Κωδικός</label>
								<div class="col-lg-10">
									<input class="form-control" type="password" min="1" placeholder="μόνο νούμερα">
								</div>
							</div>

							<div class="form-group">
								<label for="inputEmail" class="col-lg-2 control-label">Δικαιούχος</label>
								<div class="col-lg-10">

									<input class="form-control" type="text" placeholder="ποιός είσαι;">
								</div>
							</div>

							<div class="form-group">
								<label class="col-lg-2 control-label">email</label>
								<div class="col-lg-10">
									<input class="form-control" type="email" placeholder="email">
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
