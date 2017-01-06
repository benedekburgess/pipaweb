<?php
require_once "inc/init.php";
setcookie("admin");

if($logged_in==false){
	header("Location: ../");
}

$query = mysqli_query($mysqli,"SELECT * FROM emailek");
$fasz = false;
while($row = mysqli_fetch_assoc($query)){
	if($row['ts']+3600>=time()){
		$fasz = true;
	}
}
if($fasz==false){
	$msg = "<b>LEGYEN PIPA</b><br><i>$current_username</i>";
	mail("benedekb97@gmail.com","Legyen pipa",$msg);
}
header("Location: ../");
?>