<?php
require_once "inc/init.php";
setcookie('admin');
if($logged_in==false){
	header("Location: ../admin/12");
}
if($current_user_admin!=1){
	header("Location: ../admin/12");
}
if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['password2'])){
	if(!isset($_POST['admin']) || $current_su==false){
		$admin = 0;
	}else{
		$admin = 1;
	}
	$username = strip_tags($_POST['username']);
	$password = strip_tags($_POST['password']);
	$password2 = strip_tags($_POST['password2']);
	if($password!=$password2 || $password=="" || $username==""){
		header("Location: ../admin/users/password");
		exit();
	}
	$query = mysqli_query($mysqli,"SELECT * FROM users WHERE username='$username'");
	
	if(mysqli_num_rows($query)!=0){
		header("Location: ../admin/users/sername");
		exit();
	}
	$username = mysqli_real_escape_string($mysqli,$username);
	$password = mysqli_real_escape_string($mysqli,$password);
	add_user_to_db($username,$password,$admin,$mysqli);
	add_to_log($mysqli,"addusr:$username",$user_id);
	header("Location: ../admin/users");
}else{
	header("Location: ../admin/users");
}
?>