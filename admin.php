<?php
require_once "inc/init.php";
if(isset($user_id)){
	if(!isset($_COOKIE['admin'])){
		add_to_log($mysqli,"view_page:admin.php",$user_id);
		setcookie('admin','true');
	}
}else{
	if(!isset($_COOKIE['admin'])){
		add_to_log($mysqli,"view_page:admin.php",0);
		setcookie('admin','true');
	}
}
$vanpipa = false;
$query = mysqli_query($mysqli,"SELECT * FROM pipe");
$iter = 0;
while($row = mysqli_fetch_assoc($query)){
	$timestamp = $row['ts'];
	$diff = (time()-$timestamp)/60;
	$mosas = $row['mosas'];
	if($mosas!=0){
		$iter = 0;
	}else{
		$iter++;
	}
	if($diff>0 && $diff<15){
		$vanpipa = "keszul";
		$type = $row['type'];
		$id = $row['id'];
	}elseif($diff>=15 && $diff<45){
		$vanpipa = "kesz";
		$type = $row['type'];
		$id = $row['id'];
	}elseif($diff>=45 && $diff<70){
		$vanpipa = "meghalo";
		$type = $row['type'];
		$id = $row['id'];
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
		<link rel="icon" type="image/png" href="/img/favicon.png">
		<link rel="stylesheet" type="text/css" href="/css/main.css" />
		<title>Van-e pipa a 1020-ban? - Admin</title>
	</head>
	<body>
		<header>
			Van-e pipa a 1020-ban? - Admin
		</header>
		<aside>
<?php	
				$szar = array("",
					12=>"Szar vagy",
					65=>"<audio autoplay><source src='zsolt.mp3' type='audio/mpeg'>Régi a böngésződ <a href='zsolt.mp3'>ehez</a></audio>",
					99=>"<a href='https://www.youtube.com/channel/UCLlTfVahBA62Nn2zLPDGSMg'>McGuyver</a>",
					723=>"<video width='640' height='480' autoplay><source src='sztyup2.mp4' type='video/mp4'></video>",
					873=>"Nem.",
					123=>"<a href='http://www.bonnie.info/wp-content/uploads/2014/12/image-14.jpeg'>:)</a>",
					433=>"<video width='640' height='480' autoplay><source src='pocok.mp4' type='video/mp4'></video>",
					466=>"Nem vicces.<br><img src='nemvicces.jpg'>",
					8496=>"<img src='img/adobizonylat.jpg'>",
					74555=>"Szarok a vicceid",
					136786=>"<iframe width='560' height='315' src='https://www.youtube.com/embed/RIYUyq-UvI0' frameborder='0' allowfullscreen></iframe>",
					9745=>"<img src='https://pbs.twimg.com/media/BXRdLmvCEAARF-p.jpg:large'>",
					69=>"Ne legyél buzi",
					1=>"Miért hagyod üresen bazdmeg??",
					941111=>"<video width='640' height='480' autoplay><source src='csupity.mp4' type='video/mp4'></video>",
					123456789=>"<img width='640' src='http://rainbowsandlollipops.net/wp-content/uploads/2016/10/Brexit.jpg'>",
					486532=>"<img src='https://www.antikvarium.hu/foto/varga-csaba-pici-maci-feloltozik-5899490-nagy.jpg'>",
					75421=>"<script type='text/javascript'>alert('3 büntetőpont nevelőtanárral szembeni szemtelenségért');</script>
							<img src='https://scontent-vie1-1.xx.fbcdn.net/v/t35.0-12/15878181_1453349688071664_2129721544_o.jpg?oh=a2cdf00915276df4efe8679aceed83fe&oe=587035B1' width='640'>
							<br><span style='font-size:14px;'>Disclaimer: nem én csináltam</span>",
					1895651=>"Ez sem egy lyuk",
					0=>"<video width='640' height='480' autoplay><source src='1002.mp4' type='video/mp4'></video>",
					8522=>"<img src='https://scontent-vie1-1.xx.fbcdn.net/v/t34.0-12/15878811_1454637174609582_1392655055_n.jpg?oh=0ee19d8839dde9cd6f08826f6a1733bc&oe=5872B3C8'>",
					741258=>"Szeretem ha horkolnak",
					115588=>"Ví ár dö vándö vándö vándőő",
					789654=>"<img src='https://i.ytimg.com/vi/9P1M138_H_Q/hqdefault.jpg'>X1000",
					56285=>"<img src='https://csakazolvassamost.files.wordpress.com/2014/06/gerle-eva-takony-pisi.jpg'>",
					55996=>"<img src='http://4vector.com/i/free-vector-pepito_065121_pepito.png'>",
					786121=>"<img src='img/bubi.png'>");
					if(isset($uri[2])){
						echo $szar[$uri[2]];
					}
				if($logged_in==false){
					
					?>
			<form action="login.php" method="POST">
				<input id="username_input" maxlength="64" type="text" name="username" placeholder="Felhasználónév">
				<input maxlength="64" type="password" name="password" placeholder="Jelszó">
				<input type="submit" value="Bejelentkezés">
			</form>
					<?php
				}else{
					if($vanpipa==false){
						
					?>
						<form action="add.php" method="POST" id="form">
							<select name="time" form="form">
								<option value="keszul">Készül</option>
								<option value="van">Van</option>
								<option value="meghalo">Meghaló</option>
							</select>
							<input type="text" placeholder="Milyen dohány?" name="type">
							<input type="hidden" name="sent" value="true">
						
					<input type="submit" value="<?php if($iter<=3){ ?>Elküld<?php }else{ echo "Mosd ki a pipát"; } ?>"<?php if($iter>3){ echo " disabled"; }?>>
						</form>
						<?php if($iter>3){ ?><h3><a href="mosas">Pipamosás</a></h3><?php } ?>
					<?php
					}else{
						
						
						?>
						<form action="change.php" method="POST" id="form">
							<select name="time" form="form">
								<option value="keszul"<?php if($vanpipa=="keszul"){echo " SELECTED";}?>>Készül</option>
								<option value="van"<?php if($vanpipa=="kesz"){echo " SELECTED";}?>>Van</option>
								<option value="meghalo"<?php if($vanpipa=="meghalo"){echo " SELECTED";}?>>Meghaló</option>
							</select>
							<input type="text" placeholder="Milyen dohány?" name="type" value="<?php echo $type; ?>">
							<input type="hidden" name="sent" value="<?php echo $id; ?>">
							<input type="submit" value="Elküld">
						</form>
						
						<?php
						
					}
				}
			?>
		</aside>
		<?php
		if($logged_in==true){
			if($current_user_admin>0){ 
				if(isset($uri[2])){
					$mode = $uri[2];
				}
				?>
		<section>
		Fejlesztői opciók
			<h2><a href="/admin/users"<?php if(isset($mode) && $mode=="users"){ echo " id='selected'"; }?>>Felhasználók</a> | <a href="/admin/log"<?php if(isset($mode) && $mode=="log"){ echo " id='selected'"; }?>>Eseménynapló</a> | <a href="/admin/pipes"<?php if(isset($mode) && $mode=="pipes"){ echo " id='selected'"; }?>>Pipák</a></h2>
		</section>
		<?php
				if(isset($uri[2])){
					$mode = $uri[2];
					?>
		<nav>
			<?php
			if($mode=="users"){						// ###################### FELHASZNÁLÓK ######################
				if(isset($uri[3])){
					$error = $uri[3];
				}
				?>
			<table>
				<tr>
					<th><h3><b>ID</b></h3></th>
					<th><h3><b>Felhasználónév</b></h3></th>
					<th><h3><b>Admin</b></h3></th>
					<th><h3><b>Töröl</b></h3></th>
					<th><h3><b>Jelszó</b></h3></th>
				</tr>
				<?php
				$query = mysqli_query($mysqli,"SELECT * FROM users");
				while($row = mysqli_fetch_assoc($query)){
					$id = $row['id'];
					$username = $row['username'];
					if($row['admin']==0){
						$admin = false;
					}else{
						$admin = true;
					}
					?>
					<tr>
						<td><h3><?php echo $id; ?></h3></td>
						<td><h3 class="user"><?php echo $username; ?></h3></td>
						<td><h3><img width="24" src="<?php if($admin==true){ echo "/img/pipa.png"; }else{ echo "/img/x.png"; }?>"></h3></td>
						<td><h3><?php if(($admin==false || $current_su==true) && $user_id!=$id){ ?><a href="remove_user/<?php echo $id; ?>"><span style="font-family:'Comic Sans MS';">X</span></a><?php } ?></h3></td>
						<td><h3><?php
						if($admin==false && $current_user_admin > 0){
							?><a href="#" class="faszkalap"><span style="font-family:'Comic Sans MS';">X</span></a><?php
						}elseif($admin==true && $current_user_admin==2){
							?><a href="#" class="faszkalap"><span style="font-family:'Comic Sans MS';">X</span></a><?php
						}elseif($admin==true && $user_id==$id){
							?><a href="#" class="faszkalap"><span style="font-family:'Comic Sans MS';">X</span></a><?php
						}
						?></h3></td>
					<tr>
					<?php
				}
				?>
			</table>
			<div id="box">
				<form action="changepw.php" method="POST">
					<input id="hidden" type="hidden" name="username" value="">
					<input id="password_input" type="password" name="pw1" placeholder="Új jelszó">
					<input type="password" name="pw2" placeholder="Jelszó megint">
					<input type="submit" value="Elküld">
				</form>
			</div>
			<hr>
			<h3 style="margin-top:10px !important;">Új felhasználó:</h3>
			<form action="adduser.php" method="POST">
				<input <?php if(isset($error)){ if($error=="username"){ ?>style="background:red;"<?php } } ?> type="text" name="username" placeholder="Felhasználónév"><br>
				<input <?php if(isset($error)){ if($error=="password"){ ?>style="background:red;"<?php } } ?> type="password" name="password" placeholder="Jelszó"><br>
				<input <?php if(isset($error)){ if($error=="password"){ ?>style="background:red;"<?php } } ?> type="password" name="password2" placeholder="Jelszó megint"><br>
				<h3 style="margin-top:10px !important; margin-right:10px; display:inline !important;"><input type="checkbox" name="admin" id="admin" value="true"><label for="admin">Admin</h3></label><input type="submit" value="Elküld">
			</form>
				<?php
				
			}elseif($mode=="log"){				// ###################### ESEMÉNYNAPLÓ ######################
				if(!isset($uri[3])){
					$page = 1;
				}else{
					if($uri[3]>=1){
						$page = $uri[3];
					}
				}
				?>
				<h3>
				<?php
				$num_pages = ceil(mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM log LIMIT 300"))/15);
				for($i=1;$i<=$num_pages;$i++){
					?><a<?php if($i==$page){ echo " style='color:red;' "; } ?> href="/admin/log/<?php echo $i; ?>"><?php echo $i; ?></a>
					<?php
					
				};
				?></h3>
			<table>
				<tr>
					<th><h3><b>IP</b></h3></th>
					<th><h3><b>Művelet</b></h3></th>
					<th><h3><b>Idő</b></h3></th>
					<th><h3><b>Felhasználó</b></h3></th>
				</tr>
				<?php
				$page2 = ($page-1)*15;
				$query = mysqli_query($mysqli,"SELECT * FROM log ORDER BY ts DESC LIMIT 15 OFFSET $page2");
				while($row = mysqli_fetch_assoc($query)){
					$ip  = $row['ip'];
					$data = $row['data'];
					$ts = $row['ts'];
					$uid = $row['user_id'];
					?>
				<tr>
					<td><h3><?php echo $ip; ?></h3></td>
					<td><h3><?php echo $data; ?></h3></td>
					<td><h3><?php echo gmdate("Y/n/d H:i:s",$ts+3600); ?></h3></td>
					<td><h3><?php echo $uid; ?></h3></td>
				</tr>
					<?php
				}
				?>
			</table>
				<h3>
				<?php
				$num_pages = ceil(mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM log LIMIT 300"))/15);
				for($i=1;$i<=$num_pages;$i++){
					?><a<?php if($i==$page){ echo " style='color:red;' "; } ?> href="/admin/log/<?php echo $i; ?>"><?php echo $i; ?></a>
					<?php
					
				};
				?></h3><?php
			}elseif($mode=="pipes"){				// ###################### PIPÁK ######################
				?>
				
			<table>
				<tr>
					<th><h3><b>Idő</b></h3></th>
					<th><h3><b>Dohány</b></h3></th>
					<th><h3><b>Állapot</b></h3></th>
					<th><h3><b>Felhasználó</b></h3></th>
					<th><h3><b>Töröl</b></h3></th>
					<th><h3><b>Megölés</b></h3></th>
				</tr>
				<?php
				$query = mysqli_query($mysqli,"SELECT * FROM pipe");
				while($row = mysqli_fetch_assoc($query)){
					$id = $row['id'];
					$ts = $row['ts'];
					$type = $row['type'];
					$by = get_username($row['user_id'],$mysqli);
					$diff = (time()-$ts)/60;
					if($diff>0 && $diff<15){
						$vanpipa = "Készül";
					}elseif($diff>=15 && $diff<45){
						$vanpipa = "Aktív";
					}elseif($diff>=45 && $diff<70){
						$vanpipa = "Meghaló";
					}else{
						$vanpipa = "Meghalt";
					}
					?>
					<tr>
						<td><h3><?php echo gmdate("Y-m-d H:i:s", $ts+3600); ?></h3></td>
						<td><h3><?php echo $type; ?></h3></td>
						<td><h3><?php echo $vanpipa; ?></h3></td>
						<td><h3><?php echo $by; ?></h3></td>
						<td><h3><a href="remove/<?php echo $id; ?>"><span style="font-family:'Comic Sans MS';">X</span></a></h3></td>
						<td><h3><?php if($vanpipa!="Meghalt"){ ?><a href="kill/<?php echo $id; ?>"><span style="font-family:'Comic Sans MS';">X</span></a><?php } ?></h3></td>
					</tr>
					<?php
				}
			}
			?>
			</table>
		</nav>
					<?php
				}
			}
		}
		?>
		<footer>
		<?php 
		if($logged_in==true){
		$query = mysqli_query($mysqli,"SELECT * FROM info");
		while($row = mysqli_fetch_assoc($query)){
		?>
			<a class="info button" href="changestate/<?php echo $row['name']; ?>" style="<?php if($row['name']=="szen"){ 
			?>border-right:1px solid rgba(0,0,0,0.4);<?php } if($row['description']=="true"){ ?>background:green;
			<?php }elseif($row['description']=="nemelado"){ echo "background:yellow;"; }else{ echo "background:rgba(255,50,0,1);"; } ?>">
				<div><?php if($row['name']=="szen"){ echo "Szén"; } if($row['name']=="dohany"){ echo "Dohány"; } ?></div>
			</a>
				
		<?php
		} }
		?>
		
		</footer>
		<span class="adminlink">
			<a href="../">Vissza</a><?php if($logged_in==true){ ?>
			<a href="../logout">Kijelentkezés</a><?php } ?>
		</span>
	</body>
		<span class="fasz">Írta: én<br>
						Hint: vannak easter egg-ek</span>
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
</html>