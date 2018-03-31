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
	<link rel="stylesheet" type="text/css" href="css/main.css"/>

    <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css'>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Catamaran" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
	
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
   <!-- 
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
    <!--
	<div class="titulo">
		<img id="classLogo" src="logo3.png">
	</div>
	<div class="search-box">
		<form autocomplete="off" action="listaProfessores.php" method="get">
			<input type="text" name="search" id ="search" placeholder="Buscar Professor"/>
		</form>
	</div>
	<div class="main">
		<p>Esse site tem o laobjetivo de ajudar estudantes a achar um bom professor, avaliando seus professores.</p>
	</div>
	<script>confirm('This is an example of using JS to create some interaction on a website. Click OK to continue!');</script> -->

      <div class='search'>

<!--
    <div class="titulo">
        <img id="classLogo" src="logo3.png">
    </div>
-->  
        <div class="main">
            <p>ClassRate</p>
        </div>
        <div class='search_bar'>
            <form autocomplete="off" action="listaProfessores.php" method="get">
              <input id='searchOne' type='checkbox'>
              <label for='searchOne'>
                <i class='icon ion-android-search'></i>
                <i class='last icon ion-android-close'></i>
                <p>|</p>
              </label>
              <input type="text" name="search" id ="search" placeholder="Buscar Professor"/>
            </form>
        </div>
        <div class="main">
            <p>Busque e Avalie professores</p>
        </div>

      </div>



    <footer>
        <a style="background-color:black;color:white;text-decoration:none;padding:4px 6px;font-family:-apple-system, BlinkMacSystemFont, &quot;San Francisco&quot;, &quot;Helvetica Neue&quot;, Helvetica, Ubuntu, Roboto, Noto, &quot;Segoe UI&quot;, Arial, sans-serif;font-size:12px;font-weight:bold;line-height:1.2;display:inline-block;border-radius:3px;" href="https://unsplash.com/@zal3wa?utm_medium=referral&amp;utm_campaign=photographer-credit&amp;utm_content=creditBadge" target="_blank" rel="noopener noreferrer" title="Download free do whatever you want high-resolution photos from Damian Zaleski"><span style="display:inline-block;padding:2px 3px;"><svg xmlns="http://www.w3.org/2000/svg" style="height:12px;width:auto;position:relative;vertical-align:middle;top:-1px;fill:white;" viewBox="0 0 32 32"><title>unsplash-logo</title><path d="M20.8 18.1c0 2.7-2.2 4.8-4.8 4.8s-4.8-2.1-4.8-4.8c0-2.7 2.2-4.8 4.8-4.8 2.7.1 4.8 2.2 4.8 4.8zm11.2-7.4v14.9c0 2.3-1.9 4.3-4.3 4.3h-23.4c-2.4 0-4.3-1.9-4.3-4.3v-15c0-2.3 1.9-4.3 4.3-4.3h3.7l.8-2.3c.4-1.1 1.7-2 2.9-2h8.6c1.2 0 2.5.9 2.9 2l.8 2.4h3.7c2.4 0 4.3 1.9 4.3 4.3zm-8.6 7.5c0-4.1-3.3-7.5-7.5-7.5-4.1 0-7.5 3.4-7.5 7.5s3.3 7.5 7.5 7.5c4.2-.1 7.5-3.4 7.5-7.5z"></path></svg></span><span style="display:inline-block;padding:2px 3px;">Damian Zaleski</span></a>
    </footer>

</body>



</html>