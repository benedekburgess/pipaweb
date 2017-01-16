<?php
require_once "inc/init.php";
if(isset($user_id)){
	if(!isset($_COOKIE['admin'])){
		add_to_log($mysqli,"viewpg_admin",$user_id);
		setcookie('admin','true');
	}
}else{
	if(!isset($_COOKIE['admin'])){
		add_to_log($mysqli,"viewpg_admin",0);
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
			<div class="clrall">
				<?php if($logged_in==true){ ?>
				<a href="/logout">
					<span class="header_button">
						Kijelentkezés
					</span>
				</a>
				<?php } ?>
				<a href="/">
					<span class="header_button">
						Vissza
					</span>
				</a>
				<span class="right_text">Hello<?php if($logged_in==true){ echo " ".$current_nick; } ?>!</span>
			</div>
		</header>
		<aside>
<?php	
				$szar = array("",
					12=>"Szar vagy",
					65=>"<audio autoplay><source src='zsolt.mp3' type='audio/mpeg'>Régi a böngésződ <a href='zsolt.mp3'>ehez</a></audio>",
					99=>"<a href='https://www.youtube.com/channel/UCLlTfVahBA62Nn2zLPDGSMg'>McGuyver</a>",
					723=>"<iframe width='560' height='315' src='https://www.youtube.com/embed/wuxJKNutCoc' frameborder='0' allowfullscreen></iframe>",
					873=>"Nem.",
					123=>"<a href='http://www.bonnie.info/wp-content/uploads/2014/12/image-14.jpeg'>:)</a>",
					433=>'<iframe width="560" height="315" src="https://www.youtube.com/embed/iGPQcZdG-fY" frameborder="0" allowfullscreen></iframe>',
					466=>"Nem vicces.<br><img src='nemvicces.jpg'>",
					8496=>"<img src='img/adobizonylat.jpg'>",
					74555=>"Szarok a vicceid",
					136786=>"<iframe width='560' height='315' src='https://www.youtube.com/embed/RIYUyq-UvI0' frameborder='0' allowfullscreen></iframe>",
					9745=>"<img src='https://pbs.twimg.com/media/BXRdLmvCEAARF-p.jpg:large'>",
					69=>"Csinicsani",
					1=>"Miért hagyod üresen bazdmeg??",
					941111=>'<iframe width="560" height="315" src="https://www.youtube.com/embed/ujGW96kgdxs" frameborder="0" allowfullscreen></iframe>',
					123456789=>"<img width='640' src='http://rainbowsandlollipops.net/wp-content/uploads/2016/10/Brexit.jpg'>",
					486532=>"<img src='https://www.antikvarium.hu/foto/varga-csaba-pici-maci-feloltozik-5899490-nagy.jpg'>",
					75421=>"<script type='text/javascript'>alert('3 büntetőpont nevelőtanárral szembeni szemtelenségért');</script>
							<img src='/img/koza.jpg' width='640'>
							<br><span style='font-size:14px;'>Disclaimer: nem én csináltam</span>",
					1895651=>"Ez sem egy lyuk",
					0=>'<iframe width="560" height="315" src="https://www.youtube.com/embed/HzXTCE2OY5w" frameborder="0" allowfullscreen></iframe>',
					8522=>"<img src='/img/navi.jpg'>",
					741258=>"Szeretem ha horkolnak",
					115588=>"Ví ár dö vándö vándö vándőő",
					789654=>"<img src='https://i.ytimg.com/vi/9P1M138_H_Q/hqdefault.jpg'>X1000",
					56285=>"<img src='https://csakazolvassamost.files.wordpress.com/2014/06/gerle-eva-takony-pisi.jpg'>",
					55996=>"<img src='http://4vector.com/i/free-vector-pepito_065121_pepito.png'>",
					786121=>"<img src='img/bubi.png'>",
					6883213=>"<a href='http://facebook.com/1020SCH'>;)</a>",
					1311111=>"<video width='640' height='480' autoplay><source src='http://img-9gag-fun.9cache.com/photo/azrw2MB_460sv.mp4' type='video/mp4'></video>",
					8511122=>"<img src='/img/bedu.jpg' style='max-width:640px;'>");
					if(isset($uri[2])){
						echo $szar[$uri[2]];
					}
				if($logged_in==false){
					
					?>
			<form action="/login" method="POST">
				<input id="username_input" maxlength="64" type="text" name="username" placeholder="Felhasználónév">
				<input maxlength="64" type="password" name="password" placeholder="Jelszó">
				<input type="submit" value="Bejelentkezés">
			</form>
					<?php
				}else{
					if($vanpipa==false){
						
					?>
						<form action="/add" method="POST" id="form">
							<select name="time" form="form">
								<option value="keszul">Készül</option>
								<option value="van">Van</option>
								<option value="meghalo">Meghaló</option>
							</select>
							<input type="text" placeholder="Milyen dohány?" name="type"><input type="checkbox" name="szen" id="szen" style="position:relative; top:3px;"><span style="font-size:12px;"><label for="szen">Új szén</label></span>
							<input type="hidden" name="sent" value="true">
						
					<input type="submit" value="Elküld">
						</form>
						<h3><a href="mosas">Pipamosás</a></h3>
					<?php
					}else{
						
						
						?>
						<form action="/change" method="POST" id="form">
							<select name="time" form="form">
								<option value="keszul"<?php if($vanpipa=="keszul"){echo " SELECTED";}?>>Készül</option>
								<option value="van"<?php if($vanpipa=="kesz"){echo " SELECTED";}?>>Van</option>
								<option value="meghalo"<?php if($vanpipa=="meghalo"){echo " SELECTED";}?>>Meghaló</option>
							</select>
							<input type="text" placeholder="Milyen dohány?" name="type" value="<?php echo $type; ?>">
							<input type="hidden" name="sent" value="<?php echo $id; ?>">
							<input type="submit" value="Elküld">
						</form>
						<h3><a href="mosas">Pipamosás</a></h3>
						
						<?php
						
					}
				}
			?>
		</aside>
		<?php
		if($logged_in==true){
			if($current_user_admin<1){
				?>
		<section>
		<?php
		
				if($uri[2]=="users"){
					echo "<h3>Jelszóváltoztatás sikeres!</h3>";
				}elseif($uri[2]=="failed"){
					echo "<h3>Jelszóváltoztatás sikertelen!</h3>";
				}else{
					echo "<h3>Jelszóváltoztatás: </h3>";
				}
				?>
			<form action="/changepw" method="POST">
				<input type="hidden" name="username" value="<?php echo $current_username; ?>">
				<input type="password" name="pw1" placeholder="Új jelszó">
				<input type="password" name="pw2" placeholder="Jelszó megint">
				<input type="submit" value="Elküld">
			</form>
		</section>
				<?php
			}
		}
		if($logged_in==true){
			if($current_user_admin>0){ 
				if(isset($uri[2])){
					$mode = $uri[2];
				}
				?>
		<section>
		Fejlesztői opciók
			<h2><a href="/admin/users"<?php if(isset($mode) && $mode=="users"){ echo " id='selected'"; }?>>Felhasználók</a> | <a href="/admin/log"<?php if(isset($mode) && $mode=="log"){ echo " id='selected'"; }?>>Eseménynapló</a> | <a href="/admin/pipes"<?php if(isset($mode) && $mode=="pipes"){ echo " id='selected'"; }?>>Pipák</a> | <a href="/admin/ips"<?php if(isset($mode) && $mode=="ips"){ echo " id='selected'"; }?>>IP-k</a></h2>
		</section>
		<?php
				if(isset($uri[2])){
					$mode = $uri[2];
					?>
		<nav id="swipetable">
			<?php
			if($mode=="users"){						// ###################### FELHASZNÁLÓK ######################
				if(isset($uri[3])){
					$error = $uri[3];
				}
				if($error!="username" && $error!="password"){
					$page = $uri[3];
				}else{
					$page = 1;
				}
				if($page==""){
					$page=1;
				}
				?>
				<h3><?php
				$num_pages = ceil(mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM users"))/10);
				if($page>3){
					?><a href="/admin/users/<?php echo $page-3; ?>"><span style="font-family:'Comic Sans MS';"><<<</span></a>&nbsp;<?php
				}
				if($page>1){
					?><a id="leftbutton" href="/admin/users/<?php echo $page-1; ?>"><span style="font-family:'Comic Sans MS';"><</span></a><?php
				}
				echo " $page ";
				if($page<$num_pages){
					?><a id="rightbutton" href="/admin/users/<?php echo $page+1; ?>"><span style="font-family:'Comic Sans MS';">></span></a>&nbsp;<?php
				}
				if($page<$num_pages-2){
					?><a href="/admin/users/<?php echo $page+3; ?>"><span style="font-family:'Comic Sans MS';">>>></span></a><?php
				}
				?>
				</h3>
			<table>
				<tr>
					<th><h3><b>ID</b></h3></th>
					<th><h3><b>Felhasználónév</b></h3></th>
					<th><h3><b>Admin</b></h3></th>
					<th><h3><b>Töröl</b></h3></th>
					<th><h3><b>Jelszó</b></h3></th>
				</tr>
				<?php
				$page2 = ($page-1)*10;
				$query = mysqli_query($mysqli,"SELECT * FROM users LIMIT 10 OFFSET $page2");
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
						<td><h3><?php if($current_user_admin==2 && $row['admin']!=2){ ?><a href="/chgadmin/<?php echo $id; ?>"><?php } ?><img width="24" src="<?php if($admin==true){ echo "/img/pipa.png"; }else{ echo "/img/x.png"; }?>"><?php if($current_user_admin==2){ ?></a><?php } ?></h3></td>
						<td><h3><?php if(($admin==false || $current_su==true) && $user_id!=$id){ ?><a href="/remove_user/<?php echo $id; ?>"><span style="font-family:'Comic Sans MS';">X</span></a><?php } ?></h3></td>
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
			<h3>
			<?php
				if($page>3){
					?><a href="/admin/users/<?php echo $page-3; ?>"><span style="font-family:'Comic Sans MS';"><<<</span></a>&nbsp;<?php
				}
				if($page>1){
					?><a id="leftbutton" href="/admin/users/<?php echo $page-1; ?>"><span style="font-family:'Comic Sans MS';"><</span></a><?php
				}
				echo " $page ";
				if($page<$num_pages){
					?><a id="rightbutton" href="/admin/users/<?php echo $page+1; ?>"><span style="font-family:'Comic Sans MS';">></span></a>&nbsp;<?php
				}
				if($page<$num_pages-2){
					?><a href="/admin/users/<?php echo $page+3; ?>"><span style="font-family:'Comic Sans MS';">>>></span></a><?php
				}
			?>
			</h3>
			<div id="box">
				<form action="/changepw" method="POST">
					<input id="hidden" type="hidden" name="username" value="">
					<input id="password_input" type="password" name="pw1" placeholder="Új jelszó">
					<input type="password" name="pw2" placeholder="Jelszó megint">
					<input type="submit" value="Elküld">
				</form>
			</div>
			<hr>
			<h3 style="margin-top:10px !important;">Új felhasználó:</h3>
			<form action="/adduser" method="POST">
				<input <?php if(isset($error)){ if($error=="username"){ ?>style="background:red;"<?php } } ?> type="text" name="username" placeholder="Felhasználónév"><br>
				<input <?php if(isset($error)){ if($error=="password"){ ?>style="background:red;"<?php } } ?> type="password" name="password" placeholder="Jelszó"><br>
				<input <?php if(isset($error)){ if($error=="password"){ ?>style="background:red;"<?php } } ?> type="password" name="password2" placeholder="Jelszó megint"><br>
				<?php if($current_su==true){ ?><h3 style="margin-top:10px !important; margin-right:10px; display:inline !important;"><input type="checkbox" name="admin" id="admin" value="true"><label for="admin">Admin</h3></label><?php } ?><input type="submit" value="Elküld">
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
				if(!is_numeric($page)){
					$group_by = $uri[3];
					if(isset($uri[4]) && !is_numeric($uri[4])){
						$gb_value = $uri[4];
					}elseif(isset($uri[4]) && is_numeric($uri[4])){
						$page = $uri[4];
					}
					if(isset($uri[5])){
						$page = $uri[5];
					}elseif(!isset($uri[5]) && !is_numeric($uri[4])){
						$page = 1;
					}
					if(isset($_POST['order'])){
						$order = $_POST['order'];
						if($order=="ASC"){
							$neworder="DESC";
						}else{
							$neworder="ASC";
						}
					}else{
						$order="ASC";
						$neworder ="DESC";
					}
				}
				?>
				<h3>
				<?php
				if(isset($gb_value)){
					if($group_by=="user_id"){
						$gb_value = explode("'",$gb_value)[1];
					}
					$query = "SELECT * FROM log WHERE $group_by='$gb_value'";
				}elseif(isset($group_by)){
					$query = "SELECT * FROM log ORDER BY $group_by ASC";
				}else{
					$query = "SELECT * FROM log ORDER BY ts";
				}
				$arrsize = count($uri);
				$num_pages = ceil(mysqli_num_rows(mysqli_query($mysqli,$query))/15);
				if(($arrsize==4 && !is_numeric($uri[3])) || ($arrsize==5 && is_numeric($uri[4])) || (!isset($uri[4]) && $uri[3]=="user_id")){
					$url = "/admin/log/".$group_by."/";
				}elseif($arrsize==3){
					$url = "/admin/log/";
				}elseif($arrsize==5 || $arrsize==6 || ($arrsize==5 && $uri[3]=="user_id")){
					if($uri[3]=="user_id"){
						$gb_value = "'".$gb_value."'";
					}
					$url = "/admin/log/".$group_by."/".$gb_value."/";
				}else{
					$url = "/admin/log/";
				}
				if($page>3){
					?><a href="<?php echo $url; ?><?php echo $page-3; ?>"><span style="font-family:'Comic Sans MS';"><<<</span></a>&nbsp;<?php
				}
				if($page>1){
					?><a id="leftbutton" href="<?php echo $url; ?><?php echo $page-1; ?>"><span style="font-family:'Comic Sans MS';"><</span></a><?php
				}
				echo " $page ";
				if($page<$num_pages){
					?><a id="rightbutton" href="<?php echo $url; ?><?php echo $page+1; ?>"><span style="font-family:'Comic Sans MS';">></span></a>&nbsp;<?php
				}
				if($page<$num_pages-2){
					?><a href="<?php echo $url; ?><?php echo $page+3; ?>"><span style="font-family:'Comic Sans MS';">>>></span></a><?php
				}
				?></h3>
			<table>
				<tr>
					<th><h3><b><a onClick="$(this).parent.submit()" href="/admin/log/ip">IP</a></b></h3></th>
					<th><h3><b><a onClick="$(this).parent.submit()" href="/admin/log/data">Művelet</a></b></h3></th>
					<th><h3><b><a onClick="$(this).parent.submit()" href="/admin/log/ts">Idő</a></b></h3></th>
					<th><h3><b><a onClick="$(this).parent.submit()" href="/admin/log/user_id">Felhasználó</a></b></h3></th>
				</tr>
				<?php
				$page2 = ($page-1)*15;
				if(isset($gb_value)){
					if($group_by=="user_id"){
						$gb_value = explode("'",$gb_value)[1];
					}
					$query = "SELECT * FROM log WHERE $group_by='$gb_value' ORDER BY ts $order LIMIT 15 OFFSET $page2";
				}elseif(isset($group_by)){
					$query = "SELECT * FROM log ORDER BY $group_by $order LIMIT 15 OFFSET $page2";
				}else{
					$query ="SELECT * FROM log ORDER BY ts DESC LIMIT 15 OFFSET $page2";
				}
				$query = mysqli_query($mysqli,$query);
				while($row = mysqli_fetch_assoc($query)){
					$ip  = $row['ip'];
					$data = $row['data'];
					$ts = $row['ts'];
					$uid = $row['user_id'];
					if($uid==""){
						$uid=0;
					}
					?>
				<tr>
					<td><h3><a href="/admin/log/ip/<?php echo $ip; ?>"><?php echo get_ip($ip,$mysqli); ?></a></h3></td>
					<td><h3><a href="/admin/log/data/<?php echo $data; ?>"><?php echo $data; ?></a></h3></td>
					<td><h3><?php echo gmdate("Y/n/d H:i:s",$ts+3600); ?></h3></td>
					<td><h3><a href="/admin/log/user_id/'<?php echo $uid; ?>'"><?php echo get_username($uid,$mysqli); ?></a></h3></td>
					
				</tr>
					<?php
				}
				?>
			</table>
				<h3>
				<?php
				$arrsize = count($uri);
				if(($arrsize==4 && !is_numeric($uri[3])) || ($arrsize==5 && is_numeric($uri[4])) || (!isset($uri[4]) && $uri[3]=="user_id") || ($arrsize==5 && $uri[3]=="user_id")){
					$url = "/admin/log/".$group_by."/";
				}elseif($arrsize==3){
					$url = "/admin/log/";
				}elseif($arrsize==5 || $arrsize==6){
					$url = "/admin/log/".$group_by."/".$gb_value."/";
				}else{
					$url = "/admin/log/";
				}
				if($page>3){
					?><a href="<?php echo $url; ?><?php echo $page-3; ?>"><span style="font-family:'Comic Sans MS';"><<<</span></a>&nbsp;<?php
				}
				if($page>1){
					?><a id="leftbutton" href="<?php echo $url; ?><?php echo $page-1; ?>"><span style="font-family:'Comic Sans MS';"><</span></a><?php
				}
				echo " $page ";
				if($page<$num_pages){
					?><a id="rightbutton" href="<?php echo $url; ?><?php echo $page+1; ?>"><span style="font-family:'Comic Sans MS';">></span></a>&nbsp;<?php
				}
				if($page<$num_pages-2){
					?><a href="<?php echo $url; ?><?php echo $page+3; ?>"><span style="font-family:'Comic Sans MS';">>>></span></a><?php
				}
				?></h3><?php
			}elseif($mode=="pipes"){							// ###################### PIPÁK ######################
				if(isset($uri[3]) && $uri[3]!=""){
					$page = $uri[3];
				}else{
					$page = 1;
				}
				?>
				<h3>
				<?php
				$num_pages = ceil(mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM pipe"))/10);
				if($page>3){
					?><a href="/admin/pipes/<?php echo $page-3; ?>"><span style="font-family:'Comic Sans MS';"><<<</span></a>&nbsp;<?php
				}
				if($page>1){
					?><a id="leftbutton" href="/admin/pipes/<?php echo $page-1; ?>"><span style="font-family:'Comic Sans MS';"><</span></a><?php
				}
				echo " $page ";
				if($page<$num_pages){
					?><a id="rightbutton" href="/admin/pipes/<?php echo $page+1; ?>"><span style="font-family:'Comic Sans MS';">></span></a>&nbsp;<?php
				}
				if($page<$num_pages-2){
					?><a href="/admin/pipes/<?php echo $page+3; ?>"><span style="font-family:'Comic Sans MS';">>>></span></a><?php
				}
				?></h3>
			<table>
				<tr>
					<th><h3><b>Idő</b></h3></th>
					<th><h3><b>Dohány</b></h3></th>
					<th><h3><b>Állapot</b></h3></th>
					<th><h3><b>Felhasználó</b></h3></th>
					<th><h3><b>Töröl</b></h3></th>
					<th><h3><b>Megölés</b></h3></th>
					<th><h3><b>Mosás</b></h3></th>
					<th><h3><b>Új szén</b></h3></th>
				</tr>
				<?php
				$page2 = ($page-1)*10;
				$query = mysqli_query($mysqli,"SELECT * FROM pipe ORDER BY ts DESC LIMIT 10 OFFSET $page2");
				while($row = mysqli_fetch_assoc($query)){
					$id = $row['id'];
					$ts = $row['ts'];
					$type = $row['type'];
					$mosas = $row['mosas'];
					$ujszen = $row['uj_szen'];
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
						<td><h3><a href="/remove/<?php echo $id; ?>"><span style="font-family:'Comic Sans MS';">X</span></a></h3></td>
						<td><h3><?php if($vanpipa!="Meghalt"){ ?><a href="/kill/<?php echo $id; ?>"><span style="font-family:'Comic Sans MS';">X</span></a><?php } ?></h3></td>
						<td><h3><img width="24" src="<?php if($mosas!=0){ echo "/img/pipa.png"; }else{ echo "/img/x.png"; }?>"></h3></td>
						<td><h3><img width="24" src="<?php if($ujszen!=0){ echo "/img/pipa.png"; }else{ echo "/img/x.png"; }?>"></h3></td>
					</tr>
					<?php
				}
				?>
			</table>
			<h3>
				<?php
				if($page>3){
					?><a href="/admin/pipes/<?php echo $page-3; ?>"><span style="font-family:'Comic Sans MS';"><<<</span></a>&nbsp;<?php
				}
				if($page>1){
					?><a href="/admin/pipes/<?php echo $page-1; ?>"><span style="font-family:'Comic Sans MS';"><</span></a><?php
				}
				echo " $page ";
				if($page<$num_pages){
					?><a href="/admin/pipes/<?php echo $page+1; ?>"><span style="font-family:'Comic Sans MS';">></span></a>&nbsp;<?php
				}
				if($page<$num_pages-2){
					?><a href="/admin/pipes/<?php echo $page+3; ?>"><span style="font-family:'Comic Sans MS';">>>></span></a><?php
				}
				?></h3><?php 
			}elseif($mode=="ips"){
				?>
				<h3>
				<?php
					if(isset($uri[3]) && $uri[3]!=""){
						$page=$uri[3];
					}else{
						$page = 1;
					}
					$page2 = ($page-1)*15;
				$numpages = ceil(mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM iptable"))/15);
				if($page>3){
					?><a href="/admin/ips/<?php echo $page-3; ?>"><span style="font-family:'Comic Sans MS';"><<<</span></a>&nbsp;<?php
				}
				if($page>1){
					?><a id="leftbutton" href="/admin/ips/<?php echo $page-1; ?>"><span style="font-family:'Comic Sans MS';"><</span></a><?php
				}
				echo " $page ";
				if($page<$numpages){
					?><a id="rightbutton" href="/admin/ips/<?php echo $page+1; ?>"><span style="font-family:'Comic Sans MS';">></span></a>&nbsp;<?php
				}
				if($page<$numpages-2){
					?><a href="/admin/ips/<?php echo $page+3; ?>"><span style="font-family:'Comic Sans MS';">>>></span></a><?php
				}
				?>
				</h3>
				<table>
					<tr>
						<th><b><h3>ID</h3></b></th>
						<th><b><h3>IP</h3></b></th>
						<th><b><h3>Alias</h3></b></th>
					</tr>
					<?php
					$query = mysqli_query($mysqli,"SELECT * FROM iptable ORDER BY ip ASC LIMIT 15 OFFSET $page2");
					while($row = mysqli_fetch_assoc($query)){
						$ip = $row['ip'];
						$id = $row['id'];
						$name = $row['name'];
						?>
						<tr>
							<td><h3><?php echo $id; ?></h3></td>
							<td><h3><?php echo $ip; ?></h3></td>
							<td><h3><?php echo $name; ?></h3></td>
						</tr>
						<?php
					}
					?>
				</table>
				<h3>
				<?php
				if($page>3){
					?><a href="/admin/ips/<?php echo $page-3; ?>"><span style="font-family:'Comic Sans MS';"><<<</span></a>&nbsp;<?php
				}
				if($page>1){
					?><a href="/admin/ips/<?php echo $page-1; ?>"><span style="font-family:'Comic Sans MS';"><</span></a><?php
				}
				echo " $page ";
				if($page<$numpages){
					?><a href="/admin/ips/<?php echo $page+1; ?>"><span style="font-family:'Comic Sans MS';">></span></a>&nbsp;<?php
				}
				if($page<$numpages-2){
					?><a href="/admin/ips/<?php echo $page+3; ?>"><span style="font-family:'Comic Sans MS';">>>></span></a><?php
				}
				?>
				</h3>
				<?php
				
			}
			?>
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
				<a class="info button"<?php if($row['name']=="dohany"){ ?> href="/changestate/<?php echo $row['name']; ?>"<?php } ?> style="<?php if($row['name']=="szen"){ 
				?>border-right:1px solid rgba(0,0,0,0.4);
				<?php } 
				if($row['description']=="true"){ 
					$allapot = "van";
				}elseif($row['description']=="nemelado"){ 
					$allapot = "venni_kene"; 
				}elseif($row['description']=="vanelado"){
					$allapot = "elado";
				}else{ 
					$allapot = "nincs"; 
				}
				?>">
					<div><img style="width:100% !important;" src="/img/btn_<?php echo $row['name']; ?>_<?php echo $allapot; ?>.png"></div>
				</a>
					
			<?php
			} 
		}
		?>
		
		</footer>
	</body>
		<span class="fasz" style="text-align:right;">Írta: beni<br>
						Hint 2: próbálgass felhasználóneveket<br>
						Támogatóink: <a target="_blank" href="https://www.youtube.com/channel/UCLlTfVahBA62Nn2zLPDGSMg">DJ KotyogósHerka</a><br>
						Hosted by: Sztyúp</span>
	<script type="text/javascript" src="/js/jquery.js"></script>
	<script type="text/javascript" src="/js/notify.js"></script>
	<script type="text/javascript" src="/js/main.js"></script>
</html>