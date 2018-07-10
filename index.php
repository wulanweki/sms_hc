<?php
session_start();
if(!isset($_SESSION["user"])) echo '<script>window.location = "login.php";</script>';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Staffing Monitoring System</title>

    <!-- Bootstrap -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/custom.css" rel="stylesheet">
    <link href="assets/css/bootstrap-select.min.css" rel="stylesheet">
    <link href="assets/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <link href="assets/css/alertify.min.css" rel="stylesheet">
    <link href="assets/css/themes/semantic.rtl.min.css" rel="stylesheet">
    <link href="assets/css/jquery.dataTables.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
  </head>
  <body>
    <?php 
      include("database.php"); 
      include("header.php"); 
  	 
      $mn = $_GET["mn"];
      if($mn=="1"){
        include("dashboard.php"); 
      }elseif($mn=="2"){
        include("addRequest.php");
      }elseif($mn=="3"){
        include("addCandidate.php"); 
      }elseif($mn=="4"){
        include("talentPool.php"); 
      }elseif($mn=="5"){
        include("candidates.php"); 
      }else{
        include("dashboard.php"); 
      }

    ?>
    <div style="margin-top:30px;">
      &nbsp;
    </div>
    <footer class="navbar-default navbar-fixed-bottom" style="background:#fff; border-color:#F14444; box-shadow:0 0 2px 0 #F14444;">
      <div class="container">
        <div class="navbar-footer">
          <a class="navbar-brand" href="http://edii.local/" target="_blank">
            <span class="glyphicon glyphicon-tower"></span> <b>EDII</b>WIPO.
          </a>
        </div>
        <div class="collapse navbar-collapse" id="navbar-collapse">
          <ul class="nav navbar-nav navbar-right">
            <li>
              <a href="index.php?mn=4">
                <span class="glyphicon glyphicon-registration-mark"></span> Human Capital & Support.
                <span class="sr-only">(current)</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    
    </footer>
	<!-- .content -->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="assets/js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/bootstrap-select.min.js"></script>
    <script src="assets/js/bootstrap-datepicker.min.js"></script>
    <script src="assets/js/alertify.js"></script>
    <script src="assets/js/jquery.dataTables.min.js"></script>
  </body>
</html>