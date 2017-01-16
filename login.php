<?php
require_once "inc/init.php";
setcookie('admin');
$username = mysqli_real_escape_string($mysqli,$_POST['username']);
$password = mysqli_real_escape_string($mysqli,$_POST['password']);
if(strlen($username)>99){
	header("Location: /admin/12");
	exit();
}
if(strlen($password)>99){
	header("Location: /admin/12");
	exit();
}
if($username==""){
	header("Location: /admin/1");
	exit();
}else{
	$query = mysqli_query($mysqli,"SELECT * FROM easter_eggs");
	echo mysqli_error($mysqli);
	while($row = mysqli_fetch_assoc($query)){
		if($row['trigger']==$username){
			$szar = $row['lnk'];
		}
	}
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
			add_to_log($mysqli,"fail_lgn:$username",0);
			header("Location: ../admin/12");
		}else{
			add_to_log($mysqli,"fail_lgn:_$username",0);
			header("Location: ../admin/$szar");
		}
	}
}else{
	if(!isset($szar)){
		add_to_log($mysqli,"fail_lgn:_$username",0);
		header("Location: ../admin/12");
	}else{
		add_to_log($mysqli,"fail_lgn:_$username",0);
		header("Location: ../admin/$szar");
	}
}
?>