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

  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>


  

</head>
<body>
<script type="text/javascript">
    $(document).ready(function() {
      $('#example').DataTable();
} );
</script>
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

	<ul class="nav nav-tabs">
		  <li class=""><a href="#home" data-toggle="tab" aria-expanded="false">Λογαριασμός/Πρόσφατες Κινήσεις</a></li>
		  <li class="active"><a href="#profile" data-toggle="tab" aria-expanded="true">Προφίλ</a></li>
		  <li class=""><a href="#fullhistory" data-toggle="tab" aria-expanded="false">Πλήρες Ιστορικό</a></li>
	</ul>

	<div id="myTabContent" class="tab-content">
  		<div class="tab-pane fade" id="home">
    		
    		<div class="container"></br>	
    		<div class="row">
            <div class="col-lg-6">
              <div class="well bs-component">

              <?php
                    $i=0;
                    $sql = "SELECT * FROM Bill WHERE IdUser = '$Id'";
                    $result = mysqli_query($mysqli, $sql);


                    while($rows = mysqli_fetch_array($result, MYSQLI_ASSOC))
                    {

                      $Balance = $rows['Balance'];                              
                    } 
                    ?>
                
                  <fieldset>
                    <legend><span class="fa fa-credit-card"></span> Λογαριασμός</legend>
                    <h2><p class="text-primary">Το συνολικό χρέος σας είναι: <abbr title="η συγκεκριμένη τιμή έχει ενημερωθεί τελευταία φορά το προηγούμενο μεσημέρι στις 15:00"><?php echo $Balance; ?>€</abbr></p></h2>

                  <blockquote>
          					<p>Ό,τι αξίζει κοστίζει!</p>
          					<small>Αδαμάντιος Μοτσάκος <cite title="Source Title">Φω.Το.</cite></small>
          				</blockquote>
                    
                  </fieldset>
                
              </div>
            </div>
            <div class="col-lg-4 col-lg-offset-1">

            		<fieldset>
            		<legend><span class="fa fa-history"></span> Μη χρεωμένες εκτυπώσεις</legend>

                <table class="table table-striped table-hover ">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Ημερομηνία</th>
                      <th>Εκτυπώσεις</th>
                      <th>Μέγεθος</th>
                      <th>Περιγραφή</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                    $i=0;
                    $sql = "SELECT * FROM ManualDebit WHERE IdUser = '$Id' 
                    ORDER BY DateLog DESC";
                    $result = mysqli_query($mysqli, $sql);
                    

                    while($rows = mysqli_fetch_array($result, MYSQLI_ASSOC))
                    {

                      $i++;
                      if($rows['PrintedPages'] > 0){
                      ?>
                      <tr>
                      <td><?php echo $i; ?></td>
                      <td><?php echo $rows['DateLog']; ?></td>
                      <td><?php echo $rows['PrintedPages']; ?></td>
                      <td><?php echo $rows['Size']; ?></td>
                      <td><?php echo $rows['DescriptionOfJobs']; ?></td>
                      </tr>
                      <?php
                      if($i == 8){break;}
                    	}
                    } 

                  ?>          
                                    
                  </tbody>
                
                </table>
                <span class="help-block">Οι συγκεκριμένες εκτυπώσεις θα χρεωθούν το ερχόμενο μεσημέρι στις 15:00</span> 
              <fieldset>
            </div>
          </div>
        </div>
  </div>
	<div class="tab-pane fade active in" id="profile">
    <div class="container"></br>  
      <div class="row">
        <div class="col-lg-6 col-lg-offset-3">
          <div class="well bs-component">

              <fieldset>

                <legend><i class="fa fa-child"></i> Προφίλ</legend>
                <h3><p class="text-success">Κάτοχος: <?php echo $user; ?></p></h3>
                <h3><p class="text-success">Αναγνωριστικο: <?php echo $Id; ?></p></h3>
                
              </fieldset>  
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="tab-pane fade" id="fullhistory">
    <div class="container"></br>  
      <div class="row">
        <div class="col-lg-10 col-lg-offset-1">

                <fieldset>
                  <legend><span class="fa fa-history"></span> Πλήρες Ιστορικό χρεωμένων εκτυπώσεων</legend>

                  <table id="example" class="table table-striped table-hover ">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Ημερομηνία</th>
                        <th>Εκτυπώσεις</th>
                        <th>Μέγεθος</th>
                        <th>Περιγραφή</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                      $i=0;
                      $sql2 = "SELECT * FROM History WHERE IdUser = '$Id' 
                      ORDER BY DateLog DESC";
                      $result2 = mysqli_query($mysqli, $sql2);
                      

                      while($rows = mysqli_fetch_array($result2, MYSQLI_ASSOC))
                      {

                        $i++;
                        if($rows['PrintedPages'] > 0){
                        ?>
                        <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $rows['DateLog']; ?></td>
                        <td><?php echo $rows['PrintedPages']; ?></td>
                        <td><?php echo $rows['Size']; ?></td>
                        <td><?php echo $rows['DescriptionOfJobs']; ?></td>
                        </tr>
                        <?php
                        
                        }
                      } 

                    ?>          
                                      
                    </tbody>
                  
                  </table> 
                </fieldset>
        </div>
      </div>
    </div>
  </div>

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
