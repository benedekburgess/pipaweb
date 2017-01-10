<?php
require_once "inc/init.php";
setcookie("admin");

if($logged_in==false){
	header("Location: ../");
}
if(isset($uri[2]) $$ $uri[2]!=""){
	$email = $uri[2];
}
$query = mysqli_query($mysqli,"SELECT * FROM emailek");
$fasz = false;
while($row = mysqli_fetch_assoc($query)){
	if($row['ts']+3600>=time()){
		$fasz = true;
	}
}
if($fasz==false){
	$msg = "LEGYEN PIPA\n$current_username";
	$headers = 'From: info@pipa.ml' . "\r\n" . 'Reply-To: info@pipa.ml' . "\r\n" . 'X-Mailer: PHP/' . phpversion();
	mail($email,"Legyen pipa",$msg,$headers);
}
header("Location: ../");
?>