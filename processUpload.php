<?php
session_start();
include("database.php");

$source = $_POST["source"];
$typeSave = $_POST["typeSave"];
$userLogin = $_POST["userLogin"];

if($source=="1"){
	$name = $_POST["name"];
	$email = $_POST["email"];
	$gender = $_POST["gender"];
	$phone = $_POST["phone"];
	$address = $_POST["address"];

}elseif($source=="2"){
	$employee = $_POST["employee"];

	$sqlGetProf = "SELECT nama, email, alamat, nohp, CASE WHEN jk = 'L' THEN 1 WHEN jk = 'P' THEN 2 ELSE 1 END gender 
				FROM tb_datapribadi WHERE nik = '$employee' AND atasan1 <> '0000000'";

	$dataEmployee = $conn->query($sqlGetProf);

	if ($dataEmployee->num_rows > 0) {
		while($rowEmployee = $dataEmployee->fetch_assoc()) {
			$name = $rowEmployee["nama"];
			$email = $rowEmployee["email"];
			$gender = $rowEmployee["gender"];
			$phone = $rowEmployee["nohp"];
			$address = $rowEmployee["alamat"];
		}
	}else{
		echo false;
	}

}else{
	echo false;
}

if($typeSave=="addCandidate"){
	$req_id = $_POST["req_id"];
	$tblSave = "sm_hc_candidate";

	$sqlIns = "INSERT INTO sm_hc_candidate (req_id, name, email, gender, phone, address, status, created_by)
 			VALUES($req_id, '$name', '$email', $gender, '$phone', '$address', 0, '$userLogin')";
}elseif($typeSave=="addTalentPool"){
	$req_id = "0";
	$tblSave = "sm_hc_talentpool";
	$resource = $_POST["resource"];

	$sqlIns = "INSERT INTO sm_hc_talentpool (name, email, gender, phone, address, status, created_by, resource)
 			VALUES('$name', '$email', $gender, '$phone', '$address', 0, '$userLogin', '$resource')";
}

$ins = $conn->query($sqlIns);
$cad_id = $conn->insert_id;

// UPLOAD
$valid_extensions = array('pdf', 'doc', 'docx');
$path = "files/";

if(isset($_FILES["file"])){
	$filename = $cad_id."_".strtoupper($name)."_".$_FILES["file"]["name"];
	$tmp = $_FILES["file"]["tmp_name"];

	$ext = end(explode(".",basename($_FILES["file"]["name"])));

	// check's valid format
	if(in_array($ext, $valid_extensions)) {     
		if(move_uploaded_file($tmp,$path.$filename)) {
			$sqlUpd = "UPDATE $tblSave SET cvfile = '$filename', updated_by = '$userLogin' WHERE id = $cad_id";
			$upd = $conn->query($sqlUpd);
			$ins = true;
		}else{
			$sqlDel = "DELETE FROM $tblSave WHERE id = $cad_id";
			$upd = $conn->query($sqlDel);
			$ins = false;
		}
	}else{
		$sqlDel = "DELETE FROM $tblSave WHERE id = $cad_id";
		$upd = $conn->query($sqlDel);
		$ins = false;
	}
}

// UPLOAD

if($ins){
	if($typeSave=="addCandidate"){
		$sqlUpd = "UPDATE sm_hc_request SET status = 1, updated_by = '$userLogin' WHERE id = $req_id";
		$upd = $conn->query($sqlUpd);
	}
	
	echo "true";
}else{
	echo "false";
}

//LOG
$logFile = fopen("log/log.txt", "a") or die("Loging is missing!");
$txt = "[".date("Y-m-d h:i:s")."] ".$userLogin." add candidate for req_id : ".$req_id.".\n";
fwrite($logFile, $txt);
fclose($logFile);
//LOG



$conn->close();