<?php
require_once "inc/init.php";
setcookie('admin');
if($logged_in==false){
	header("Location: ../admin");
	exit();
}
if(isset($uri[2]) && $uri[2]!=""){
	$name = mysqli_real_escape_string($mysqli,$uri[2]);
	$query = mysqli_query($mysqli,"SELECT * FROM info WHERE name='$name'");
	
		echo mysqli_error($mysqli);
	if(mysqli_num_rows($query)==1){
		$row = mysqli_fetch_assoc($query);
		$set = $row['description'];
		if($set=="vanelado"){
			$set = "true";
		}elseif($set=="true"){
			$set = "nemelado";
		}elseif($set=="nemelado"){
			$set = "false";
		}else{
			$set = "vanelado";
		}
		$query = mysqli_query($mysqli,"UPDATE info SET description='$set' WHERE name='$name'");
		echo mysqli_error($mysqli);
		add_to_log($mysqli,"chgstt:$name",$user_id);
	}
}
header("Location: ../admin");
?>