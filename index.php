<?php
error_reporting(-1);
require_once "inc/init.php";
if($uri[1]=="admin"){
	require_once "admin.php";
	exit();
}
if($uri[1]=="fb"){
	if(isset($user_id)){
		add_to_log($mysqli,"fblnk",$user_id);
	}else{
		add_to_log($mysqli,"fblnk",0);
	}
	header("Location: /");
	exit();
}
if($uri[1]=="qr"){
	if(isset($user_id)){
		add_to_log($mysqli,"qr",$user_id);
	}else{
		add_to_log($mysqli,"qr");
	}
	header("Location: /");
	exit();
}
if(isset($uri[1]) && !empty($uri[1]) && $uri[1]!="fb"){
	include_once $uri[1] .".php";
	exit();
}
setcookie('admin');
if(isset($user_id)){
	add_to_log($mysqli,"viewpg_index",$user_id);
}else{
	add_to_log($mysqli,"viewpg_index",0);
}
$vanpipa = false;
$query = mysqli_query($mysqli,"SELECT * FROM pipe");
$count = 0;
$szeniter = 60;
while($row = mysqli_fetch_assoc($query)){
	$timestamp = $row['ts'];
	if(($timestamp+86400)>time()){
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
		$szeniter = 57;
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
		<meta name="google-site-verification" content="83lHvS--9C0_21c0SEy4eon4yeOS3XVkZ9gMMlup2aU" />
		<link rel="icon" type="image/png" href="img/favicon.png">
		<link rel="stylesheet" type="text/css" href="css/main.css" />
		<title>Van-e pipa a 1020-ban?</title>
	</head>
	<body>
		<header>
			Van-e pipa a 1020-ban?
			<span style="text-align:right; display:block; float:right;">Hello<?php if($logged_in==true){ echo " ".$current_nick; } ?>! | </span>
			<div class="header_button">
				<a href="admin">Admin</a><?php if($logged_in==true){ ?>
			</div>
			<div class="header_button">
				<a href="/logout">Kijelentkezés</a><?php } ?>
			</div>
		</header>
		<aside>
			<?php
			if($vanpipa==false){
				echo "Nincs";
				echo "<br><span style='font-size:14px;'>".gmdate("H:i:s", $ts+3600+4200)." -kor volt utoljára</span>";
			}elseif($vanpipa=="keszul"){
				echo "Készül - ".$type." lesz<br><span style='font-size:14px;'>".gmdate("H:i", $ts+3600)." -kor kezdődött</span>";
			}elseif($vanpipa=="van"){
				echo "Van - ".$type."<br><span style='font-size:14px;'>".gmdate("H:i", $ts+900+3600)." -kor kezdődött</span>";
			}elseif($vanpipa=="meghal"){
				echo "Kezd meghalni - ".$type."<br><span style='font-size:14px;'>".gmdate("H:i", $ts+900+3600)." -kor kezdődött</span>";
			}
			if($vanpipa==false){
				$vanpipa = "nincs";
			}
		if($iter<3){
			$mosni = "jo";
		}elseif($iter>=3 && $iter<7){
			$mosni = "mosni";
		}else{
			$mosni = "animals";
		}
			$pipatext = "pipa_".$mosni."_".$vanpipa;
			?>
			<br>
			<img src="img/<?php echo $pipatext; ?>.png" style="max-height:400px; clear:both;">
			<?php
			echo "<br><span style='font-size:14px;'>Az elmúlt 24 órában $count db pipa volt</span><br>";
			?>
		</aside>
		<footer>
		<?php 
		$query = mysqli_query($mysqli,"SELECT * FROM info");
		while($row = mysqli_fetch_assoc($query)){
			if($row['name']=="dohany"){
				$vanedohany=$row['description'];
			}
		?>
			<div <?php 
			if($row['description']=="nemelado"){
				echo "title='= Nincs eladó'"; } 
			?> class="info" style="<?php 
			if($row['name']=="szen"){
				?>border-right:1px solid rgba(0,0,0,0.4);<?php 
			} 
			if($row['description']=="true"){
				?>background:green;<?php 
			}elseif($row['description']=="nemelado"){
				echo "background:yellow;"; 
			}elseif($row['description']=="vanelado"){ 
				echo "background:lightblue"; 
			}else{
				echo "background:rgba(255,50,0,1);";
			}			?>"><?php 
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
				case "vanelado":
				echo "Van eladó";
				break;
				
			}
			
			?>
			</h3>
			</div>
		<?php
			if($row['name']=='szen'){
				if($szeniter>18){
					$szen_query = "UPDATE info SET description='true' WHERE name='szen'";
				}elseif($szeniter<=18 && $szeniter>0){
					$szen_query = "UPDATE info SET description='nemelado' WHERE name='szen'";
				}else{
					$szen_query = "UPDATE info SET description='nincs' WHERE name='szen'";
				}
			}
		}
		mysqli_query($mysqli,$szen_query);
		?>
		
		</footer>
		<?php
		if($szeniter>18){
			$vaneszen = "van";
		}elseif($szeniter<=18 && $szeniter>0){
			$vaneszen = "keves";
		}else{
			$vaneszen = "nincs";
		}
		if($vanedohany=="nemelado"){
			$dohanytext = "dohany_keves";
		}elseif($vanedohany=="false"){
			$dohanytext = "dohany_nincs";
		}else{
			$dohanytext = "dohany_van";
		}
			
		$szentext = "szen_".$vaneszen;
		?>
		<nav>
			<img src="img/<?php echo $szentext; ?>.png" style="max-width:320px; position:relative; margin-top:30px; margin-right:10px;">
			<img src="img/<?php echo $dohanytext; ?>.png" style="max-width:320px; margin-top:30px; margin-left:10px;">
		</nav>
		<span class="adminlink">
		</span>
		<span class="fasz" style="text-align:right;">Írta: beni<br>
						Hint: vannak easter egg-ek<br>
						Támogatóink: <a target="_blank" href="https://www.youtube.com/channel/UCLlTfVahBA62Nn2zLPDGSMg">DJ KotyogósHerka</a><br>
						Hosted by: Sztyúp</span>
	</body>
</html>