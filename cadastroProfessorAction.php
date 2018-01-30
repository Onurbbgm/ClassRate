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

	if(isset($_POST['nomeProf'])){
		$nameProf = $_POST['nomeProf'];
	}

	if($nameProf == NULL){
		echo"<script language='javascript' type='text/javascript'>alert('Campo NOME não preenchido');window.location.href='cadastroProfessor.php';</script>";
		exit;
	}

	if (isset($_POST['cadastroProf'])) {
		$cadastroProf = $_POST['cadastroProf'];
	}

	if(isset($_POST['universidade'])){
		$universidade = $_POST['universidade']; 
	}

	if($universidade == NULL){
		echo"<script language='javascript' type='text/javascript'>alert('Campo UNIVERSIDADE não preenchido');window.location.href='cadastroProfessor.php';</script>";
		exit;
	}

	$search_sqlU = mysqli_query($con,"SELECT cod_universidade FROM universidades WHERE nome_universidade LIKE '$universidade' or apelido_universidade LIKE '$universidade'");
	$rowU = mysqli_fetch_array($search_sqlU);
	$uniCod = $rowU['cod_universidade'];
	//Caso universidade nao esteja no sistema
	if ($uniCod==0) {
		header('Location: addUni.php?codUoP='.$cadastroProf);
		exit;
	}

	if(isset($_POST['curso'])){
		$curso = $_POST['curso']; 
	}

	if($curso == NULL){
		echo"<script language='javascript' type='text/javascript'>alert('Campo CURSO não preenchido');window.location.href='cadastroProfessor.php';</script>";
		exit;
	}

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
		
	function NewProfessor($con,$db,$nameProf, $uniCod, $cursoCod){
		$query = "INSERT INTO professores (nome_professor, cod_universidade) VALUES ('$nameProf','$uniCod')"; 
		$data = mysqli_query($con, $query)or die(mysqli_error($con));
		$queryS = mysqli_query($con, "SELECT cod_professor FROM professores WHERE nome_professor LIKE '$nameProf' and cod_universidade LIKE '$uniCod'");
		$resultS = mysqli_fetch_array($queryS);
		$cod_proff = $resultS[0];
		$query2 = "INSERT INTO professores_cursos (cod_professor, cod_curso) VALUES ('$cod_proff','$cursoCod')";
		$data2 = mysqli_query($con, $query2)or die(mysqli_error($con));
		if($data && $data2) { 
			echo "YOUR REGISTRATION IS COMPLETED...";
			header('Location: professor.php?codP='.$cod_proff);
			exit;
		}
	}

	function Verifica($con,$db,$nameProf, $uniCod, $cursoCod){
		// $queryU = mysqli_query($con,"SELECT cod_universidade FROM universidades WHERE apelido_universidade = '$universidade' OR nome_universidade = '$universidade'");
		// $resultU = mysqli_fetch_array($queryU);
		// $queryC = mysqli_query($con, "SELECT cod_curso FROM cursos WHERE nome_curso = '$curso'");
		// $resultC = mysqli_fetch_array($queryC);
		// $cod_uni = $resultU[0];
		// $cod_curso = $resultC[0];
		// if($cod_uni == 0){
		// 	echo "Universidade nao esta no sistema";
		// 	exit;
		// }

		// if($cod_curso == 0){
		// 	echo "Curso nao esta no sistema";
		// 	exit;
		// }

		
		NewProfessor($con,$db,$nameProf, $uniCod, $cursoCod);
		
	}

	if (isset($_POST['cancel'])) {
		header('Location: index.php');
		exit;
	}

	if($_SERVER['REQUEST_METHOD'] == "POST"){
		
		Verifica($con, $db, $nameProf, $uniCod, $cursoCod);
		
	}

	// else{
	// 	echo "Nao funcionou";
	// 	exit;
	// }



?>