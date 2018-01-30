<!DOCTYPE html>
<html>
<head>
	<title>Class Rate Login</title>
	<link rel="stylesheet" type="text/css" href="login.css"/>
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
					<li><a href='cadastro.php'><b>Cadastro</b></a></li>
					<li><a href='login.php'><b>Login</b></a></li>
				</div>
			</ul>
		</nav>
	</div>
	
	<div class ="forms">
		<form class="login_form" action="loginAction.php" method="post">
			<label><b>E-MAIL</b></label>
			<div>
				<input type="text" name="login" placeholder="e-mail" color="white" required/>
			</div>
			<label><b>Senha</b></label>
			<div>
				<input type="password" name="password" placeholder="********" color="white" required/>
			</div>
			<div class="botoes">
				<button type="submit" name="sub" id="sub" class="signupbtn">Login</button>
			</div>
		</form>
	</div>
	
</body>

</html>