<?php
//////VERSAO DENTRO DE EXEMPLO SELECT
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

	if(isset($_GET['codP'])){
		$codProf = $_GET['codP'];
	}

	$codUser=0;
    if (isset($_COOKIE["codUser"])) {
        $codUser = $_COOKIE["codUser"];
    }

	$search_sql = mysqli_query($con,"SELECT professores.nome_professor FROM professores  WHERE professores.cod_professor LIKE '$codProf'");
	$search_sql2 = mysqli_query($con,"SELECT disciplinas.nome_disciplina, disciplinas.cod_disciplina FROM disciplinas INNER JOIN disciplinas_professores
		ON disciplinas.cod_disciplina = disciplinas_professores.cod_disciplina INNER JOIN professores ON disciplinas_professores.cod_professor = professores.cod_professor WHERE professores.cod_professor LIKE '$codProf'" );
	$search_sql3 = mysqli_query($con,"SELECT cursos.nome_curso, cursos.cod_curso FROM cursos INNER JOIN professores_cursos
		ON cursos.cod_curso = professores_cursos.cod_curso INNER JOIN professores ON professores_cursos.cod_professor = professores.cod_professor WHERE professores.cod_professor LIKE '$codProf'" );
	//$search_sql3 = mysqli_query($con, "SELECT nome_curso FROM cursos");
	$search_sqlTag = mysqli_query($con, "SELECT cod_tag, nome_tag FROM tags");
	$search_nameUser = mysqli_query($con, "SELECT nome_user FROM users WHERE cod_user LIKE '$codUser'");
	$row = mysqli_fetch_array($search_sql);
	$row2 = mysqli_fetch_array($search_sql2);
	$row3 = mysqli_fetch_array($search_sql3);
	$rowTag = mysqli_fetch_array($search_sqlTag);
	$rowName = mysqli_fetch_array($search_nameUser);
	$nome = $row['nome_professor'];
	$nomeUser = $rowName['nome_user'];

?>

<!DOCTYPE html>
<html>
<head>
	<!--<meta name="description" content="">
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">-->
	<title>Avaliacao Professor <?php echo "$nome";?></title>
	<link rel="stylesheet" type="text/css" href="avaliarProfessor.css"/>
	<script src="js/jquery.min.js"></script>
	<script src="../dist/js/standalone/selectize.js"></script>
	<script src="js/index.js"></script>
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
	<div class="professor">
		<h2>Avalie o professor: <?php echo "$nome";?></h2>
	</div>
	<div class="avaliacao">
		<form action="armazenaAvaliacao.php" method="post">
			<label><b>Disciplina:</b></label>
			<div class="control-group">
				<select name="disciplina" id="selectDisci" class="selects" placeholder="Selecione Disciplina" required>
			<?php
				if(mysqli_num_rows($search_sql2)!=0){
					do  {				
						$disciplina = $row2['nome_disciplina'];
						$codDisciplina = $row2['cod_disciplina'];
			?>
				<option <?php echo "value=\"$disciplina\"";?> > <?php echo "$disciplina";?> </option>
			<?php } while ($row2 = mysqli_fetch_array($search_sql2));
	
			}
			?>
			<!-- <option value="adicionarD" id="addDisc">Adicionar Disciplina</option> -->
			</select>
			<!--<div>
				<input type="text" placeholder="Disciplina" name="disciplina" required>
			</div>-->
			<script>
					$('#selectDisci').selectize({
						create: true,
						sortField: {
							field: 'text',
							direction: 'asc'
						},
						dropdownParent: 'body'
					});
				</script>
			</div>
			
			<div></div>
			<label><b>Qual o curso </b></label>
			<div></div>
			<div class="demo">
				<div class="control-group">
					<select name="curso" id="selectCurso" class="demo-default" placeholder="Selecione um curso" required>
						<?php
						if(mysqli_num_rows($search_sql3)!=0){
							do  {				
								$curso = $row3['nome_curso'];
								$codCurso = $row3['cod_curso'];
						?>
						<option <?php echo "value=\"$curso\"";?> > <?php echo "$curso";?> </option>
				<?php } while ($row3 = mysqli_fetch_array($search_sql3));
			
				}
					?>
					
						

					</select>
				</div>
				<script>
					$('#selectCurso').selectize({
						create: true,
						sortField: {
							field: 'text',
							direction: 'asc'
						},
						dropdownParent: 'body'
					});
				</script>
			</div>
			<div></div>
			<label><b>Nota Geral</b></label>
			<div></div>
			<span id="fraseEfeito">Fuja</span>
			<div>
				<input type="range" min="1" max="5" value = "1" name="notaG" id="notaG" onchange="showValue(this.value)" required/>
				<span id="range">1</span>
			</div>
			<div></div>
			<label><b>Nivel de dificuldade:</b></label>
			<div></div>
			<span id="fraseEfeitoDif">Passa Certo</span>
			<div>
				<input type="range" min="1" max="5" value="1" name="nivelD" id="nivelD" onchange="showValueDif(this.value)" required>
				<span id="rangeDif">1</span>
			</div>
			<label><b>Voce teria aula com esse professor novamente?</b></label>
			<div>
				<input type="radio" name="op1" value="1" required>Sim
				<input type="radio" name="op1" value="2">Nao
			</div>
			<label><b>Presença</b></label>
			<div>
				<input type="radio" name="pres" value="3" required>Rigido
				<input type="radio" name="pres" value="1">Flexivel
				<input type="radio" name="pres" value="2">Nem precissa ir
			</div>
			<label><b>Escolha até 5 TAGs que melhor descrevem o seu professor</b></label>
			<div class="tag-field">
				<?php
					if(mysqli_num_rows($search_sqlTag)!=0){
						do{
							$tagName = $rowTag['nome_tag'];
							$tagCod = $rowTag['cod_tag'];
							$tags = 1;

				?>
							<a href="javascript:void(0)" class="inativo" <?php echo "id=\"$tagCod\"";?> onclick="selectedTags(this.id);" ><?php echo $tagName?></a>
							
				<?php
						}while($rowTag = mysqli_fetch_array($search_sqlTag));
					}
				?>
				<input type="hidden" id="tags" name="tags" value="" required>
			</div>
			<div></div>
			<label><b>No geral o que voce achou do professor:</b></label>
			<div>
				<input type="text" name="comentario" required>
			</div>
			<label><b>Passou na disciplina: (opcional)</b></label>	
			<div>
				<input type="radio" name="pass" value="1">Sim
				<input type="radio" name="pass" value="4">Nao
				<input type="radio" name="pass" value="2">Tranquei
				<input type="radio" name="pass" value="3">Não opinar
			</div>
			<label><b>Nota recebida (opcional)</b></label>
			<div>
				<input type="text" name="notaR" placeholder="Nota">
			</div>
			<!--<label><b>Qual o seu curso (opcional)</b></label>
			<div>
				<input type="text" name="curso" placeholder="Curso">
			</div>-->			
			<div class="botoes">
				<button name = "sub" id = "sub" type="submit" class="signupbtn">Confirmar</button>
				<button name = "cancel" id = "cancel" type="submit" class="cancelbtn">Cancelar</button>
			</div>			
			<input type="hidden" name="codP" value="<?=$codProf?>">
		</form>
		<script type="text/javascript">

			function showValue(newValue){
				document.getElementById("range").innerHTML=newValue;				
				if (newValue == 1) {
					document.getElementById("fraseEfeito").innerHTML = "Fuja";
				};
				if (newValue == 2) {
					document.getElementById("fraseEfeito").innerHTML = "Voce vai se arrepender";
				};
				if (newValue == 3) {
					document.getElementById("fraseEfeito").innerHTML = "Ok";
				};
				if (newValue == 4) {
					document.getElementById("fraseEfeito").innerHTML = "Muito Bom";
				};
				if (newValue == 5) {
					document.getElementById("fraseEfeito").innerHTML = "Otimo";
				};
			}

			function showValueDif(newValue){
				document.getElementById("rangeDif").innerHTML=newValue;				
				if (newValue == 1) {
					document.getElementById("fraseEfeitoDif").innerHTML = "Passa Certo";
				};
				if (newValue == 2) {
					document.getElementById("fraseEfeitoDif").innerHTML = "Nem precissa se esforçar";
				};
				if (newValue == 3) {
					document.getElementById("fraseEfeitoDif").innerHTML = "Vai ter que estudar";
				};
				if (newValue == 4) {
					document.getElementById("fraseEfeitoDif").innerHTML = "Ta dificil";
				};
				if (newValue == 5) {
					document.getElementById("fraseEfeitoDif").innerHTML = "Quero ver passar!";
				};
			}

			var limite = 0;
			var selecionadas = [];
			function selectedTags(id){
				var classe = document.getElementById(id).className;
				console.log(classe);
				console.log(id);
				
				if(classe=="inativo" && limite<5){
					document.getElementById(id).style.color = "white";
					selecionadas.push(id); 
					document.getElementById('tags').value = selecionadas;
					document.getElementById(id).className += " ativo";
					limite++;

				}

				else if(classe=="inativo ativo"){
					document.getElementById(id).style.color = "blue";
					var index = selecionadas.indexOf(id);
					if (index > -1) {selecionadas.splice(index, 1);};
					document.getElementById('tags').value = selecionadas;
					// document.getElementById(id).value = "inativo";
					document.getElementById(id).className = document.getElementById(id).className.replace( /(?:^|\s)ativo(?!\S)/g , '' )
					limite--;

				};	

				console.log("limite"+limite);
			}
			
			// function getFrase(newValue){
			// 	if (newValue == 1) {
			// 		frase = document.createTextNode("Ta dificil");
			// 	};
			// }
		</script>
	</div>

</body>

</html>