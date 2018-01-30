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

	$search_name = mysqli_query($con, "SELECT users.nome_user, universidades.nome_universidade, universidades.apelido_universidade, cursos.nome_curso FROM users INNER JOIN universidades ON users.cod_universidade = universidades.cod_universidade INNER JOIN cursos ON users.cod_curso = cursos.cod_curso WHERE cod_user LIKE '$codUser'");
	$row = mysqli_fetch_array($search_name);
	$nome = $row['nome_user'];
	$uniNom = $row['nome_universidade'];
	$uniAp = $row['apelido_universidade'];
	$curso = $row['nome_curso'];

?>

<!DOCTYPE html>
<html>
<head>
	<title><?php echo "$nome";?></title>
	<link rel="stylesheet" type="text/css" href="infoUs.css"/>
</head>
<body>
	<div class="navegador">
		<nav>
			<ul class="navP">				
				<div class="left">
					<li ><a href="index.php"><img id="classLogo" src="logo3.png"></a></li>
				</div>
				<div class="right">
					<li><a href="index.php"><b>Home</b></a></li>
					<li><a href='usuario.php'><b><?php echo "$nome";?></b></a></li>
					<li><a href="logout.php"><b>Sair</b></a></li>
				</div>
			</ul>
		</nav>
	</div>
	<div>
		<nav>
			<ul>
				<li><a href="infoUs.php"><b>Minhas Informaçōes</b></a></li>
				<li><a href="usuario.php"><b></b>Avaliaçōes</a></li>
				<li><a href="editarUs.php"><b></b>Editar Cadastro</a></li>
			</ul>			
		</nav>
	</div>
	<div>
		<label><b>Nome:</b></label>
		<h5><?php echo "$nome";?></h5>
		<label><b>Universidade:</b></label>
		<h5><?php echo "$uniNom" ." - ". "$uniAp";?></h5>
		<label><b>Curso:</b></label>
		<h5><?php echo "$curso";?></h5>

	</div>
</body>
</html>

