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
    <title>Billing Reporting</title>

    <!-- Bootstrap -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/custom.css" rel="stylesheet">
    <style>
      /* Start by setting display:none to make this hidden.
         Then we position it in relation to the viewport window
         with position:fixed. Width, height, top and left speak
         for themselves. Background we set to 80% white with
         our animation centered, and no-repeating */
      .modal {
          display:    none;
          position:   fixed;
          z-index:    1000;
          top:        0;
          left:       0;
          height:     100%;
          width:      100%;
          background: rgba( 255, 255, 255, .8 ) 
                      url('assets/img/Preloader_6.gif') 
                      50% 50% 
                      no-repeat;
      }

      /* When the body has the loading class, we turn
         the scrollbar off with overflow:hidden */
      body.loading {
          overflow: hidden;   
      }

      /* Anytime the body has the loading class, our
         modal element will be visible */
      body.loading .modal {
          display: block;
      }
    </style>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body onload="getSumTrafficPelindoThisMonth()">
  	<!-- .navbar -->
  <?php include("header.php"); ?>
	
	<!-- .content -->
  	<div class="container">
  		<div class="row">
  			<div class="col-md-3">
  				<div class="list-group">
            <?php
            $displayPeriode = date("F-Y", strtotime( date( "Y-m-d" ) . "-1 month" ) );
            $mPeriode = date("m", strtotime( date( "Y-m-d" ) . "-1 month" ) );
            $yPeriode = date("Y", strtotime( date( "Y-m-d" ) . "-1 month" ) );
            ?>
            <a class="list-group-item active"><h4><b>Periode <?php echo $displayPeriode ?></b></h4></a>
  					<a class="list-group-item">COCOCONT <span id="cococont" class="badge"> 0 </span></a>
  					<a class="list-group-item">COCOKMS <span id="cocokms" class="badge"> 0 </span> </a>
  					<a class="list-group-item">DOKMANIF <span id="dokmanif" class="badge"> 0 </span> </a>
  					<a class="list-group-item">RESMANIF <span id="resmanif" class="badge"> 0 </span> </a>
  					<a class="list-group-item">DOKRKSP <span id="dokrksp" class="badge"> 0 </span> </a>
  					<a class="list-group-item">RESRKSP <span id="resrksp" class="badge"> 0 </span> </a>
  					<a class="list-group-item">DOKPLP <span id="dokplp" class="badge"> 0 </span> </a>
  					<a class="list-group-item">RESPLP <span id="resplp" class="badge"> 0 </span> </a>
  					<a class="list-group-item">DOKSPPB <span id="doksppb" class="badge"> 0 </span> </a>
  				</div>
  			</div>
  			<div class="col-md-9">
          <div class="col-md-12">
            <div class="form-group">
              <label>&nbsp;</label><br>
              <a class="btn btn-default btn-success" href="#" onclick="getRepTrafficPelindo(<?php echo "'".$mPeriode."'" ?>,<?php echo $yPeriode ?>)">Generate Report Billing (Excel) Periode <?php echo $displayPeriode ?></a>
            </div>
            <hr>
          </div>
          
          <div class="col-md-6">
            <div class="form-group">
              <label>Select Month</label>
              <select class="form-control" id="month">
                <option value="01">January</option>
                <option value="02">February</option>
                <option value="03">March</option>
                <option value="04">April</option>
                <option value="05">May</option>
                <option value="06">June</option>
                <option value="07">July</option>
                <option value="08">August</option>
                <option value="09">September</option>
                <option value="10">October</option>
                <option value="11">November</option>
                <option value="12">December</option>
              </select>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label>Select Year</label>
              <select class="form-control" id="year">
                <option value="2016">2016</option>
                <option value="2017">2017</option>
                <option value="2018">2018</option>
                <option value="2019">2019</option>
                <option value="2020">2020</option>
              </select>
            </div>
          </div>
            
          <div class="col-md-6">
            <div class="form-group">
              <a class="btn btn-default btn-warning" href="#" onclick="getRepTrafficPelindo(document.getElementById('month').value, document.getElementById('year').value)">Generate Report Billing (Excel)</a>
            </div>
          </div>
        </div>
  		</div>
  	</div>
    <div class="modal" id="modal">
      <div>Generating report ...</div>
    </div>
    <?php
      $periode = date("Ym") -1;
    ?>
    <script>
      function getSumTrafficPelindoThisMonth() {
        $("#modal").show();
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                var obj = JSON.parse(xmlhttp.responseText);
                $("#modal").hide();
                // alert(count(obj))

                var c = 0;
                var type = "";
                var val = "";
                for (var dt in obj) {                  
                  type = obj[c].aprf;
                  // alert(type.toLowerCase());
                  document.getElementById(type.toLowerCase()).innerHTML = obj[c].sum;
                  ++c;
                }
                // document.getElementById("cocokms").innerHTML = obj[1].sum;
                // document.getElementById("dokmanif").innerHTML = obj[2].sum;
                // document.getElementById("dokplp").innerHTML = obj[3].sum;
                // document.getElementById("dokrksp").innerHTML = obj[4].sum;
                // document.getElementById("dokspbb").innerHTML = obj[5].sum;
                // document.getElementById("resmanif").innerHTML = obj[6].sum;
                // document.getElementById("resplp").innerHTML = obj[7].sum;
                // document.getElementById("resrksp").innerHTML = obj[8].sum;
            }else{
              // $("#modal").hide();
            }
        };
        xmlhttp.open("GET", "http://10.1.5.137/service/getSumTrafficPelindoThisMonth/" + <?php echo $periode ?>, true);
        xmlhttp.send();
      }

      function getRepTrafficPelindo(m,y){
        $("#modal").show();
        $.ajax({
          type: "POST",
          url: "http://10.1.5.137/service/getRepTrafficPelindo",
          headers:{
           Authorization: 'Bearer 81DDLhNX3XwTnJDtFKeS75EItcQAzNaZ7HKiUIqK'
          },
          data: {
              month: m,
              year: y
          },
          success: function (response) {
            var obj = JSON.parse(response);
            $("#modal").hide();

            <?php
              //LOG
              $logFile = fopen("log/log.txt", "a") or die("Loging is missing!");
              $txt = "[".date("Y-m-d h:i:s")."] ".$_SESSION["user"]." download Pelindo traffic report.\n";
              fwrite($logFile, $txt);
              fclose($logFile);
              //LOG
            ?>

            window.open(obj["url"], '_self');
          },
          error: function(){
            $("#modal").hide();
          }
        });
      }

    </script>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="assets/js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="assets/js/bootstrap.min.js"></script>
  </body>
</html>