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

	<script src="js/jquery.min.js"></script>
	<script src="../dist/js/standalone/selectize.js"></script>
	<script src="js/index.js"></script>
	<link rel="stylesheet" type="text/css" href="css/main.css"/>

    <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css'>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Catamaran" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
</head>
<body>
	<div class="navegador">
		<nav>
			<ul>
				<li><a href="index.php"><b>Home</b></a></li>
				<li><a href='login.php'><b>Login</b></a></li>
                <li class="menu-destaque"><a href='cadastro.php'><b>Cadastro</b></a></li>
			</ul>
		</nav>
	</div>
	<div class="forms">		
		<form class="login_form" action="cadastroAction.php" method="post">
			<div>
				<input type="text" placeholder="Nome Completo" id="nome" name="nome" required>				
			</div>
			<div>
				<input type="email" placeholder="E-mail" id = "email "name="email_n" required>
			</div>
			<div>
				<input type="email" placeholder="Confirmar E-mail" id="confirmar_email" name="confirmar_email" required>	
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
			<div class="cur">
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
			<div>
				<input type="password" placeholder="Senha" id="password" name="pass" required>
			</div>
			<div>
				<input type="password" placeholder="Confirmar Senha" id="confirmar_pass" name="con_pass" required>
			</div>
			<input class="termos-texto" type="checkbox">Ao apertar na caixa você confirma que leu e conconrda com os <a class="termos" href="#">Termos e Condições</a>.
			<div class="botoes">
				<button name = "sub" id = "sub" type="submit" class="signupbtn">Confirmar</button>
			</div>
		</form>
		

		
	</div>
	
	
	
</body>
	
</html>