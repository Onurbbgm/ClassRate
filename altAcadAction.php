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

	if(isset($_POST['universidade'])){
		$universidade = $_POST['universidade']; 
	}

	if(isset($_POST['curso'])){
		$curso = $_POST['curso']; 
	}
	if($curso==NULL && $universidade==NULL){
		echo"<script language='javascript' type='text/javascript'>alert('Nada a ser alterado');window.location.href='altAcad.php';</script>";
		exit;
	}
	$uniCod = 0;
	if ($universidade!=NULL) {
		$search_sqlU = mysqli_query($con,"SELECT cod_universidade FROM universidades WHERE nome_universidade LIKE '$universidade' or apelido_universidade LIKE '$universidade'");
		$rowU = mysqli_fetch_array($search_sqlU);
		$uniCod = $rowU['cod_universidade'];
		//Caso universidade nao esteja no sistema
		if ($uniCod==0) {
			header('Location: addUni.php?codUoP='.$cadastroUser);
			exit;
		}
	}


	$cursoCod = 0;
	if ($curso != NULL) {
		$search_sqlC = mysqli_query($con,"SELECT cod_curso FROM cursos WHERE nome_curso LIKE '$curso'");
		$rowC = mysqli_fetch_array($search_sqlC);	
		$cursoCod = $rowC['cod_curso'];
		//Caso curso nao exista no sistema
		if ($cursoCod==0) {
			$queryC = "INSERT INTO cursos (nome_curso) VALUES ('$curso')";
			$dataC = mysqli_query($con, $queryC)or die(mysqli_error($con));
			$search_sqlC2 = mysqli_query($con,"SELECT cod_curso FROM cursos WHERE nome_curso LIKE '$curso'");
			$rowC2 = mysqli_fetch_array($search_sqlC2);
			$cursoCod = $rowC2['cod_curso'];
		}
	}

	function AlterAcad($con, $cursoCod, $uniCod, $codUser){
		if ($cursoCod!=0) {
			$query = "UPDATE users SET cod_curso = '$cursoCod' WHERE cod_user LIKE '$codUser'";
			$result = mysqli_query($con, $query);
		}
		if ($uniCod!=0) {
			$query = "UPDATE users SET cod_universidade = '$uniCod' WHERE cod_user LIKE '$codUser'";
			$result = mysqli_query($con, $query);
		}
		echo"<script language='javascript' type='text/javascript'>alert('Alterado com sucesso');window.location.href='infoUs.php';</script>";
		exit;
	}

	if($_SERVER['REQUEST_METHOD'] == "POST"){
		
		AlterAcad($con, $cursoCod, $uniCod, $codUser);
	}


?>