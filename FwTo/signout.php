<?php include 'db_connect.php';?><!-- σύνδεση με βάση -->

<?php 
session_start();
session_destroy();

// header("Refresh: 2;location:/FwTo/index.html"); //to redirect back to "index.php" after logging out
?>
<script type="text/javascript">
setTimeout(function()
{

   location.href = "/FwTo/index.html";

}, 4000);

</script>

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

<div class="container">

	<div class="alert alert-dismissible alert-success">
	  <button type="button" class="close" data-dismiss="alert">×</button>
	  <i class="fa fa-sign-out" style="font-size: 20px"></i><strong> Μπράβο!</strong> Έχεις αποσυνδεθεί επιτυχώς.
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