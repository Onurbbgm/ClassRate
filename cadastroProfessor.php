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
	$codUser=0;
    if (isset($_COOKIE["codUser"])) {
        $codUser = $_COOKIE["codUser"];
    }
	$search_sqlU = mysqli_query($con,"SELECT nome_universidade, apelido_universidade FROM universidades");
	$search_sqlC = mysqli_query($con,"SELECT nome_curso FROM cursos");
	$search_nameUser = mysqli_query($con, "SELECT nome_user FROM users WHERE cod_user LIKE '$codUser'");
	$rowName = mysqli_fetch_array($search_nameUser);
	$nomeUser = $rowName['nome_user'];
	$rowU = mysqli_fetch_array($search_sqlU);
	$rowC = mysqli_fetch_array($search_sqlC);

?>

<!DOCTYPE html>
<html>
<head>
	<title>Cadastro Professor</title>
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
				<?php 
						if ($codUser==""||$codUser=="0") {
					?>
                        <li><a href='login.php'><b>Login</b></a></li>
                        <li class="menu-destaque"><a href='cadastro.php'><b>Cadastro</b></a></li>
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
	<div class="forms">
		<form action="cadastroProfessorAction.php" method="post">
			<label><b>Nome:</b></label>
			<div>
				<input type="text" name="nomeProf" placeholder="Nome Completo" color="white" required/>
			</div>
			<label><b>Universidade:</b></label>
			<div>
				<input type="hidden" id="cadastroProf" value="2" name="cadastroProf">				
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
				<!-- <input type="text" name="universidade" placeholder="Universidade" color="white" required/> -->
			</div>
			<label><b>Curso:</b></label>
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
				<!-- <input type="text" name="curso" placeholder="Curso" color="white" required/> -->
			</div>
				<!--<label><b>Site Universidade:</b></label>
			<div>
				<input type="text" name="website" placeholder="Site Universidade" color="white"/>
			</div> 
			<label><b>Disciplinas:</b></label>
			<div>
				<input type="text" name="disciplina" placeholder="Disciplinas" color="white" required/>
			</div>-->
			<div class="botoes">
				<button name = "sub" id = "sub" type="submit" class="signupbtn">Confirmar</button>
				<button name = "cancel" id = "cancel" type="submit" class="cancelbtn">Cancelar</button>
			</div>
		</form>
	</div>

</body>
</html>