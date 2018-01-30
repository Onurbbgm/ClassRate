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

	// if(isset($_POST['search'])){
	// 	$nomeProf = $_POST['search'];
		// $search_sql = mysqli_query($con,"SELECT nome_professor FROM professores WHERE nome_professor LIKE '%$nomeProf%'");
		// $array = array();
		// if(mysqli_num_rows($search_sql)!=0)	{
		// 	mysqli_fetch_array($search_sql);
		// }
		// while ($row = mysqli_fetch_array($search_sql)) {
		// 	//$array[] = array('label' => $row['nome_professor'], 'value'=> $row['nome_professor']);
		// 	//array_push($array, $row['nome_professor']);
		// 	$nome = $row['nome_professor'];
		// 	echo "$nome\n";
		// }
		//echo json_encode($array);

	// }

	if (isset($_GET['term'])){
		$nomeProf = $_GET['term'];
	}

	if (!$nomeProf) {
		return;
	}

	//$search_sql = mysqli_query($con,"SELECT professores'.nome_professor', universidades'.nome_universidade' FROM 'universidades' INNER JOIN 'professores' ON universidades'.cod_universidade' = professores'.cod_universidade'  WHERE professores'.nome_professor' LIKE '%$nomeProf%'");
	$search_sql = mysqli_query($con,"SELECT professores.nome_professor, professores.cod_professor, universidades.apelido_universidade FROM professores INNER JOIN universidades ON professores.cod_universidade = universidades.cod_universidade  WHERE professores.nome_professor LIKE '%$nomeProf%'");
	if (!$search_sql) {
    	printf("Error: %s\n", mysqli_error($con));
    	exit();
	}
	// $array = array();
	// if(mysqli_num_rows($search_sql)!=0)	{
		// mysqli_fetch_array($search_sql);
	// }
	while ($row = mysqli_fetch_array($search_sql)) {
		//$array[] = array('label' => $row['nome_professor'], 'value'=> $row['nome_professor']);
		//array_push($array, $row['nome_professor']);
		$nome = $row['nome_professor'];
		$universidade = $row['apelido_universidade'];
		$codProf = $row['cod_professor'];
		$values = array(array('id' => $codProf, 'label' => $nome . ' - ' . $universidade));
		// $returnArray = array('value'=>$row['cod_professor'], 'label' =>$row['nome_professor']);
		// echo "$nome - $universidade\n";
		echo json_encode($values);
		// foreach ($returnArray as $key => $value) {
		// 	echo $returnArray['label'], '<br>';
		// }
		
	}

	// else{
	// 	header("Location:index.html");
	// 	exit;
	// }

	




?>