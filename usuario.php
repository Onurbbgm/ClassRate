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

	$search_sql = mysqli_query($con, "SELECT * FROM avaliacoes WHERE avaliacoes.cod_user LIKE '$codUser' ");
	$search_name = mysqli_query($con, "SELECT nome_user FROM users WHERE cod_user LIKE '$codUser'");
	$row = mysqli_fetch_array($search_sql);
	$rowName = mysqli_fetch_array($search_name);
	$nome = $rowName['nome_user'];


?>


<!DOCTYPE html>
<html>
<head>
	<title><?php echo "$nome";?></title>
	<link rel="stylesheet" type="text/css" href="usuario.css"/>
</head>
<script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
<script>
function deletarAva(id){
	$.ajax({
	url: "deletarAvaliacao.php",
	data:'id='+id,
	type: "POST",
	success: function(data){
		window.location.reload();
	}
	});
}

</script>
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
		<h2>Suas avaliaçōes:</h2>
		<table style="width:100%">
			<tr>
				<th>Professor</th>
				<th>Curso</th>
				<th>Disciplina</th>
				<th>Nota Geral</th>
				<th>Nivel Dificuldade</th>
				<th>Repetiria o professor</th>
				<th>Presença</th>
				<th>Comentario</th>
				<th>Passou na disciplina</th>
				<th>Nota recebida na disciplina</th>
			</tr>
			
			<?php
				do{
					$codCurso = $row['cod_curso'];
					$codDis = $row['cod_disciplina'];
					$search = mysqli_query($con, "SELECT nome_curso FROM cursos WHERE cod_curso LIKE '$codCurso' ");
					$search2 = mysqli_query($con, "SELECT nome_disciplina FROM disciplinas WHERE cod_disciplina LIKE '$codDis' ");
					$result = mysqli_fetch_array($search);
					$result2 = mysqli_fetch_array($search2);
					$nomeCurso = $result['nome_curso'];
					$nomeDisc = $result2['nome_disciplina'];
					$notaGer = $row['notaGeral'];
					$niveDif = $row['nivelDificuldade'];
					$repetProf = $row['repetirProf'];
					$pres = $row['presenca'];
					$com = $row['comentario'];
					$pass = $row['passou'];
					$notaR = $row['notaRecebida'];
					$codAvaliacao = $row['cod_avaliacao'];
					$codProf = $row['cod_professor'];
					$searchProf = mysqli_query($con, "SELECT nome_professor FROM professores WHERE cod_professor = '$codProf'");
					$resultProf = mysqli_fetch_array($searchProf);
					$nomeProf = $resultProf['nome_professor'];

					if($repetProf == 1){
						$repetProf = "Sim";
					}					
					else if($repetProf == 2){
						$repetProf = "Nao";
					}
					if($pres == 3){
						$pres = "Rigido";
					}
					else if($pres == 1){
						$pres = "Flexivel";
					}
					else if($pres == 2){
						$pres = "Nem precisa ir";
					}
					if($pass == 5){
						$pass = "Nao foi informado";
					}
					else if($pass == 1){
						$pass = "Sim";
					}
					else if($pass == 2){
						$pass = "Tranquei";
					}			
					else if($pass == 4){
						$pass = "Nao";
					}
					if($notaR == 42){
						$notaR = "Nao foi informado";
					}
					?>
					<tr>
						<td><?php echo "$nomeProf";?></td>
						<td><?php echo "$nomeCurso";?></td>
						<td><?php echo "$nomeDisc";?></td>
						<td><?php echo "$notaGer";?></td>
						<td><?php echo "$niveDif";?></td>
						<td><?php echo "$repetProf";?></td>
						<td><?php echo "$pres";?></td>
						<td><?php echo "$com";?></td>
						<td><?php echo "$pass";?></td>
						<td><?php echo "$notaR";?></td>
						<tr>
							<td><input type="button" value="Deletar" onClick="deletarAva(<?php echo $codAvaliacao; ?>)"></td>

						</tr>
					<?php
				} while ($row = mysqli_fetch_array($search_sql));
			?>
					</tr>
				

			
		</table>
	</div>
	


</body>
</html>