<?php
require_once "inc/init.php";
setcookie('admin');
$username = mysqli_real_escape_string($mysqli,$_POST['username']);
$password = mysqli_real_escape_string($mysqli,$_POST['password']);
if(strlen($username)>99){
	header("Location: /pipa");
}
if(strlen($password)>99){
	header("Location: /pipa");
}
switch($username){
	case "thomas":
	$szar = 65;
	break;
	case "angus":
	$szar = 99;
	break;
	case "bob a fat":
	$szar = 723;
	break;
	case "saci":
	$szar = 873;
	break;
	case "erik":
	$szar = 123;
	break;
	case "pocok":
	$szar = 433;
	break;
	case "töröttkerámia":
	$szar = 466;
	break;
	case "qpa":
	$szar = 8496;
	break;
	case "sajt":
	$szar = 74555;
	break;
	case "kenyer":
	$szar = 136786;
	break;
	case "dildo":
	$szar = 9745;
	break;
	case "csanád":
	$szar = 69;
	break;
	case "":
	$szar = 1;
	break;
	case "sztyúp":
	$szar = 941111;
	break;
	case "purkess":
	$szar = 123456789;
	break;
	/*case "beni":
	$szar = 123456789;
	break;*/
	case "picimaci":
	$szar = 486532;
	break;
	case "koza":
	$szar = 75421;
	break;
	case "kápor":
	$szar = 1895651;
	break;
	case "tuti":
	$szar = 0;
	break;
	case "navi":
	$szar = 8522;
	break;
	case "pufi":
	$szar = 741258;
	break;
	case "ricsi":
	$szar = 115588;
	break;
	case "mózes":
	$szar = 789654;
	break;
	case "turha":
	$szar = 56285;
	break;
	case "pepito":
	$szar = 55996;
	break;
	case "bubi":
	$szar = 786121;
}
$query = mysqli_query($mysqli,"SELECT * FROM users WHERE username='$username'");
while($row = mysqli_fetch_assoc($query)){
	$db_pw = $row['password'];
	$db_salt = $row['salt'];
	$db_id = $row['id'];
}
if(isset($db_salt)){
	$hashed_pw = sha1($password);
	$hashed_pw .= $db_salt; echo "<br>";
	echo $hashed_pw = sha1($hashed_pw);
	if($hashed_pw == $db_pw){
		setcookie("uid",$db_id);
		$_SESSION['uid'] = $db_id;
		add_to_log($mysqli,"login:$db_id",$db_id);
		if(isset($szar)){
			header("Location: ../admin/$szar");
		}else{
			header("Location: ../admin");
		}
	}else{
		if(!isset($szar)){
			add_to_log($mysqli,"login_attempt:$username",0);
			header("Location: ../admin/12");
		}else{
			add_to_log($mysqli,"login_attempt:$username",0);
			header("Location: ../admin/$szar");
		}
	}
}else{
	if(!isset($szar)){
		add_to_log($mysqli,"login_attempt:$username",0);
		header("Location: ../admin/12");
	}else{
		add_to_log($mysqli,"login_attempt:$username",0);
		header("Location: ../admin/$szar");
	}
}
?>