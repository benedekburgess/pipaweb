<?php
error_reporting(-1);
require_once "inc/init.php";
setcookie('admin');
if($logged_in==false){
	header("Location: ../admin");
}
print_r($_POST);
$query = mysqli_query($mysqli,"SELECT * FROM pipe");
while($row = mysqli_fetch_assoc($query)){
	$mosas = $row['mosas'];
	if($mosas!=0){
		$iter = 0;
	}else{
		$iter++;
	}
}
if(isset($_POST['type']) && isset($_POST['time']) && isset($_POST['sent'])){
	if(isset($_POST['szen')){
		$ujszen = 1;
	}else{
		$ujszen = 0;
	}
	$type = mysqli_real_escape_string($mysqli,$_POST['type']);
	$time = mysqli_real_escape_string($mysqli,$_POST['time']);
	if($type==""){
		header("Location: ../admin");
	}
	if($time=="keszul"){
		$time = time();
	}elseif($time=="van"){
		$time = time()-15*60;
	}elseif($time=="meghalo"){
		$time = time()-45*60;
	}
	mysqli_query($mysqli,"SET NAMES 'utf8'");
	$query = mysqli_query($mysqli,"INSERT INTO pipe (type,ts,user_id,uj_szen) VALUES ('$type','$time','$user_id','$ujszen')");
	add_to_log($mysqli,"add_pipe:$type,$time",$user_id);
	echo mysqli_error($mysqli);
	header("Location: ../");
}else{
	header("Location: ../admin");
}
?>