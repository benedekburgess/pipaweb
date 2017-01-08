<?php
error_reporting(-1);
require_once "inc/init.php";
if($uri[1]=="admin"){
	require_once "admin.php";
	exit();
}
if($uri[1]=="fb"){
	if(isset($user_id)){
		add_to_log($mysqli,"fb_link",$user_id);
	}else{
		add_to_log($mysqli,"fb_link",0);
	}
	header("Location: /");
}
if(isset($uri[1]) && !empty($uri[1]) && $uri[1]!="fb"){
	echo $uri[1].".php";
	include_once $uri[1] .".php";
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
$count = 0;
$szeniter = 72;
while($row = mysqli_fetch_assoc($query)){
	$timestamp = $row['ts'];
	if($timestamp+86400<time()){
		$count++;
	}
	$mosas = $row['mosas'];
	if($mosas!=0){
		$iter = 0;
	}else{
		$iter++;
	}
	$szenek = $row['uj_szen'];
	if($szenek==0){
		$szeniter -= 3;
	}else{
		$szeniter = 69;
	}
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
		$vanpipa = "meghal";
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
			}elseif($vanpipa=="meghal"){
				echo "Kezd meghalni - ".$type."<br><span style='font-size:14px;'>".gmdate("H:i", $ts+600+360)." -kor kezdődött</span>";
			}
			echo "<br><span style='font-size:14px;'>Az elmúlt 24 órában $count db pipa volt</span><br>";
			?>
		</aside>
		<footer>
		<?php 
		$query = mysqli_query($mysqli,"SELECT * FROM info");
		while($row = mysqli_fetch_assoc($query)){
		?>
			<div <?php if($row['description']=="nemelado"){ echo "title='= Nincs eladó'"; } ?> class="info" style="<?php if($row['name']=="szen"){ ?>border-right:1px solid rgba(0,0,0,0.4);<?php 
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
		<?php
		if($iter<3){
			$mosni = "jo";
		}elseif($iter>=3 && $iter<7){
			$mosni = "mosni";
		}else{
			$mosni = "animals";
		}
		if($szeniter>18){
			$vaneszen = "van";
		}elseif($szeniter<=18 && $szeniter>0){
			$vaneszen = "keves";
		}else{
			$vaneszen = "nincs";
		}
		$szentext = "szen_".$vaneszen;
		if($vanpipa==false){
			$vanpipa = "nincs";
		}
		$pipatext = "pipa_".$mosni."_".$vanpipa;
		?>
		<nav>
			<img src="img/<?php echo $szentext; ?>.png" style="max-width:320px; position:relative; bottom:50px; margin-right:40px;">
			<img src="img/<?php echo $pipatext; ?>.png" style="max-width:320px; position:relative; left:21px;">
		</nav>
		<span class="adminlink">
			<a href="admin">Admin</a><?php if($logged_in==true){ ?>
			<a href="logout.php">Kijelentkezés</a><?php } ?>
		</span>
		<span class="fasz">Írta: beni<br>
						Hint: vannak easter egg-ek</span>
	</body>
</html>