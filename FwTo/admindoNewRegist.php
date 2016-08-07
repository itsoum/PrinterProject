<?php include 'db_connect.php';?><!-- σύνδεση με βάση -->

<?php

  session_start();
  include 'unacceptedAdminLevel.php'; // μη αποδεκτή κίνηση


  $Id = $_SESSION['Id'];
  $user = $_SESSION["Owner"];
  
  $IdUser = $_POST["id"];
  $pass = $_POST["password1"];
  $owner = $_POST["owner"];
  $mail = $_POST["mail"];
  $cred = $_POST["cred"];
    
  $sql = "INSERT IGNORE INTO Users (Id, Password, Owner, Credentials, mail) VALUES ('$IdUser', '$pass', '$owner', '$cred', '$mail')";
  $result = mysqli_query($mysqli, $sql, MYSQLI_USE_RESULT)
  or die("Error: ".mysqli_error($mysqli));

  $sql2 = "INSERT IGNORE INTO Bill (IdUser, Balance, Last_Auto) VALUES ('$IdUser', 0, 0)";
  $result2 = mysqli_query($mysqli, $sql2, MYSQLI_USE_RESULT)
  or die("Error: ".mysqli_error($mysqli));
  
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





<!-- start -->  

  <div class="container">
    <div class="jumbotron">
      <h1>Τα κατάφερες!</h1>
      <p>Ο χρήστης <?php echo $owner; ?> καταχωρήθηκε με επιτυχία</p>
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
