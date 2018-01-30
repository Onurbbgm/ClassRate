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

		// while ($row = mysqli_fetch_array($search_sql)) {
		// 	//$array[] = array('label' => $row['nome_professor'], 'value'=> $row['nome_professor']);
		// 	//array_push($array, $row['nome_professor']);
		// 	$nome = $row['nome_professor'];
		// 	echo "$nome\n";
		// }
		// echo json_encode($array);
	
	if(isset($_GET['search'])){
		$nomeProf = $_GET['search'];
	}
	$codUser=0;
    if (isset($_COOKIE["codUser"])) {
        $codUser = $_COOKIE["codUser"];
    }
	// $nomeProf = $_GET['search'];
	$search_nameUser = mysqli_query($con, "SELECT nome_user FROM users WHERE cod_user LIKE '$codUser'");
    $rowName = mysqli_fetch_array($search_nameUser);
    $nomeUser = $rowName['nome_user'];
	$search_sql = mysqli_query($con,"SELECT professores.nome_professor, universidades.apelido_universidade, professores.cod_professor FROM professores INNER JOIN universidades ON professores.cod_universidade = universidades.cod_universidade  WHERE professores.nome_professor LIKE '%$nomeProf%'");
	//$array = array();
	if(mysqli_num_rows($search_sql)!=0)	{
		$row = mysqli_fetch_array($search_sql);
	}



?>



<!DOCTYPE html>
<html>
<head>
	<title>Resultados</title>
	<link rel="stylesheet" type="text/css" href="listaProfessores.css"/>
</head>
<body>
	<div class="navegador">
		<nav>
			<ul>				
				<div class="left">
					<li ><a href="index.php"><img id="classLogo" src="logo3.png"></a></li>
				</div>
				<div class="right">
					<li><a href="index.php"><b>Home</b></a></li>
					<?php 
						if ($codUser==""||$codUser=="0") {
					?>
						<li><a href='cadastro.php'><b>Cadastro</b></a></li>
						<li><a href='login.php'><b>Login</b></a></li>
						<?php
					}
						else{
							?>
							<li><a href='usuario.php'><b><?php echo "$nomeUser";?></b></a></li>
							<li><a href="logout.php"><b>Sair</b></a></li>
							<?php
						}
					?>
				</div>
			</ul>
		</nav>
	</div>
	<h3>Resultados: </h3>
	<?php
		if(mysqli_num_rows($search_sql)!=0){
			do  {
				$nome = $row['nome_professor'];
				$universidade = $row['apelido_universidade'];
				$codProf = $row['cod_professor'];
				?>
				<p><a href="professor.php?codP=<?php echo $codProf;?>"><?php echo "$nome - $universidade";?></a></p>
		<?php } while ($row = mysqli_fetch_array($search_sql));
	
		}else{
			echo "Sem Resultados, gostaria de adicionar um professor?";
		}

	?>

	<h4>Não é quem você estava procurando?
		Adicione um professor.
	</h4>
	
		<h5><a href="cadastroProfessor.php">Adicione Professor</a></h5>
	
	
</body>

</html>