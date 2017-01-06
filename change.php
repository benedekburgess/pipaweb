<?php
require_once "inc/init.php";
setcookie('admin');
if($logged_in==false){
	header("Location: /pipa/admin.php");
}
if(isset($_POST['type']) && isset($_POST['time']) && isset($_POST['sent'])){
	$type = mysqli_real_escape_string($mysqli,$_POST['type']);
	$time = mysqli_real_escape_string($mysqli,$_POST['time']);
	$id=$_POST['sent'];
	$query = mysqli_query($mysqli,"SELECT * FROM pipe WHERE id='$id'");
	while($row = mysqli_fetch_assoc($query)){
		$timestamp = $row['ts'];
		$diff = (time()-$timestamp)/60;
		if($diff>0 && $diff<10){
			$vanpipa = "keszul";
		}elseif($diff>=15 && $diff<45){
			$vanpipa = "van";
		}elseif($diff>=45 && $diff<70){
			$vanpipa = "meghalo";
		}
	}
	if($time!=$vanpipa){
		if($time=="keszul"){
			$time = time();
		}elseif($time=="van"){
			$time = time()-15*60;
		}elseif($time=="meghalo"){
			$time = time()-45*60;
		}
		$query = mysqli_query($mysqli,"UPDATE pipe SET type='$type', ts='$time' WHERE id='$id'");
		add_to_log($mysqli,"change_pipe:type,time",$user_id);
		echo mysqli_error($mysqli);
	}else{
		$query = mysqli_query($mysqli,"UPDATE pipe SET type='$type' WHERE id='$id'");
		add_to_log($mysqli,"change_pipe:type",$user_id);
		echo mysqli_error($mysqli);
	}
	header("Location: /pipa/admin.php");
}
header("Location: /pipa/admin.php");
?>