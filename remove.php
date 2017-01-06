<?php
require_once "inc/init.php";
setcookie('admin');
if($logged_in==false){
	header("Location: ../admin/12");
}
if(!isset($uri[1])){
	header("Location: ../admin/12");
}
$id = $uri[1];
mysqli_query($mysqli,"DELETE FROM pipe WHERE id='$id'");
add_to_log($mysqli,"remove_pipe:$id",$user_id);
header("Location: ../admin/pipes");
?>