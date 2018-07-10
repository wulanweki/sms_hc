<?php
session_start();
if(isset($_SESSION["user"])) {
	echo '<script>window.location = "index.php";</script>';
}
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
		
		<style>
			.wrapper {    
				margin-top: 80px;
				margin-bottom: 20px;
			}

			.form-signin {
			  max-width: 420px;
			  padding: 30px 38px 66px;
			  margin: 0 auto;
			  background-color: #eee;
			  border: 3px dotted rgba(0,0,0,0.1);  
			  }

			.form-signin-heading {
			  text-align:center;
			  margin-bottom: 30px;
			}

			.form-control {
			  position: relative;
			  font-size: 16px;
			  height: auto;
			  padding: 10px;
			}

			input[type="text"] {
			  margin-bottom: 0px;
			  border-bottom-left-radius: 0;
			  border-bottom-right-radius: 0;
			}

			input[type="password"] {
			  margin-bottom: 20px;
			  border-top-left-radius: 0;
			  border-top-right-radius: 0;
			}

			.colorgraph {
			  height: 7px;
			  border-top: 0;
			  background: #c4e17f;
			  border-radius: 5px;
			  background-image: -webkit-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
			  background-image: -moz-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
			  background-image: -o-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
			  background-image: linear-gradient(to right, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
			}

			.modal {
				display:    none;
				position:   fixed;
				z-index:    1000;
				top:        0;
				left:       0;
				height:     100%;
				width:      100%;
				background: rgba( 255, 255, 255, .8 ) 
				          url('assets/img/loading1.gif') 
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

			.errmsg{
				color: red;
				font-weight: bold;
				text-align: center;
			}
		</style>
	</head>
	<body>
		<div class = "container">
			<div class="wrapper">
				<form method="post" name="Login_Form" class="form-signin">       
					<h3 class="form-signin-heading"><b>Staff</b><i>ing</i> <b>Monitoring System</b></h3>
					<hr class="colorgraph"><br>

					<input type="text" class="form-control" id="username" name="Username" placeholder="Email Account" required="" autofocus="" />
					<input type="password" class="form-control" id="password" name="Password" placeholder="Password" required=""/>     		  

					<button class="btn btn-lg btn-primary btn-block"  name="Submit" value="Login" type="Button" onclick="get_login()">Login</button>  			
					<div class="errmsg">
						<span id="errmsg"></span>
					</div>
				</form>			
			</div>
		</div>	
		<div class="modal" id="modal"><!-- Place at bottom of page --></div>
		
		<script>
			function get_login(m,y){
		        $("#modal").show();
		        $.ajax({
		          type: "POST",
		          // url: "http://community.edi-indonesia.co.id/service/billing_reporting_login",
		          url: "get_login.php",
		          data: {
		              user: document.getElementById("username").value,
		              pass: document.getElementById("password").value
		          },
		          success: function (response) {
		            var obj = JSON.parse(response);
		            $("#modal").hide();
		            if(obj["success"]==true){
		            	window.open(obj["url"], '_self' );
		            }else{
                		document.getElementById("errmsg").innerHTML = obj["url"];
                		// document.getElementById("password").value = "";
		            }
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
