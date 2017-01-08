<?php
require_once "inc/init.php";
if($_SERVER['REMOTE_ADDR']!="152.66.180.120"){
	exit("buzi");
}else{
	if(isset($_POST['query'])){
		$query_text = $_POST['query'];
		$query = mysqli_query($mysqli,$query_text);
		$error = mysqli_error($mysqli);
		if(isset($error) && $error!=""){
			echo "MYSQL ERROR:<br>";
			echo $error;
		}else{
			echo "CODE RAN WITHOUT ERRORS";
			print_r(mysqli_fetch_assoc($query));
			echo mysqli_error($mysqli);
		}
	}
	?>
	<form action="/sql" method="POST">
		<textarea autofocus cols="80" rows="50" name="query"><?php if(isset($query_text)){ echo "$query_text"; } ?></textarea>
		<input type="submit">
	</form>
	<?php
}
?>