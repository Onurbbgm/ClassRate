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

	if(isset($_POST['codP'])){
		$codProf = $_POST['codP'];
	}

	if(isset($_POST['cancel'])){
		header('Location: professor.php?codP='.$codProf);
		exit;
	}

	$codUser = 0;
	if(isset($_COOKIE["codUser"])){
		$codUser = $_COOKIE["codUser"];
	}

	

	if($codUser==""||$codUser==0){
		echo"<script language='javascript' type='text/javascript'>alert('Você deve estar logado para realizar uma avaliação');window.location.href='professor.php?codP=".$codProf."';</script>";
		// header('Location: login.php');
		// header('Location: professor.php?codP='.$codProf);
		exit;
	}

	

	if(isset($_POST['disciplina'])){
		$disciplina = $_POST['disciplina'];
	}

	if ($disciplina==NULL) {
		echo"<script language='javascript' type='text/javascript'>alert('Campo DISCIPLINA não preenchido');window.location.href='avaliarProfessor.php?codP=".$codProf."&avaliar=';</script>";	
		exit;
	}

	// echo "$disciplina ";

	$search_sqlD = mysqli_query($con,"SELECT cod_disciplina FROM disciplinas WHERE nome_disciplina LIKE '$disciplina'");
	$rowD = mysqli_fetch_array($search_sqlD);
	$codDisciplina = $rowD['cod_disciplina'];
	//disciplina nao existe no sistema
	if ($codDisciplina==0) {
		$queryD = "INSERT INTO disciplinas (nome_disciplina) VALUES ('$disciplina')";
		$dataD = mysqli_query($con, $queryD)or die(mysqli_error($con));
		$search_sqlD2 = mysqli_query($con,"SELECT cod_disciplina FROM disciplinas WHERE nome_disciplina LIKE '$disciplina'");
		$rowD2 = mysqli_fetch_array($search_sqlD2);
		$codDisciplina = $rowD2['cod_disciplina'];
		$queryD2 = "INSERT INTO disciplinas_professores (cod_disciplina, cod_professor) VALUES ('$codDisciplina', '$codProf')";
		$dataD2 = mysqli_query($con, $queryD2)or die(mysqli_error($con));
	}

	//curso existe no sistema
	else{
		$search_sqlD3 = mysqli_query($con,"SELECT cod_disciplina FROM disciplinas_professores WHERE cod_professor LIKE '$codProf' and cod_disciplina LIKE '$codDisciplina'");
		$rowD3 = mysqli_fetch_array($search_sqlD3);
		$codDisciplinaConf = $rowD3['cod_disciplina'];
		if ($codDisciplinaConf==0) {
			$queryD3 = "INSERT INTO disciplinas_professores (cod_disciplina, cod_professor) VALUES ('$codDisciplina', '$codProf')";
			$dataD3 = mysqli_query($con, $queryD3)or die(mysqli_error($con));
		}
	}

	if(isset($_POST['curso'])){
		$curso = $_POST['curso'];
	}

	if ($curso==NULL) {
		echo"<script language='javascript' type='text/javascript'>alert('Campo COMENTARIO não preenchido');window.location.href='avaliarProfessor.php?codP=".$codProf."&avaliar=';</script>";
		exit;
	}
		// echo "$curso";
	$search_sql = mysqli_query($con,"SELECT cod_curso FROM cursos WHERE nome_curso LIKE '$curso'");
	$row = mysqli_fetch_array($search_sql);
	$codCurso = $row['cod_curso'];
	//curso nao existe no sistema
	if($codCurso==0){
		$query = "INSERT INTO cursos (nome_curso) VALUES ('$curso')";
		$data = mysqli_query($con, $query)or die(mysqli_error($con));
		$search_sql3 = mysqli_query($con,"SELECT cod_curso FROM cursos WHERE nome_curso LIKE '$curso'");
		$row3 = mysqli_fetch_array($search_sql3);
		$codCurso = $row3['cod_curso'];
		$query2 = "INSERT INTO professores_cursos (cod_professor, cod_curso) VALUES ('$codProf','$codCurso')";
		$data2 = mysqli_query($con, $query2)or die(mysqli_error($con));
	}
	//curso existe no sistema
	else{
		
		$search_sql2 = mysqli_query($con,"SELECT cod_curso FROM professores_cursos WHERE cod_professor LIKE '$codProf' and cod_curso LIKE '$codCurso'");
		$row2 = mysqli_fetch_array($search_sql2);
		$codCursoConf = $row2['cod_curso'];
		//professor nao esta associado a esse curso
		if($codCursoConf==0){
			$query3 = "INSERT INTO professores_cursos (cod_professor, cod_curso) VALUES ('$codProf','$codCurso')";
			$data3 = mysqli_query($con, $query3)or die(mysqli_error($con));
		}else{
			$codCurso = $row2['cod_curso'];
		}

	}

	if(isset($_POST['notaG'])){
		$notaGer = $_POST['notaG'];
	}

	if ($notaGer==NULL) {
		echo"<script language='javascript' type='text/javascript'>alert('Campo COMENTARIO não preenchido');window.location.href='avaliarProfessor.php?codP=".$codProf."&avaliar=';</script>";
		exit;
	}

	if(isset($_POST['nivelD'])){
		$nivelDif = $_POST['nivelD'];
	}

	if ($nivelDif==NULL) {
		echo"<script language='javascript' type='text/javascript'>alert('Campo COMENTARIO não preenchido');window.location.href='avaliarProfessor.php?codP=".$codProf."&avaliar=';</script>";
		exit;
	}

	if(isset($_POST['op1'])){
		$repetProf = $_POST['op1'];
	}

	if ($repetProf==NULL) {
		echo"<script language='javascript' type='text/javascript'>alert('Campo COMENTARIO não preenchido');window.location.href='avaliarProfessor.php?codP=".$codProf."&avaliar=';</script>";
		exit;
	}

	if(isset($_POST['pres'])){
		$presenca = $_POST['pres'];
	}

	if ($presenca==NULL) {
		echo"<script language='javascript' type='text/javascript'>alert('Campo COMENTARIO não preenchido');window.location.href='avaliarProfessor.php?codP=".$codProf."&avaliar=';</script>";
		exit;
	}

	if(isset($_POST['comentario'])){
		$comentario = $_POST['comentario'];
	}

	if ($comentario==NULL) {
		echo"<script language='javascript' type='text/javascript'>alert('Campo COMENTARIO não preenchido');window.location.href='avaliarProfessor.php?codP=".$codProf."&avaliar=';</script>";	
		exit;
	}

	if(isset($_POST['pass'])){
		$passou = $_POST['pass'];
	}

	if(isset($_POST['notaR'])){
		$notaRec = $_POST['notaR'];
	}

	if(!isset($_POST['pass']) || $_POST['pass']=="3"){
		$passou = 5;
	}

	if(!isset($_POST['notaR'])|| $_POST['notaR']==""){
		$notaRec = 42;
	}

	if($repetProf == "1"){ //sim
		$repetProf = 1;
	}

	if($repetProf == "2"){ //nao
		$repetProf = 2;
	}

	if($presenca =="3"){ //rigido
		$presenca = 3;
	}

	if($presenca =="1"){ //flexivel
		$presenca = 1;
	}

	if($presenca =="2"){ //nem precisa ir
		$presenca = 2;
	}





	function newAvaliacao($con,$db, $codProf, $codDisciplina, $codCurso, $notaGer, $nivelDif, $repetProf, $presenca, $comentario, $passou, $notaRec, $curso, $disciplina, $codUser){
		// if($passou != null && $notaRec != null ){
			$query = "INSERT INTO avaliacoes (notaGeral, nivelDificuldade, repetirProf, presenca, comentario, passou, notaRecebida, like_num, dislike_num, cod_curso, cod_disciplina, cod_user, cod_professor) VALUES ('$notaGer', '$nivelDif', '$repetProf', '$presenca', '$comentario', '$passou', '$notaRec', '0', '0', '$codCurso', '$codDisciplina', '$codUser', '$codProf') ";
			$data = mysqli_query($con, $query)or die(mysqli_error($con));
			if($data){
				echo "Registrado com sucesso ";
				//echo "$disciplina ";
				//echo "$curso";
				//exit;
			}
		// }
		// if ($passou == null && $notaRec != null) {
		// 	$query = "INSERT INTO avaliacoes (notaGeral, nivelDificuldade, repetirProf, presenca, comentario, passou, notaRecebida, cod_curso, cod_disciplina, cod_user, cod_professor) VALUES ('$notaGer', '$nivelDif', '$repetProf', '$presenca', '$comentario', '$passou', '$notaRec', '$curso', '$disciplina', '30', '$codProf') ";
		// }
	}


	if(isset($_POST['sub'])){
		newAvaliacao($con,$db, $codProf, $codDisciplina, $codCurso, $notaGer, $nivelDif, $repetProf, $presenca, $comentario, $passou, $notaRec, $curso, $disciplina, $codUser);
		$codAvaliacao = mysqli_insert_id($con);
		// echo "codA: $codAvaliacao";
		if(isset($_POST['tags'])){
			$tags = $_POST['tags'];
			$tagArray = explode(",", $tags);
			// $numTag = count($_POST['tags']);
			$numTag = count($tagArray);
			for ($i=0; $i < $numTag; $i++) { 
				$codTag = $tagArray[$i];
				// echo "$numTag";
				// echo "$codTag ,";
				$insertTag = "INSERT INTO tags_professores_avaliacoes (cod_tag, cod_professor, cod_avaliacao) VALUES ($codTag, $codProf, $codAvaliacao)";
				$dataTag = mysqli_query($con, $insertTag)or die(mysqli_error($con));
			}
		}
		header('Location: professor.php?codP='.$codProf);
	}	



?>