<?php
require_once "inc/init.php";
setcookie('admin');
setcookie("uid");
unset($_SESSION['uid']);
add_to_log($mysqli,"logout:$user_id",$user_id);
header("Location: ../");
?>