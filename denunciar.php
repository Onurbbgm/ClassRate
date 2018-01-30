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
	$codUser=0;
    if (isset($_COOKIE["codUser"])) {
        $codUser = $_COOKIE["codUser"];
    }

    if(isset($_GET['codAv'])){
    	$codAvaliacao = $_GET['codAv'];
    }

    $searchAv = mysqli_query($con, "SELECT comentario FROM avaliacoes WHERE cod_avaliacao = '$codAvaliacao'");
    $resultAv = mysqli_fetch_array($searchAv);
    $comentario = $resultAv['comentario'];

?>

<!DOCTYPE html>
<html>
<head>
	<title>Denunciar Avaliação</title>
	<link rel="stylesheet" type="text/css" href="denunciar.css"/>
</head>
<body>
	<div class="navegador">
		<nav>
			<ul>
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
			</ul>
		</nav>
	</div>
	<h3>
	</h3>

	<div class="comAva">
		<p><?php echo "$comentario"?></p>
	</div>
	<div class="forms">
		<form>
			<b><label>Motivo da denuncia:</label></b>
			<div>
				<select required>
				<option value="Comentário ofensivo">Comentário ofensivo</option>
				<option value="Não condiz com a realidade">Não condiz com a realidade</option>
				<option value="Outro">Outro</option>
			</select>
			</div>
			<b><label>Por que está avaliação deve ser removida? 
				(Quanto mais detalhes melhor para nossa análise)</label></b>
			<div>
				<input class="textbox" type="text" name="descricao" required>
			</div>
			<div>
				<button type="submit" name="sub">Enviar</button>
			</div>
		</form>
		
	</div>
	



</body>
</html>