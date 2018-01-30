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

	if(isset($_GET['codUoP'])){
		$escolhaUoP = $_GET['codUoP'];
	}

	$codUser=0;
    if (isset($_COOKIE["codUser"])) {
        $codUser = $_COOKIE["codUser"];
    }

	$search_nameUser = mysqli_query($con, "SELECT nome_user FROM users WHERE cod_user LIKE '$codUser'");
	$rowName = mysqli_fetch_array($search_nameUser);
	$nomeUser = $rowName['nome_user'];
?>
<!DOCTYPE html>
<html>
<head>
	<title>Adicionar Universidade</title>

</head>
<body>
	<div class="navegador">
		<nav>
			<ul>				
				<div class="left">
					<li ><a href="index.php"><img id="classLogo" src="logo3.png"></a></li>
					<link rel="stylesheet" type="text/css" href="addUni.css"/>
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
	<h3><b>Universidade não esta no sitema, adicione ela</b></h3>
	<form action="armazenaUni.php" method="post">
		<label><b>Nome Universidade:</b></label>
		<div>
			<input type="hidden" id="escolhaVolta" value="<?=$escolhaUoP?>" name="escolhaVolta">
			<input type="text" placeholder="Nome Universidade" id = "nomeUni" name="nomeUni" required>				
		</div>
		<label><b>Apelido Universidade:</b></label>
		<div>
			<input type="text" placeholder="Apelido(sigla) Universidae" id = "apelidoUni" name="apelidoUni" required>				
		</div>
		<div class="botoes">
				<button name = "sub" id = "sub" type="submit" class="signupbtn">Confirmar</button>
				<button name = "cancel" id = "cancel" type="submit" class="cancelbtn">Cancelar</button>
		</div>
	</form>



</body>
</html>