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
    
    $search_nameUser = mysqli_query($con, "SELECT nome_user FROM users WHERE cod_user LIKE '$codUser'");
    $rowName = mysqli_fetch_array($search_nameUser);
    $nomeUser = $rowName['nome_user'];
?>

<!DOCTYPE html>
<html>
<head>
	<title>Class Rate</title>
	<!--<meta charset="utf-8"/>-->
	<!-- <script type="text/javascript" src="jsAut/jquery-1.4.2.js"></script>
    <script type='text/javascript' src="jsAut/jquery.autocomplete.js"></script> -->
    <!-- // <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script> -->
	<!-- // <script src="http://code.jquery.com/ui/1.8.22/jquery-ui.min.js" type="text/javascript"></script> -->
	<!-- <link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/smoothness/jquery-ui.css"> -->
    <!-- <link rel="stylesheet" type="text/css" href="jsAut/jquery.autocomplete.css" /> -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<link rel="stylesheet" type="text/css" href="main.css"/>
	
	<!-- <script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="//netsh.pp.ua/upwork-demo/1/js/typeahead.js"></script>
	<script src="js/jquery-ui.js"></script>
	<link rel="stylesheet" href="css/jquery-ui.min.css" />-->
	
   
	<script type="text/javascript">
		$().ready(function() {
                $("#search").autocomplete({
                	source: "search.php",
              //   	source:function ( request, response ) {
            		// 	jQuery.ajax( {
              //   		url:'search.php',
              //   		dataType:"json",
              //   		success:function ( data ) {
              //       		response( data );
              //   		}
            		// } );
                	minLength: 2,
                    // width: 460,
                    matchContains: true,
                    // //mustMatch: true,
                    // //minChars: 0,
                    // //multiple: true,
                    // //highlight: false,
                    // //multipleSeparator: ",",
                    // selectFirst: false,
                    select: function(event, ui){
                    	// alert("teste");
                    	location.href = "professor.php?codP=" + ui.item.id;
                    }
                });
            });
	</script>
   <!-- <style >
    	
        .tt-hint{
            border: 2px solid #CCCCCC;
            border-radius: 8px 8px 8px 8px;
            font-size: 24px;
            height: 45px;
            line-height: 30px;
            outline: medium none;
            padding: 8px 12px;
            width: 400px;
        }
    	.tt-dropdown-menu {
            width: 400px;
            margin-top: 5px;
            padding: 8px 12px;
            background-color: #fff;
            border: 1px solid #ccc;
            border: 1px solid rgba(0, 0, 0, 0.2);
            border-radius: 8px 8px 8px 8px;
            font-size: 18px;
            color: #111;
            background-color: #F1F1F1;
        }

    </style>
    <script>
    	$(document).ready(function(){
    		$('input.search').typeahead({
    			name: 'search',
    			remote: 'search.php?query=%QUERY'
    		});
    	})
    </script>
    <script>
    	$('#search').autocomplete({
		      	source: function( request, response ) {
		      		$.ajax({
		      			url : 'search.php',
		      			dataType: "json",
						data: {
						   name_startsWith: request.term,
						   type: 'professores'
						},
						 success: function( data ) {
							 response( $.map( data, function( item ) {
								return {
									label: item,
									value: item
								}
							}));
						}
		      		});
		      	},
		      	autoFocus: true,
		      	minLength: 0      	
		      });
    </script>-->
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
	<div class="titulo">
		<img id="classLogo" src="logo3.png">
	</div>
	<div class="search-box">
		<form autocomplete="off" action="listaProfessores.php" method="get">
			<input type="text" name="search" id ="search" placeholder="Buscar Professor"/>
		</form>
	</div>
	<div class="main">
		<p>Esse site tem o objetivo de ajudar estudantes a achar um bom professor, avaliando seus professores.</p>
	</div>
	<!--<script>confirm('This is an example of using JS to create some interaction on a website. Click OK to continue!');</script> -->

</body>



</html>