<?php
require_once "inc/init.php";
setcookie('admin');
if($logged_in==false){
	header("Location: /pipa/admin.php");
}
$query = mysqli_query($mysqli,"SELECT * FROM pipe");
while($row = mysqli_fetch_assoc($query)){
	$mosas = $row['mosas'];
	if($mosas!=0){
		$iter = 0;
	}else{
		$iter++;
	}
}
if($iter>3){
	header("Location: /pipa/admin.php");
}
if(isset($_POST['type']) && isset($_POST['time']) && isset($_POST['sent'])){
	$type = mysqli_real_escape_string($mysqli,$_POST['type']);
	$time = mysqli_real_escape_string($mysqli,$_POST['time']);
	if($type==""){
		header("Location: /pipa/admin.php");
	}
	if($time=="keszul"){
		$time = time();
	}elseif($time=="van"){
		$time = time()-15*60;
	}elseif($time=="meghalo"){
		$time = time()-45*60;
	}
	echo $time;
	mysqli_query($mysqli,"SET NAMES 'utf8'");
	$query = mysqli_query($mysqli,"INSERT INTO pipe (type,ts,user_id) VALUES ('$type','$time','$user_id')");
	add_to_log($mysqli,"add_pipe:$type,$time",$user_id);
	echo mysqli_error($mysqli);
	header("Location: /pipa");
}else{
	header("Location: /pipa/admin.php");
}
?>