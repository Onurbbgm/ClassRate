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
	
	// $name = $_POST['nome'];
	// $email = $_POST['email_n']; 
	// $password = $_POST['passw']; 
// $con = mysqli_connect(DB_HOST, DB_USER) or die("Failed to connect" . mysqli_error($con));

// $db = mysqli_select_db($con, DB_NAME) or die("Failed to connect" . mysqli_error($con));
// 	echo "Request";
// var_dump($_REQUEST);

// echo "POST";
// var_dump($_POST);
	


	if(isset($_POST['nome'])){
		$name = $_POST['nome'];
	}

	if($name==NULL){
		echo"<script language='javascript' type='text/javascript'>alert('Campo NOME não preenchido');window.location.href='cadastro.php';</script>";
		exit;
	}

	if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
  		echo"<script language='javascript' type='text/javascript'>alert('Nome só pode conter caracteres de letras');window.location.href='cadastro.php';</script>";
  		exit;
	}
	
	

	if(isset($_POST['email_n'])){
		$email = $_POST['email_n']; 
	}

	if($email == NULL){
		 echo"<script language='javascript' type='text/javascript'>alert('Campo E-MAIL não preenchido');window.location.href='cadastro.php';</script>";
		 exit;
	}

	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    	echo"<script language='javascript' type='text/javascript'>alert('Formato de e-mail não é valido');window.location.href='cadastro.php';</script>";
    	exit;
	}


	if(isset($_POST['confirmar_email'])){
		$con_email = $_POST['confirmar_email']; 
	}

	if($con_email == NULL){
		 echo"<script language='javascript' type='text/javascript'>alert('Campo CONFIRMAR E-MAIL não preenchido');window.location.href='cadastro.php';</script>";
		 exit;
	}

	//cadastroUser serve para caso seja necessario adicionar uma nova universidade
	//a padina addUni saiba para onde voltar, podendo ser user ou professor
	if (isset($_POST['cadastroUser'])) {
		$cadastroUser = $_POST['cadastroUser'];
	}


	if(isset($_POST['universidade'])){
		$universidade = $_POST['universidade']; 
	}

	$search_sqlU = mysqli_query($con,"SELECT cod_universidade FROM universidades WHERE nome_universidade LIKE '$universidade' or apelido_universidade LIKE '$universidade'");
	$rowU = mysqli_fetch_array($search_sqlU);
	$uniCod = $rowU['cod_universidade'];
	//Caso universidade nao esteja no sistema
	if ($uniCod==0) {
		header('Location: addUni.php?codUoP='.$cadastroUser);
		exit;
	}


	if(isset($_POST['curso'])){
		$curso = $_POST['curso']; 
	}
	if($curso==NULL){
		echo"<script language='javascript' type='text/javascript'>alert('Campo CURSO não preenchido');window.location.href='cadastro.php';</script>";
		exit;
	}

	$search_sqlC = mysqli_query($con,"SELECT cod_curso FROM cursos WHERE nome_curso LIKE '$curso'");
	$rowC = mysqli_fetch_array($search_sqlC);	
	$cursoCod = $rowC['cod_curso'];
	//Caso curso nao exista no sistema
	if ($cursoCod==0) {
		$queryC = "INSERT INTO cursos (nome_curso) VALUES ('$curso')";
		$dataC = mysqli_query($con, $queryC)or die(mysqli_error($con));
		$search_sqlC2 = mysqli_query($con,"SELECT cod_curso FROM cursos WHERE nome_curso LIKE '$curso'");
		$rowC2 = mysqli_fetch_array($search_sqlC2);
		$cursoCod = $rowC2['cod_curso'];
	}

	if(isset($_POST['pass'])){
		$password = $_POST['pass']; 
	}

	if($password==NULL){
		 echo"<script language='javascript' type='text/javascript'>alert('Campo SENHA não preenchido');window.location.href='cadastro.php';</script>";
		 exit;
	}
	
	if(isset($_POST['con_pass'])){
		$con_password = $_POST['con_pass']; 
	}

	if($con_password==NULL){
		 echo"<script language='javascript' type='text/javascript'>alert('Campo confirma senha não preenchido');window.location.href='cadastro.php';</script>";
		 exit;
	}

function NewUser($con,$db,$name,$email,$uniCod,$cursoCod,$cryppass){

	
	$query = "INSERT INTO users (nome_user,email_user,passw_user,cod_universidade,cod_curso) VALUES ('$name','$email','$cryppass','$uniCod','$cursoCod')"; 
	$data = mysqli_query($con, $query)or die(mysqli_error($con)); 
	if($data) { 
		echo "YOUR REGISTRATION IS COMPLETED...";
		header('Location: index.php');
		exit; 
	}
}

function SignUp($con,$db,$name,$email,$con_email,$uniCod,$cursoCod,$password,$con_password){
	// if (!empty($_POST['email'])) {
	// 	$query = mysqli_query("SELECT * FROM users WHERE email_user = '$_POST[email]' AND passw_user = '$_POST[password]'") or die(mysqli_error($con));
		
	// 	if(!$row = mysqli_fetch_array($query) or die(mysqli_error($con)) ){
	// 		NewUser($con,$db);
	// 	}
	// }

	$query = mysqli_query($con,"SELECT email_user FROM users WHERE email_user = '$email'");
	$result = mysqli_fetch_array($query);
	// $queryU = mysqli_query($con,"SELECT cod_universidade FROM universidades WHERE apelido_universidade = '$universidade' OR nome_universidade = '$universidade'");
	// $resultU = mysqli_fetch_array($queryU);
	// $queryC = mysqli_query($con, "SELECT cod_curso FROM cursos WHERE nome_curso = '$curso'");
	// $resultC = mysqli_fetch_array($queryC);
	//var_dump($result);
	// $cod_uni = $resultU[0];
	// $cod_curso = $resultC[0];

	if ($result[0] == $email) {
		echo"<script language='javascript' type='text/javascript'>alert('E-MAIL já registrado');window.location.href='cadastro.php';</script>";
		exit;
	}

	if($email != $con_email){
		echo"<script language='javascript' type='text/javascript'>alert('E-MAIL não correspondentes');window.location.href='cadastro.php';</script>";
		exit;
	}

	if($password != $con_password){
		echo"<script language='javascript' type='text/javascript'>alert('Senhas não correspondentes');window.location.href='cadastro.php';</script>";
		exit;
	}

	// if($cod_uni == 0){
	// 	echo "Universidade nao esta no sistema";
	// 	exit;
	// }

	// if($cod_curso == 0){
	// 	echo "Curso nao esta no sistema";
	// 	exit;
	// }


	else{
		$cryppass = password_hash($password, PASSWORD_BCRYPT);
		if(!$cryppass){
			echo"<script language='javascript' type='text/javascript'>alert('ERROR PASS CRYPT');window.location.href='cadastro.php';</script>";
			exit;
		}
		NewUser($con,$db,$name,$email,$uniCod,$cursoCod,$cryppass);
	}
	
	// else{
	// 	echo "Email already registered!";
	// }
}
	if (isset($_POST['cancel'])) {
		header('Location: index.php');
		exit;
	}

	if($_SERVER['REQUEST_METHOD'] == "POST"){
		
		SignUp($con,$db,$name,$email,$con_email,$uniCod,$cursoCod,$password,$con_password);
	}
	
		
	

	//SignUp($con, $db);
	else{
		echo "Nao funcionou";
	}




?>