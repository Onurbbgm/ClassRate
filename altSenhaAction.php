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

	$codUser = 0;
	if (isset($_COOKIE["codUser"])) {
		$codUser = $_COOKIE["codUser"];
	}

	if($codUser==""||$codUser==0){
		echo"<script language='javascript' type='text/javascript'>alert('Você deve estar logado para usar essa função');window.location.href='index.php';</script>";
		exit;
	}

	if (isset($_POST['cancel'])) {
		header('Location: editarUs.php');
		exit;
	}

	if (isset($_POST['passAtual'])) {
		$passAtual = $_POST['passAtual'];
	}

	if ($passAtual == NULL) {
		echo"<script language='javascript' type='text/javascript'>alert('Campo SENHA ATUAL não preenchido');window.location.href='altSenha.php';</script>";
		exit;
	}

	if (isset($_POST['novpass'])) {
		$novPass = $_POST['novpass'];
	}

	if ($novPass == NULL) {
		echo"<script language='javascript' type='text/javascript'>alert('Campo NOVA SENHA não preenchido');window.location.href='altSenha.php';</script>";
		exit;
	}

	if (isset($_POST['con_novpass'])) {
		$conNoPass = $_POST['con_novpass'];
	}

	if ($conNoPass == NULL) {
		echo"<script language='javascript' type='text/javascript'>alert('Campo SENHA ATUAL não preenchido');window.location.href='altSenha.php';</script>";
		exit;
	}

	$query = "SELECT nome_user FROM users WHERE cod_user LIKE '$codUser' and passw_user LIKE '$passAtual'";
	$result = mysqli_query($con, $query);
	if(!empty($result)){
		if ($novPass == $conNoPass) {
			$query = "UPDATE users SET passw_user = '$novPass' WHERE cod_user LIKE '$codUser'";
			$result = mysqli_query($con, $query);
			echo"<script language='javascript' type='text/javascript'>alert('Senha atualizada com sucesso');window.location.href='editarUs.php';</script>";
			exit;
		}else{
			echo"<script language='javascript' type='text/javascript'>alert('Senha não confere');window.location.href='altSenha.php';</script>";
			exit;
		}
	}else{
		echo"<script language='javascript' type='text/javascript'>alert('Senha atual incorreta!');window.location.href='altSenha.php';</script>";
		exit;
	}



?>