<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
require_once "config.php";
$mysqli = mysqli_connect("127.0.0.1",$mysql_user,$mysql_password,"pipa");
mysqli_query($mysqli,"SET NAMES 'utf8'");
function add_user_to_db($username,$password,$admin,$mysqli){
	$salt = "";
	for($i = 0; $i <= 64; $i++){
		$rand = rand(65,90);
		$salt .= chr($rand);
	}
	$username = mysqli_real_escape_string($mysqli,$username);
	$hashed_password = sha1(mysqli_real_escape_string($mysqli,$password));
	$hashed_password .= $salt;
	$hashed_password = sha1($hashed_password);
	$error = mysqli_query($mysqli,"INSERT INTO users (username,password,salt,admin) VALUES ('$username','$hashed_password','$salt','$admin')");
	return mysqli_error($mysqli);
}
if(isset($_SESSION['uid'])){
	$logged_in=true;
	$user_id = mysqli_real_escape_string($mysqli,$_SESSION['uid']);
	$shit = mysqli_query($mysqli,"SELECT * FROM users WHERE id='$user_id'");
	while($row = mysqli_fetch_assoc($shit)){
		$current_username = $row['username'];
		$current_user_admin = $row['admin'];
		$current_su = $row['admin'];
		if($current_su==2){ 
			$current_su = true;
		}else{
			$current_su = false;
		}
	}
}else{
	$logged_in=false;
}
function get_username($id,$mysqli){
	$query = mysqli_query($mysqli,"SELECT * FROM users WHERE id='$id'");
	$row = mysqli_fetch_assoc($query);
	return $row['username'];
}
function add_to_log($mysqli,$data,$user_id){
	$ip = $_SERVER['REMOTE_ADDR'];
	$ts = time();
	$query = mysqli_query($mysqli,"INSERT INTO log (ip,data,ts,user_id) VALUES ('$ip','$data','$ts','$user_id')");
}
if($_SERVER['REMOTE_ADDR']!='152.66.180.120'){
	//exit("buzi");
}
echo $_SERVER['REQUEST_URI'];
$uri = explode($_SERVER['REQUEST_URI'],'/');
?>