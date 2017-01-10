<?php
require_once "inc/init.php";
setcookie('admin');
if($logged_in==false){
	header("Location: ../admin");
}

$username=$uri[2];



$query = mysqli_query($mysqli,"SELECT * FROM users WHERE username='$username'");
$row = mysqli_fetch_assoc($query);
$admin = $row['admin'];

if($admin==2){
	header("Location: ../admin/users");
}

if($admin==1){
	$admin = 0;
}else{
	$admin = 1;
}

if($current_user_admin==2){
	mysqli_query($mysqli,"UPDATE users SET admin='$admin' WHERE username='$username'");
}else{
	add_to_log($mysqli,"failed_admin_chg",$uid);
	header("Location: ../admin/users");
}
add_to_log($mysqli,"chgadmin:$username",$uid);
header("Location: ../admin/users");
exit();
?>