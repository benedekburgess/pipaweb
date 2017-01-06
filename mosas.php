<?php
require_once "inc/init.php";
setcookie('admin');
if($logged_in==false){
	header("Location: ../admin");
}
$query = mysqli_query($mysqli,"SELECT * FROM pipe");
while($row = mysqli_fetch_assoc($query)){
	$utso = $row['id'];
}
$query = mysqli_query($mysqli,"UPDATE pipe SET mosas=1 WHERE id='$utso'");
echo mysqli_error($mysqli);
header("Location: ../admin");
?>