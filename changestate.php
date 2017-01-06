<?php
require_once "inc/init.php";
setcookie('admin');
if($logged_in==false){
	header("Location: ../admin");
}
if(isset($_GET['name'])){
	$name = mysqli_real_escape_string($mysqli,$_GET['name']);
	$query = mysqli_query($mysqli,"SELECT * FROM info WHERE name='$name'");
	
		echo mysqli_error($mysqli);
	if(mysqli_num_rows($query)==1){
		$row = mysqli_fetch_assoc($query);
		$set = $row['description'];
		if($set=="true"){
			$set = "nemelado";
		}elseif($set=="nemelado"){
			$set = "false";
		}else{
			$set = "true";
		}
		$query = mysqli_query($mysqli,"UPDATE info SET description='$set' WHERE name='$name'");
		echo mysqli_error($mysqli);
		add_to_log($mysqli,"change_state:$name",$user_id);
	}
}
header("Location: ./admin");
?>