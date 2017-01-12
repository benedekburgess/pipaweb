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
			<h4>Zene toplista</h4>
		</aside>
		<section>
			Szavazás
			<?php
			
			?>
		</section>
		<nav class="music_page">
			Új szám leadása
		</nav>
	</body>
	<script type="text/javascript" src="/js/jquery.js"></script>
	<script type="text/javascript" src="/js/ajax.js"></script>
</html>