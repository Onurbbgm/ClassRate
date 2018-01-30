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

	if (isset($_POST['escolhaVolta'])) {
		$escolhaVolta = $_POST['escolhaVolta'];
	}

	if(isset($_POST['canel'])){
		if ($escolhaVolta==1) {
			header('Location: cadastro.php');
			exit;
		}
		if ($escolhaVolta==2) {
			header('Location: cadastroProfessor.php');
			exit;
		}
		if ($escolhaVolta==3) {
			header('Location: altAcad.php');
			exit;
		}
		else{
			header('Location: index.php');
			exit;
		}
	}

	if(isset($_POST['nomeUni'])){
		$nomeUni = $_POST['nomeUni'];
	}

	if($nomeUni == NULL){
		 echo"<script language='javascript' type='text/javascript'>alert('Campo NOME não preenchido');window.location.href='addUni.php';</script>";
		 exit;
	}

	if(isset($_POST['apelidoUni'])){
		$apelidoUni = $_POST['apelidoUni'];
	}

	if($apelidoUni == NULL){
		 echo"<script language='javascript' type='text/javascript'>alert('Campo APELIDO não preenchido');window.location.href='addUni.php';</script>";
		 exit;
	}

	function newUni($con, $db, $nomeUni, $apelidoUni){
		$query = "INSERT INTO universidades (nome_universidade, apelido_universidade) VALUES ('$nomeUni', '$apelidoUni')";
		$data = mysqli_query($con, $query)or die(mysqli_error($con));
		if($data){
			echo "Registrado com sucesso ";
		}

	}


	if(isset($_POST['sub'])){
		newUni($con, $db, $nomeUni, $apelidoUni);
		if ($escolhaVolta==1) {
			header('Location: cadastro.php');
			exit;
		}
		if ($escolhaVolta==2) {
			header('Location: cadastroProfessor.php');
			exit;
		}
		if ($escolhaVolta==3) {
			header('Location: altAcad.php');
			exit;
		}
		else{
			header('Location: index.php');
			exit;
		}
	}



?>