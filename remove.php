<?php
require_once "inc/init.php";
setcookie('admin');
if($logged_in==false){
	header("Location: /pipa/admin.php?szarvagy=12");
}
if(!isset($_GET['id'])){
	header("Location: /pipa/admin.php?szarvagy=12");
}
$id = $_GET['id'];
mysqli_query($mysqli,"DELETE FROM pipe WHERE id='$id'");
add_to_log($mysqli,"remove_pipe:$id",$user_id);
header("Location: /pipa/admin.php?mode=pipes");
?>