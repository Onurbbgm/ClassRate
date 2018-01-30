<?php
//1 is like and 2 is dislike
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

	switch($_POST["action"]){
		case "like":
			$query = "INSERT INTO ipaddress_likes_map (cod_avaliacao, ip_address, like_dislike) VALUES ('" . $_POST["id"] . "' , '" . $_SERVER['REMOTE_ADDR'] . "' , '1')";
			$result = mysqli_query($con, $query)or die(mysqli_error($con));
			if(!empty($result)) {
				$query ="UPDATE avaliacoes SET like_num = like_num + 1 WHERE cod_avaliacao ='" . $_POST["id"] . "'";
				$result = mysqli_query($con, $query)or die(mysqli_error($con));	
			}	
			$queryDis = "SELECT * FROM ipaddress_likes_map WHERE cod_avaliacao = '" . $_POST["id"] . "' and ip_address LIKE '" . $_SERVER['REMOTE_ADDR'] . "' and like_dislike LIKE '2'";
			$resultDis = mysqli_query($con, $queryDis) or die(mysqli_error($con));
			$count = mysqli_num_rows($resultDis);
			if(!empty($count)){
				$queryDis = "DELETE FROM ipaddress_likes_map WHERE ip_address = '" . $_SERVER['REMOTE_ADDR'] . "' and cod_avaliacao = '" . $_POST["id"] . "' and like_dislike LIKE '2'";
				$resultDis = mysqli_query($con, $queryDis) or die(mysqli_error($con));
				if(!empty($resultDis)){
					$queryDis ="UPDATE avaliacoes SET dislike_num = dislike_num - 1 WHERE cod_avaliacao ='" . $_POST["id"] . "' and dislike_num > 0";
					$resultDis = mysqli_query($con, $queryDis) or die(mysqli_error($con));
					// $query = "INSERT INTO ipaddress_likes_map (cod_avaliacao, ip_address, like_dislike) VALUES ('" . $_POST["id"] . "' , '" . $_SERVER['REMOTE_ADDR'] . "' , '1')";
					// $result = mysqli_query($con, $query)or die(mysqli_error($con));
					// if(!empty($result)) {
					// 	$query ="UPDATE avaliacoes SET like_num = like_num + 1 WHERE cod_avaliacao ='" . $_POST["id"] . "'";
					// 	$result = mysqli_query($con, $query)or die(mysqli_error($con));	
					// }
				}
			}		
		break;		
		case "unlike":
			$query = "DELETE FROM ipaddress_likes_map WHERE ip_address = '" . $_SERVER['REMOTE_ADDR'] . "' and cod_avaliacao = '" . $_POST["id"] . "' and like_dislike LIKE '1'";
			$result = mysqli_query($con, $query)or die(mysqli_error($con));
			if(!empty($result)) {
				$query ="UPDATE avaliacoes SET like_num = like_num - 1 WHERE cod_avaliacao ='" . $_POST["id"] . "' and like_num > 0";
				$result = mysqli_query($con, $query)or die(mysqli_error($con));
			}
		break;
		case "dislike":
			$query = "INSERT INTO ipaddress_likes_map (cod_avaliacao, ip_address, like_dislike) VALUES ('" . $_POST["id"] . "' , '" . $_SERVER['REMOTE_ADDR'] . "' , '2')";
			$result = mysqli_query($con, $query)or die(mysqli_error($con));
			if(!empty($result)) {
				$query ="UPDATE avaliacoes SET dislike_num = dislike_num + 1 WHERE cod_avaliacao ='" . $_POST["id"] . "'";
				$result = mysqli_query($con, $query)or die(mysqli_error($con));	

			}	
			$queryLik = "SELECT * FROM ipaddress_likes_map WHERE cod_avaliacao = '" . $_POST["id"] . "' and ip_address LIKE '" . $_SERVER['REMOTE_ADDR'] . "' and like_dislike LIKE '1'";
			$resultLik = mysqli_query($con, $queryLik) or die(mysqli_error($con));
			$count = mysqli_num_rows($resultLik);
			if(!empty($count)){
				$queryLik = "DELETE FROM ipaddress_likes_map WHERE cod_avaliacao = '" . $_POST["id"] . "' and ip_address LIKE '" . $_SERVER['REMOTE_ADDR'] . "' and like_dislike LIKE '1'";
				$resultLik = mysqli_query($con, $queryLik) or die(mysqli_error($con));
				if(!empty($resultLik)){
					$queryLik ="UPDATE avaliacoes SET like_num = like_num - 1 WHERE cod_avaliacao ='" . $_POST["id"] . "' and like_num > 0";
					$resultLik = mysqli_query($con, $queryLik) or die(mysqli_error($con));
				}
			}
		break;		
		case "undislike":
			$query = "DELETE FROM ipaddress_likes_map WHERE ip_address = '" . $_SERVER['REMOTE_ADDR'] . "' and cod_avaliacao = '" . $_POST["id"] . "' and like_dislike LIKE '2'";
			$result = mysqli_query($con, $query)or die(mysqli_error($con));
			if(!empty($result)) {
				$query ="UPDATE avaliacoes SET dislike_num = dislike_num - 1 WHERE cod_avaliacao ='" . $_POST["id"] . "' and dislike_num > 0";
				$result = mysqli_query($con, $query)or die(mysqli_error($con));
			}
		break;		
	}
}
?>