<?php
session_start();

$userLogin = $_POST["userLogin"];

//LOG
$logFile = fopen("log/log.txt", "a") or die("Loging is missing!");
$txt = "[".date("Y-m-d h:i:s")."] ".$userLogin." logged out from site.\n";
fwrite($logFile, $txt);
fclose($logFile);
//LOG

// remove all session variables
session_unset(); 

// destroy the session 
session_destroy(); 


$url = "login.php";
// header('Location: login.php');
echo '<script>window.location = "'.$url.'";</script>';
?>