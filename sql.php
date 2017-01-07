<?php
require_once "inc/init.php";
if($_SERVER['REMOTE_ADDR']!="89.132.82.69"){
	exit("buzi");
}else{
	if(isset($_POST['query'])){
		$query_text = $_POST['query'];
		$query = mysqli_query($mysqli,$query_text);
		$error = mysqli_error($mysqli);
		if(isset($error)){
			echo "MYSQL ERROR:<br>";
			echo $error;
		}
	}
	?>
	<form action="/sql" method="POST">
	
	</form>
	<?php
}
?>