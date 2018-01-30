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
	$search_name = mysqli_query($con, "SELECT nome_user FROM users WHERE cod_user LIKE '$codUser'");
	$rowName = mysqli_fetch_array($search_name);
	$nome = $rowName['nome_user'];
	
?>


<!DOCTYPE html>
<html>
<head>
	<title>Alterar Senha</title>
	<link rel="stylesheet" type="text/css" href="editarUs.css"/>
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
		<form action="altSenhaAction.php" method="post">
			<label><b>Senha Atual:</b></label>
			<div>
				<input type="password" placeholder="Senha" id="passwordAtual" name="passAtual" required>
			</div>
			<label><b>Nova senha:</b></label>
			<div>
				<input type="password" placeholder="Senha" id="novpassword" name="novpass" required>
			</div>
			<label><b>Confirmar nova senha:</b></label>
			<div>
				<input type="password" placeholder="Confirmar Nova Senha" id="confirmar_novpass" name="con_novpass" required>
			</div>
			<div class="botoes">
				<button name = "sub" id = "sub" type="submit" class="signupbtn">Confirmar</button>
				<button name = "cancel" id = "cancel" type="submit" class="cancelbtn">Cancelar</button>
			</div>
		</form>
	</div>


</body>
</html>


