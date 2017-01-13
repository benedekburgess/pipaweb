<?php

require_once "inc/init.php"; // initialise databases and functions, and global variables such as $user_id and $mysqli

switch($uri[1]){ // special cases of the first part of the url (admin, fb link and qr code)
	
	case "admin":
		require_once "admin.php";
		exit();
	
	case "fb":
		if(isset($user_id)){
			add_to_log($mysqli,"fblink",$user_id);
		}else{
			add_to_log($mysqli,"fblink",0);
		}
		break;
	
	case "qr":
		if(isset($user_id)){
			add_to_log($mysqli,"qr",$user_id);
		}else{
			add_to_log($mysqli,"qr",0);
		}
		break;

}

if(isset($uri[1]) && !empty($uri[1]) && $uri[1]!="fb" && $uri[1]!="qr"){ // if first part of the url is set but isn't one of the special cases
	include_once $uri[1] .".php";
	exit();
}

setcookie('admin'); // sets the admin cookie to NULL (view_pg: admin only gets logged if this cookie is NULL)

if(isset($user_id)){ // logs the viewing of the index page
	add_to_log($mysqli,"viewpg_index",$user_id);
}else{
	add_to_log($mysqli,"viewpg_index",0);
}

$vanpipa = false; // sets $vanpipa variable to default value of false

$query = mysqli_query($mysqli,"SELECT * FROM pipe"); // queries the database for all pipes

$count = 0; // sets the $count varialbe to 0
$szeniter = 72; // sets the szeniter variable to default value of 72

while($row = mysqli_fetch_assoc($query)){ // rolls through all pipes in the database
	
	$timestamp = $row['ts']; // gets pipe timestamp from the database
	
	if(($timestamp+86400)>time()){ // increases pipe count if the timestamp is larger than 24 hours ago
		$count++;
	}
	
	$mosas = $row['mosas']; // gets if selected pipe was washed or not
	
	if($mosas!=0){ // if it was washed it sets the iterator to 0
		$iter = 0;
	}else{
		$iter++;
	}
	
	$szenek = $row['uj_szen']; // gets if new box of coals was opened in selected pipe
	
	if($szenek==0){ // if wasn't washed decreases szeniter by 3 (the number of coals needed for one pipe), else increases number of coals by 69 (3 less than number of coals in a box)
		$szeniter -= 3;
	}else{
		$szeniter += 69;
	}
	
	$diff = (time()-$timestamp)/60; // calculates difference in minutes between now and when the pipe started
	
	if($diff>0 && $diff<15){ // if difference is in 0-15 sets vanpipa to keszul
		$type = $row['type'];
		$vanpipa = "keszul";
		$ts = $row['ts'];
		
	}elseif($diff>=15 && $diff<50){ // pipe between 15 and 50 minutes are active
		$type = $row['type'];
		$vanpipa = "van";
		$ts = $row['ts'];
		
	}elseif($diff>=50 && $diff<70){ // dying from 50 to 70 minutes
		$type = $row['type'];
		$vanpipa = "meghal";
		$ts = $row['ts'];
		
	}else{ // dead after 70 minutes (not active, therefore vanpipa stays false)
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
			Van-e pipa a 1020-ban? - Home
			<span class="clrall">
				<?php if($logged_in==true){ ?>
				<a href="/logout">
					<span class="header_button">
						Kijelentkezés
					</span>
				</a>
				<?php } ?>
				<a href="admin">
					<span class="header_button">
						Admin
					</span>
				</a>
				<span class="right_text">Hello<?php if($logged_in==true){ echo " ".$current_nick; } ?>!</span>
			</span>
		</header>
		<aside>
			<?php
			
			if($vanpipa==false){
				echo "Nincs";
				echo "<br><span style='font-size:14px;'>".gmdate("H:i:s", $ts+3600+4200)." -kor volt utoljára</span>";
				$vanpipa = "nincs";
				
			}elseif($vanpipa=="keszul"){
				echo "Készül - ".$type." lesz<br><span style='font-size:14px;'>".gmdate("H:i", $ts+3600)." -kor kezdődött</span>";
				
			}elseif($vanpipa=="van"){
				echo "Van - ".$type."<br><span style='font-size:14px;'>".gmdate("H:i", $ts+900+3600)." -kor kezdődött</span>";
				
			}elseif($vanpipa=="meghal"){
				echo "Kezd meghalni - ".$type."<br><span style='font-size:14px;'>".gmdate("H:i", $ts+900+3600)." -kor kezdődött</span>";
				
			}
			
			if($iter<3){ // decides state of water (OK for 2 pipes after 3 it needs washing after 5 its 'you animals'
				$mosni = "jo";
			}elseif($iter>=3 && $iter<5){
				$mosni = "mosni";
			}else{
				$mosni = "animals";
			}
		
			$pipatext = "pipa_".$mosni."_".$vanpipa; // compiles name of image file needed for pipe status
			
			?><br>
			<img src="img/<?php echo $pipatext; ?>.png" style="max-height:400px; clear:both;">
			<br>
			<span style='font-size:14px;'>Az elmúlt 24 órában $count db pipa volt</span>
			<br>
		</aside>
		<footer>
		<?php 
		$query = mysqli_query($mysqli,"SELECT * FROM info");
		while($row = mysqli_fetch_assoc($query)){
			if($row['name']=="dohany"){
				$vanedohany=$row['description'];
			}
		?><div class="info">
			<?php
			if($row['description']=="true"){
				$allapot = "van";
			}elseif($row['description']=="nemelado"){
				$allapot = "venni_kene";
			}elseif($row['description']=="vanelado"){ 
				$allapot = "elado";
			}else{
				$allapot = "nincs";
			}
			?>
				<img src="/img/btn_<?php echo $row['name']; ?>_<?php echo $allapot; ?>.png" style="width:100%;">
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