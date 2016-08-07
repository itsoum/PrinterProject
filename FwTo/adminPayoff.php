<?php include 'db_connect.php';?><!-- σύνδεση με βάση -->

<?php

  session_start();
  include 'unacceptedAdminLevel.php'; // μη αποδεκτή κίνηση


  $Id = $_SESSION['Id'];
  $user = $_SESSION["Owner"];

  $search = $_POST["search"];


  
  if($search != null){
    $sql  = "SELECT * FROM Users INNER JOIN Bill ON Users.Id = Bill.IdUser 
                  WHERE Bill.IdUser = '$search' OR Users.Owner LIKE '%$search%' ";
    $result = mysqli_query($mysqli, $sql);

    if(mysqli_num_rows($result) == 0 ){ 

      mysqli_num_rows($result);
      
      header("location:/FwTo/adminSearchnoexist.php"); 

    }

    if(mysqli_num_rows($result) > 1){ 

      mysqli_num_rows($result);
      
      header("location:/FwTo/adminSearchmanyres.php"); 

    }

    
      while($rows = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
      
      $UserId = $rows['Id'];
      $_SESSION['UserId'] = $UserId;
      $Owner = $rows['Owner'];
      $_SESSION['OwnerX'] = $Owner;
      $Balance = $rows['Balance'];
      $_SESSION['Balance'] = $Balance;
    }
  }
  else{
    header("location:/FwTo/adminSearchnoexist.php"); 
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

<div class="navbar navbar-inverse navbar-static-top" role="navigation">
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
            <li>
                <a href="http://svweb01/FwTo/python/logger.log" target="_blank">System Logs</a>
            </li> 
        </ul>
        <ul class="nav navbar-nav navbar-right">
         <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $user; ?>   <span class="glyphicon glyphicon-ok-circleglyphicon glyphicon-user"></span> <span class="caret"></span> </a>
            <ul class="dropdown-menu" role="menu">
          <li><a href="adminBilltable.php">Συγκεντρωτικός Χρεωστικός Πίνακας</a></li>
            <li class="divider"></li>
            <li><a href="adminSearch.php">Αναζήτηση</a></li>
            <li><a href="adminNewRegist.php">Εγγραφή Νέου Χρήστη</a></li>
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
          <h1 id="forms">Υπόλοιπο Χρήστη</h1>
        </div>
      </div>
    </div>

          
    <form class="form-horizontal" action="admindoPayoff.php" method="post">
      <div class="row">
        <div class="col-lg-8 col-lg-offset-2">
          <div class="well bs-component">
        
            <fieldset>
              <legend><span class="fa fa-credit-card"></span> Ταμείο | Χρήστης: <?php echo $Owner; ?></legend>


              <div class="form-group">
                                
                <div class="col-lg-10">
                  <h3><p class="text-primary">Το συνολικό χρέος είναι: <abbr title="η συγκεκριμένη τιμή έχει ενημερωθεί τελευταία φορά το προηγούμενο μεσημέρι στις 15:00"><?php echo $Balance; ?>€</abbr></p></h3>
                </div>
              </div>          
              
              <div class="form-group">
                
                <div class="col-lg-10">
                  <div class="input-group">
                    <span class="input-group-addon">€</span>
                    <input class="form-control" type="number" placeholder="ποσό προς κατάθεση" name="money" min="0" max="10000">
                  </div>
                </div>
              </div>          


              <div class="form-group">
                
                <div class="col-lg-10">
                <div class="input-group">
                  <span class="input-group-addon">+</span>
                  <input class="form-control" type="text" rows="3" id="textArea" name="katatheths" placeholder="Ονοματεπώνυμο καταθέτη"></input>
                </div>
                </div>
              </div>

              <div class="form-group">
                
                <div class="col-lg-10">
                <div class="input-group">
                  <span class="input-group-addon">+</span>
                  <input class="form-control" type="text" rows="3" id="textArea" name="paralhpths" placeholder="Ονοματεπώνυμο Υπεύθυνου τομέα"></input>
                  
                </div>
                </div>
              </div>

              <div class="form-group">
                
                <div class="col-lg-10">
                  <textarea class="form-control" rows="3" id="textArea" name="comments" placeholder="Παρατηρήσεις"></textarea>
                  <span class="help-block">Παραπάνω πρέπει να συμπληρωθεί το ποσό και οι συμμετέχοντες στην συναλλαγή και πιθανές παρατηρήσεις.</span>
                </div>
              </div>

              <div class="form-group">
                <div class="col-lg-10">
                  <button type="reset" class="btn btn-default">Cancel</button>
                  <button type="submit" class="btn btn-success">Submit</button>
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
