<?php
require_once "inc/init.php";
setcookie('admin');
if($logged_in==false){
	header("Location: ../admin");
}
if(!isset($_POST['username']) || !isset($_POST['pw1']) || !isset($_POST['pw2'])){
	header("Location: ../admin");
}

$username = mysqli_real_escape_string($mysqli,$_POST['username']);
$pw1 = $_POST['pw1'];
$pw2 = $_POST['pw2'];

if($pw1!=$pw2){
	header("Location: ../admin/failed");
	exit();
}

$pw1 = sha1($pw1);
$salt = "";
for($i = 0; $i <= 64; $i++){
	$rand = rand(65,90);
	$salt .= chr($rand);
}
$pw1 .= $salt;
$password = sha1($pw1);

$query = mysqli_query($mysqli,"SELECT * FROM users WHERE username='$username'");
$row = mysqli_fetch_assoc($query);
$admin = $row['admin'];

if($current_user_admin==2 || $current_username==$username || ($current_user_admin==1 && $admin==false)){
	mysqli_query($mysqli,"UPDATE users SET password='$password', salt='$salt' WHERE username='$username'");
}else{
	add_to_log($mysqli,"fldpwchg",$uid);
	header("Location: ../admin/users/1");
}
add_to_log($mysqli,"chgpw:$username",$uid);
header("Location: ../admin/users/1");
?>