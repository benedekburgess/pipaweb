<?php
require_once "inc/init.php";
if($logged_in==false){
	header("Location: /");
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
		<link rel="stylesheet" type="text/css" href="/css/main.css" />
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
			<h4>Zene várólista</h4>
			<table>
				<tr>
					<th><h3><b>Rank</b></h3></th>
					<th><h3><b>Cím</b></h3></th>
					<th><h3><b>Szavazatok</b></h3></th>
					<th><h3><b>Link</b></h3></th>
				</tr>
			<?php
			$query = mysqli_query($mysqli,"SELECT * FROM music WHERE played='0' ORDER BY votes DESC");
			$rank = 1;
			while($row = mysqli_fetch_assoc($query)){
				$link = $row['link'];
				$title = $row['name'];
				$votes = $row['votes'];
				$rank++;
				?>
				<tr>
					<td><h3><?php echo $rank; ?></h3></td>
					<td><h3><?php echo $title; ?></h3></td>
					<td><h3><?php echo $votes; ?></h3></td>
					<td><h3><?php if($rank==1){ ?><a href=""><span style='font-family:"Comic Sans MS"'>X</span></a><?php } ?></h3></td>
				</tr>
				<?php
			}
			?>
		</aside>
		<section>
			Szavazás
		</section>
		<nav>
			Új szám leadása
			<form action="/ujzene" method="POST" id="form">
				<input type="text" name="link" placeholder="Youtube link"><input type="submit" value="Elküld">
			</form>
		</nav>
	</body>
	<script type="text/javascript" src="/js/jquery.js"></script>
	<script type="text/javascript" src="/js/ajax.js"></script>
</html>