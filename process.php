<?php
session_start();
include("database.php");

if(isset($_REQUEST)){
	$userLogin = $_POST["userLogin"];
	$typeSave = $_POST["typeSave"];
	
	if($typeSave=="request"){
		$req_number = $_POST["reqNumber"];
		$division = $_POST["division"];
		$pic = $_POST["pic"];
		$position = $_POST["position"];
		$detail_pos = $_POST["detPosition"];
		$qty = $_POST["qty"];
		$deadline = $_POST["deadlineDate"];

		$sqlIns = "INSERT INTO sm_hc_request (req_date, req_number, division, pic, position, detail_pos, qty, deadline, status, created_by)
					VALUES('".date('Y-m-d h:i:s')."','$req_number', $division, '$pic', $position, '$detail_pos', $qty, '$deadline',0,'$userLogin')";
		// echo $sqlIns; die();
		$ins = $conn->query($sqlIns);

		if($ins){
			echo "true";
		}else{
			echo "false";
		}

		//LOG
		$logFile = fopen("log/log.txt", "a") or die("Loging is missing!");
		$txt = "[".date("Y-m-d h:i:s")."] ".$userLogin." add staff request.\n";
		fwrite($logFile, $txt);
		fclose($logFile);
		//LOG

	}elseif($typeSave=="candidate"){
		$req_id = $_POST["req_id"];
		$name = $_POST["name"];
		$email = $_POST["email"];
		$gender = $_POST["gender"];
		$phone = $_POST["phone"];
		$address = $_POST["address"];
		echo $typeSave;
		$sqlIns = "INSERT INTO sm_hc_candidate (req_id, name, email, gender, phone, address, status, created_by)
					VALUES($req_id, '$name', '$email', $gender, '$phone', '$address', 0, '$userLogin')";

		// $ins = $conn->query($sqlIns);
		// $id_cad = $conn->insert_id;

		// UPLOAD
		// $path = "files/";

		// 	echo $path;
		// if(isset($_FILES["cv"])){
		// 	$filename = $_FILES["file"]["name"];
		// 	$tmp = $_FILES["file"]["tmp_name"];

		// 	$et = strtolower(pathinfo($filename, PATHINFO_EXTENTION));

		// 	$final_image = rand(1000,1000000).$img;
 
		// 	// check's valid format
		// 	if(in_array($ext, $valid_extensions)) {     
		// 		$path = $path.strtolower($final_image); 
				
		// 		if(move_uploaded_file($tmp,$path)) {
		// 			echo "<img src='$path' />";
		// 		}
		// 	}else{
		// 		echo 'invalid file';
		// 	}
		// }

		// UPLOAD

		// if($ins){
		// 	$sqlUpd = "UPDATE sm_hc_request SET status = 1, updated_by = '$userLogin' WHERE id = $req_id";
		// 	$upd = $conn->query($sqlUpd);
			
		// 	echo "true";
		// }else{
		// 	echo "false";
		// }

		//LOG
		$logFile = fopen("log/log.txt", "a") or die("Loging is missing!");
		$txt = "[".date("Y-m-d h:i:s")."] ".$userLogin." add candidate for req_id : ".$req_id.".\n";
		fwrite($logFile, $txt);
		fclose($logFile);
		//LOG

	}elseif($typeSave=="rejectReq"){
		$req_id = $_POST["req_id"];
		
		$sqlUpd = "UPDATE sm_hc_request SET status = 2, updated_by = '$userLogin' WHERE id = $req_id";
		// echo $sqlUpd; die();
		$upd = $conn->query($sqlUpd);

		if($upd){
			echo "true";
		}else{
			echo "false";
		}		

		//LOG
		$logFile = fopen("log/log.txt", "a") or die("Loging is missing!");
		$txt = "[".date("Y-m-d h:i:s")."] ".$userLogin." reject the staff request, req_id : ".$req_id.".\n";
		fwrite($logFile, $txt);
		fclose($logFile);
		//LOG

	}elseif($typeSave=="roolbackReq"){
		$req_id = $_POST["req_id"];
		
		$sqlUpd = "UPDATE sm_hc_request SET status = 1, updated_by = '$userLogin' WHERE id = $req_id";
		// echo $sqlUpd; die();
		$upd = $conn->query($sqlUpd);

		if($upd){
			echo "true";
		}else{
			echo "false";
		}		

		//LOG
		$logFile = fopen("log/log.txt", "a") or die("Loging is missing!");
		$txt = "[".date("Y-m-d h:i:s")."] ".$userLogin." roolback the staff request, req_id : ".$req_id.".\n";
		fwrite($logFile, $txt);
		fclose($logFile);
		//LOG

	}elseif($typeSave=="finishReq"){
		$req_id = $_POST["req_id"];
		
		$sqlUpd = "UPDATE sm_hc_request SET status = 3, updated_by = '$userLogin' WHERE id = $req_id";
		// echo $sqlUpd; die();
		$upd = $conn->query($sqlUpd);

		if($upd){
			echo "true";
		}else{
			echo "false";
		}

		//LOG
		$logFile = fopen("log/log.txt", "a") or die("Loging is missing!");
		$txt = "[".date("Y-m-d h:i:s")."] ".$userLogin." finish the staff request, req_id : ".$req_id.".\n";
		fwrite($logFile, $txt);
		fclose($logFile);
		//LOG

	}elseif($typeSave=="setSfPT"){
		$req_id = $_POST["req_id"];
		$sfpt = $_POST["sfpt"];

		$sqlUpd = "UPDATE sm_hc_request SET sfpt = $sfpt, updated_by = '$userLogin' WHERE id = $req_id";
		// echo $sqlUpd; die();
		$upd = $conn->query($sqlUpd);

		if($upd){
			echo "true";
		}else{
			echo "false";
		}

		//LOG
		$logFile = fopen("log/log.txt", "a") or die("Loging is missing!");
		$txt = "[".date("Y-m-d h:i:s")."] ".$userLogin." set Standard Value for Practical Test.\n";
		fwrite($logFile, $txt);
		fclose($logFile);
		//LOG
	}elseif($typeSave=="testResult"){
		$userLogin = $_POST["userLogin"];
		$req_id = $_POST["req_id"];
		$cad_id = $_POST["cad_id"];

		$a = 0;
		foreach ($cad_id as $key => $cid) {
			$sqlUpd = "UPDATE sm_hc_candidate SET 
							tpa = ".$_POST["tpa"][$a].", 
							practical = ".$_POST["practical"][$a].",
							psikotest = ".$_POST["psikotes"][$a].",
							interview = ".$_POST["interview"][$a]."
							WHERE id = ".$_POST["cad_id"][$a];

			$upd = $conn->query($sqlUpd);

			$a++;
		}

		if($upd){
			echo "true";
		}else{
			echo "false";
		}

		//LOG
		$logFile = fopen("log/log.txt", "a") or die("Loging is missing!");
		$txt = "[".date("Y-m-d h:i:s")."] ".$userLogin." input test result for request id : .".$req_id."\n";
		fwrite($logFile, $txt);
		fclose($logFile);
		//LOG
	}elseif($typeSave=="switchCan"){
		$userLogin = $_POST["userLogin"];
		$req_id = $_POST["req_id"];
		$cad_id = $_POST["cad_id"];

		$sqlUpd = "UPDATE sm_hc_candidate SET req_id = ".$req_id." WHERE id = ".$cad_id;
		// echo $sqlUpd;
		$upd = $conn->query($sqlUpd);

		if($upd){
			echo "true";
		}else{
			echo "false";
		}

		//LOG
		$logFile = fopen("log/log.txt", "a") or die("Loging is missing!");
		$txt = "[".date("Y-m-d h:i:s")."] ".$userLogin." switch candidate id : ".$cad_id." to request id : .".$req_id."\n";
		fwrite($logFile, $txt);
		fclose($logFile);
		//LOG
	}elseif($typeSave=="switchTalentPool"){
		$userLogin = $_POST["userLogin"];
		$req_id = $_POST["req_id"];
		$cad_id = $_POST["cad_id"];

		$sqlUpd = "INSERT INTO sm_hc_candidate (req_id, name, email, gender, address, phone, status, cvfile, created_by)
					(SELECT $req_id, name, email, gender, address, phone, 0, cvfile, '$userLogin' FROM sm_hc_talentpool WHERE id = ".$cad_id.")";
		$upd = $conn->query($sqlUpd);

		$sqlDel = "DELETE FROM sm_hc_talentpool WHERE id = ".$cad_id;
		$del = $conn->query($sqlDel);

		if($upd){
			echo "true";
		}else{
			echo "false";
		}

		//LOG
		$logFile = fopen("log/log.txt", "a") or die("Loging is missing!");
		$txt = "[".date("Y-m-d h:i:s")."] ".$userLogin." switch talent pool id : ".$cad_id." to request id : .".$req_id."\n";
		fwrite($logFile, $txt);
		fclose($logFile);
		//LOG
	}elseif($typeSave=="setComment"){
		$userLogin = $_POST["userLogin"];
		$cad_id = $_POST["cad_id"];
		$comment = $_POST["comment"];

		$sqIns = "INSERT INTO sm_hc_comment (cad_id, comment, created_by) VALUES ('".$cad_id."','".$comment."', '".$userLogin."')";
		$ins = $conn->query($sqIns);

		if($ins){
			echo "true";
		}else{
			echo "false";
		}

		//LOG
		$logFile = fopen("log/log.txt", "a") or die("Loging is missing!");
		$txt = "[".date("Y-m-d h:i:s")."] ".$userLogin." comment to candidate id : ".$cad_id."\n";
		fwrite($logFile, $txt);
		fclose($logFile);
		//LOG
	}elseif($typeSave=="getComments"){
		$userLogin = $_POST["userLogin"];
		$cad_id = $_POST["cad_id"];

		$sqGetComment = "SELECT comment, created_by, DATE_FORMAT(created_at, '%d %M %Y %h:%i:%s') created_at FROM sm_hc_comment WHERE cad_id = ".$cad_id." ORDER BY created_at DESC";
		$comments = $conn->query($sqGetComment);

		if ($comments->num_rows > 0) {
			$no = 1;
			$getComments = "";
			while($rowComment = $comments->fetch_assoc()) {
				$getComments = $getComments.$no.". <label>".$rowComment["comment"]. " </label><small> by <i>".$rowComment["created_by"]."</i> at <i>".$rowComment["created_at"]."</i></small><br>";
				$no++;
			}
		}else{
			$getComments = "<i>No comment yet. Leave a comment for this candidate</i>";
		}
		
		echo $getComments;
	}
	
}

$conn->close();