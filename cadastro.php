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

	$search_sqlU = mysqli_query($con,"SELECT nome_universidade, apelido_universidade FROM universidades");
	$search_sqlC = mysqli_query($con,"SELECT nome_curso FROM cursos");
	$rowU = mysqli_fetch_array($search_sqlU);
	$rowC = mysqli_fetch_array($search_sqlC);

?>

<!DOCTYPE html>
<html>
<head>
	<title>Class Rate Cadastro</title>
	<link rel="stylesheet" type="text/css" href="cadastro.css"/>
	<script src="js/jquery.min.js"></script>
	<script src="../dist/js/standalone/selectize.js"></script>
	<script src="js/index.js"></script>
</head>
<body>
	<div class="navegador">
		<nav>
			<ul>
				<li><a href="index.php"><b>Home</b></a></li>
				<li class="cadastro"><a href='cadastro.php'><b>Cadastro</b></a></li>
				<li><a href='login.php'><b>Login</b></a></li>
			</ul>
		</nav>
	</div>
	<div class="logo">
		<img id="classLogo" src="logo3.png">
	</div>
	<div class="container">		
		<form action="cadastroAction.php" method="post">
			<label><b>Nome:</b></label>
			<div>
				<input type="text" placeholder="Nome Competo" id = "nome" name="nome" required>				
			</div>
			<label><b>Email:</b></label>
			<div>
				<input type="email" placeholder="Email" id = "email "name="email_n" required>
			</div>
			<label><b>Confirmar Email:</b></label>
			<div>
				<input type="email" placeholder="Confirmar Email" id="confirmar_email" name="confirmar_email" required>		
			</div>
			<div>
				<label><b>Universidade:</b></label>
			</div>
			<div class="uni">
				<input type="hidden" id="cadastroUser" value="1" name="cadastroUser">				
				<!-- <input type="text" placeholder="Universidade" id="universidade" name="universidade" required> -->
				<select name="universidade" id="selectUni" class="selects" placeholder="Selecione Universidade" required>
			<?php
				if(mysqli_num_rows($search_sqlU)!=0){
					do  {				
						$universidadeN = $rowU['nome_universidade'];
						$universidadeA = $rowU['apelido_universidade'];
			?>
				<option <?php echo "value=\"$universidadeA\"";?> > <?php echo "$universidadeA - $universidadeN";?> </option>
			<?php } while ($rowU = mysqli_fetch_array($search_sqlU));
	
			}
			?>
				</select>
				<script>
					$('#selectUni').selectize({
						create: true,
						sortField: {
							field: 'text',
							direction: 'asc'
						},
						dropdownParent: 'body'
					});
				</script>
			</div>
			<div>
				<label><b>Curso:</b></label>
			</div>
			<div>
				<select name="curso" id="selectCur" class="selects" placeholder="Selecione Curso" required>
			<?php
				if(mysqli_num_rows($search_sqlC)!=0){
					do  {				
						$curso = $rowC['nome_curso'];
			?>
				<option <?php echo "value=\"$curso\"";?> > <?php echo "$curso";?> </option>
			<?php } while ($rowC = mysqli_fetch_array($search_sqlC));
	
			}
			?>
				</select>
				<script>
					$('#selectCur').selectize({
						create: true,
						sortField: {
							field: 'text',
							direction: 'asc'
						},
						dropdownParent: 'body'
					});
				</script>
				<!-- <input type="text" placeholder="Curso" id="curso" name="curso" required> -->
			</div>
			<label><b>Senha:</b></label>
			<div>
				<input type="password" placeholder="Senha" id="password" name="pass" required>
			</div>
			<label><b>Confirmar Senha:</b></label>
			<div>
				<input type="password" placeholder="Confirmar Senha" id="confirmar_pass" name="con_pass" required>
			</div>
			<input type="checkbox"> Ao apertar na caixa voce confirma que leu e conconrda com os <a href="#">Termos e Condicoes</a>.
			<div class="botoes">
				<button name = "sub" id = "sub" type="submit" class="signupbtn">Confirmar</button>
				<button name = "cancel" id = "cancel" type="submit" class="cancelbtn">Cancelar</button>
			</div>
		</form>
		

		
	</div>
	
	
	
</body>
	
</html>