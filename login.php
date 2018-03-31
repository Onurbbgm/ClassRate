<!DOCTYPE html>
<html>
<head>
	<title>Class Rate Login</title>
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
				<div class="right">
					<li><a href="index.php"><b>Home</b></a></li>
					<li><a href='login.php'><b>Login</b></a></li>
                    <li class="menu-destaque"><a href='cadastro.php'><b>Cadastro</b></a></li>
				</div>
			</ul>
		</nav>
	</div>
	
	<div class="forms">
		<form class="login_form" action="loginAction.php" method="post">
			<div>
				<input type="email" name="login" placeholder="E-mail" color="white" required/>
			</div>
			<div>
				<input type="password" name="password" placeholder="Senha" color="white" required/>
			</div>
			<div class="botoes">
				<button type="submit" name="sub" id="sub" class="signupbtn">Login</button>
			</div>
		</form>
	</div>
	
</body>

</html>