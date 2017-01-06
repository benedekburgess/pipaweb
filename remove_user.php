<?php
require_once "inc/init.php";
setcookie('admin');
if($logged_in==false){
	header("Location: ../admin/12");
}
if(!isset($uri[1])){
	header("Location: ../admin/12");
}
if($current_user_admin!=1){
	header("Location: ../admin/12");
}
$id = $uri[1];
mysqli_query($mysqli,"DELETE FROM users WHERE id='$id'");
add_to_log($mysqli,"remove_user:$id",$user_id);
header("Location: ../admin/users");
?>