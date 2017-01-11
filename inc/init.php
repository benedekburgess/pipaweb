<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
require_once "config.php";
error_reporting(-1);
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

function testing($value){
	if($value==true){
		if($_SERVER['REMOTE_ADDR']!='152.66.180.120'){
			die("<h1>500 - A weboldal az EU-n belül nem érhető el :(</h1>");
		}
	}
}
testing(true);
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
		$current_nick = $row['nick'];
	}
}else{
	$logged_in=false;
}
function get_username($id,$mysqli){
	$query = mysqli_query($mysqli,"SELECT * FROM users WHERE id='$id'");
	$row = mysqli_fetch_assoc($query);
	if($id==0){
		return "unknown";
	}
	return $row['username'];
}
function get_ip($ip,$mysqli){
	$query = mysqli_query($mysqli,"SELECT * FROM iptable WHERE ip='$ip'");
	$row = mysqli_fetch_assoc($query);
	if(mysqli_num_rows($query)<1){
		return $ip;
	}else{
		return $row['name'];
	}
}

function add_to_log($mysqli,$data,$user_id){
	$ip = $_SERVER['REMOTE_ADDR'];
	$ts = time();
	$query = mysqli_query($mysqli,"INSERT INTO log (ip,data,ts,user_id) VALUES ('$ip','$data','$ts','$user_id')");
}
if($_SERVER['REMOTE_ADDR']!='152.66.180.120'){
	//exit("buzi");
}
$uri = explode('/',$_SERVER['REQUEST_URI']);
?>