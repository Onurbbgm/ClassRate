<?php
	
	setcookie("login", "", time() - 3600);
	setcookie("password", "", time() - 3600);
	setcookie("codUser", "", time() - 3600);
	header('Location: index.php');


?>