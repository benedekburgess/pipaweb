<?php
require_once "inc/init.php";
if($uri[1]=="admin"){
	require_once "admin.php";
	exit();
}
setcookie('admin');
if(isset($user_id)){
	add_to_log($mysqli,"view_page:index.php",$user_id);
}else{
	add_to_log($mysqli,"view_page:index.php",0);
}
$vanpipa = false;
$query = mysqli_query($mysqli,"SELECT * FROM pipe");
while($row = mysqli_fetch_assoc($query)){
	$timestamp = $row['ts'];
	$diff = (time()-$timestamp)/60;
	if($diff>0 && $diff<15){
		$type = $row['type'];
		$vanpipa = "keszul";
		$ts = $row['ts'];
	}elseif($diff>=15 && $diff<45){
		$type = $row['type'];
		$vanpipa = "van";
		$ts = $row['ts'];
	}elseif($diff>=45 && $diff<70){
		$type = $row['type'];
		$vanpipa = "meghalo";
		$ts = $row['ts'];
	}else{
		$id = $row['id'];
		$ts = $row['ts'];
	}
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="description" content="Van-e a 1020-ban pipa?">
		<meta name="keywords" content="pipa, 1020, sir, schönherz, SCH, hookah">
		<meta name="author" content="Beni">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="icon" type="image/png" href="img/favicon.png">
		<link rel="stylesheet" type="text/css" href="css/main.css" />
		<title>Van-e pipa a 1020-ban?</title>
	</head>
	<body>
		<header>
			Van-e pipa a 1020-ban?
		</header>
		<aside>
			<?php
			if($vanpipa==false){
				echo "Nincs";
				echo "<br><span style='font-size:14px;'>".gmdate("H:i:s", $ts+7500)." -kor volt utoljára</span>";
			}elseif($vanpipa=="keszul"){
				echo "Készül - ".$type." lesz<br><span style='font-size:14px;'>".gmdate("H:i", $ts+3600)." -kor kezdődött</span>";
			}elseif($vanpipa=="van"){
				echo "Van - ".$type."<br><span style='font-size:14px;'>".gmdate("H:i", $ts+600+3600)." -kor kezdődött</span>";
			}elseif($vanpipa=="meghalo"){
				echo "Kezd meghalni - ".$type."<br><span style='font-size:14px;'>".gmdate("H:i", $ts+600+360)." -kor kezdődött</span>";
			}
			?>
		</aside>
		<footer>
		<?php 
		$query = mysqli_query($mysqli,"SELECT * FROM info");
		while($row = mysqli_fetch_assoc($query)){
		?>
			<div class="info" style="<?php if($row['name']=="szen"){ ?>border-right:1px solid rgba(0,0,0,0.4);<?php 
			} if($row['description']=="true"){ ?>background:green;<?php }elseif($row['description']=="nemelado"){ echo "background:yellow;"; }else{ echo "background:rgba(255,50,0,1);"; } ?>"><?php 
			if($row['name']=="szen"){ echo "Szén"; } if($row['name']=="dohany"){ echo "Dohány"; } ?>
			<h3>
			<?php 
			switch($row['description']){
				case "true":
				echo "Van";
				break;
				case "nemelado":
				echo "Kevés van";
				break;
				default:
				echo "Nincs";
				break;
				
			}
			?>
			</h3>
			</div>
		<?php
		}
		?>
		
		</footer>
		<span class="adminlink">
			<a href="admin">Admin</a><?php if($logged_in==true){ ?>
			<a href="logout.php">Kijelentkezés</a><?php } ?>
		</span>
		<span class="fasz">Írta: én<br>
						Hint: vannak easter egg-ek</span>
	</body>
</html>