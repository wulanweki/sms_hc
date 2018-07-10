<?php
ini_set('display_errors', 1);
session_start();

$user = $_POST["user"];
$pass = $_POST["pass"];

//LOGIN WITH AUTH EMAIL
$server = 'mail01.edi-indonesia.co.id';
$server2 = 'mail.edi-indonesia.co.id';
$email = $user.'@edi-indonesia.co.id';

$access = array('ibnu.ridho','articha.damayanti','heru.prasetyo','ade.rachmi','andri.priambodo','mridwan');


if($user&&$pass){
	if(in_array($user, $access)){
		$box = CheckPOP3($server, $user, $pass);
		if($box){
			// SET SESSION
			$_SESSION["user"] = $user;
			$_SESSION["role"] = 'hcsupport';

			//LOG
			$logFile = fopen("log/log.txt", "a") or die("Loging is missing!");
			$txt = "[".date("Y-m-d h:i:s")."] ".$user." logged in.\n";
			fwrite($logFile, $txt);
			fclose($logFile);
			//LOG

			$response = array(
			    'success' => true,
			    'url' => 'http://www.edii.local/sms_hc/index.php'
			);
		}else{
			$response = array(
			    'success' => false,
			    'url' => 'Invalid credentials, check your email account or password'
			);
		}
	}else{
		$response = array(
			    'success' => false,
			    'url' => 'Access Denied. What are you doing?.'
			);
	}
}else{
	$response = array(
	    'success' => false,
	    'url' => 'Email Account and Password cannot empty'
	);
}

//LOGIN WITH DEFAULT USERNAME & PASSWORD
// if(($user=="billing.pelindo") && ($pass=="billing.pelindo")){
// 	// SET SESSION
// 	$_SESSION["user"] = $user;
// 	$_SESSION["role"] = 'pelindo';
	
	//LOG
	// $logFile = fopen("log/log.txt", "a") or die("Loging is missing!");
	// $txt = "[".date("Y-m-d h:i:s")."] ".$user." logged in.\n";
	// fwrite($logFile, $txt);
	// fclose($logFile);
	//LOG
// 	$response = array(
// 	    'success' => true,
// 	    'url' => 'http://www.edii.local/sms_hc/index.php'
// 	);
// }else{
// 	$response = array(
// 	    'success' => false,
// 	    'url' => 'Invalid Email or Password'
// 	);
// }

echo json_encode($response);


function CheckPOP3($server, $id, $passwd, $port = 110)
{
	// return true;
    // if (empty($server) || empty($id) || empty($passwd))
    //     return false;
    // connect to POP3 Server
    $fs = fsockopen ($server, $port, $errno, $errstr, 5);
    
    // check if connection valid
    if (!$fs)
        return false;
        
    //connected..
    $msg = fgets($fs,256);
    // step 1. send ID
    fputs($fs, "USER $id\r\n");
    $msg = fgets($fs,256);
    
    if (strpos($msg,"+OK")===false)
        return false;
        
    // step 2. send password
    fputs($fs, "PASS $passwd\r\n");
    $msg = fgets($fs,256);
    
    if (strpos($msg,"+OK")===false)
        return false;
    //step 3. auth passwd, QUIT
    fputs($fs, "QUIT \r\n");
    fclose($fs);
    
    return true;
}