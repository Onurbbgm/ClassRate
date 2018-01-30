
<?php
if(!empty($_POST["id"])) {
define('DB_HOST', 'localhost');
define('DB_NAME', 'class_rate');
define('DB_USER', 'root');
define('DB_PASSWORD', 'vB42lL&69_r');

	$con = mysqli_connect(DB_HOST, DB_USER);
	if(!$con){
		die("Databese Connection Failed" . mysqli_error($con));
	}
	$db = mysqli_select_db($con, DB_NAME);
	if(!$db){
		die("Databese Selection Failed" . mysqli_error($con));
	}
	$queryDel = "DELETE FROM ipaddress_likes_map WHERE cod_avaliacao = '" . $_POST["id"] . "'";
	$resultDel = mysqli_query($con, $queryDel);
	$queryDel = "DELETE FROM avaliacoes WHERE cod_avaliacao = '" . $_POST["id"] . "'";
	$resultDel = mysqli_query($con, $queryDel);
}
?>