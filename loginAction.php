<?php
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
	//login depois do cadastro
	// $logCad = 0;
	// if(isset($_POST['logCadastro'])){
	// 	$logCad = $_POST['logCadastro'];
	// }

	if(isset($_POST['login'])){
		$login = $_POST['login'];
	}

	if($login==NULL){
		echo"<script language='javascript' type='text/javascript'>alert('Campo e-mail não preenchido');window.location.href='login.php';</script>";	
		exit;
	}

	if (isset($_POST['password'])) {
		$passUser = $_POST['password'];
	}

	if ($passUser==NULL) {
		echo"<script language='javascript' type='text/javascript'>alert('Campo senha não preenchido');window.location.href='login.php';</script>";	
		exit;
	}

	// $cryppass = password_hash($passUser, PASSWORD_BCRYPT);
	// if(!$cryppass){
	// 	echo"<script language='javascript' type='text/javascript'>alert('ERROR PASS CRYPT');window.location.href='cadastro.php';</script>";
	// 	exit;
	// }
	$search_passHash = mysqli_query($con,"SELECT passw_user FROM users WHERE email_user LIKE '$login'");
	$rowU = mysqli_fetch_array($search_passHash);
	$hash = $rowU['passw_user'];
	if(!password_verify($passUser, $hash)){
		echo"<script language='javascript' type='text/javascript'>alert('Login e/ou senha incorretos');window.location.href='login.php';</script>";
		exit;
	}

	$search_sqlU = mysqli_query($con,"SELECT cod_user FROM users WHERE email_user LIKE '$login' and passw_user LIKE '$hash'");
	$rowU = mysqli_fetch_array($search_sqlU);
	$userCod = $rowU['cod_user'];

	if ($userCod==0) {
		echo"<script language='javascript' type='text/javascript'>alert('Login e/ou senha incorretos');window.location.href='login.php';</script>";
		// header('Location: login.php');
		exit;
	}

	else{
		setcookie("login", $login, time() + (10 * 365 * 24 * 60 * 60));
		setcookie("password", $passUser, time() + (10 * 365 * 24 * 60 * 60));
		setcookie("codUser", $userCod, time() + (10 * 365 * 24 * 60 * 60));
		header('Location: usuario.php');

	}





?>