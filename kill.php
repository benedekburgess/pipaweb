<?php
require_once "inc/init.php";
setcookie('admin');
if($logged_in==false){
	header("Location: ../admin/12");
}
if(!isset($uri[2]) || $uri[2]==""){
	header("Location: ../admin/12");
}
$id = $uri[2];
$time = time()-7200;
mysqli_query($mysqli,"UPDATE pipe SET ts='$time' WHERE id='$id'");
add_to_log($mysqli,"kill pipe: $id",$user_id);
header("Location: ../admin/pipes");
?>