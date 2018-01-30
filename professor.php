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
	if(isset($_GET['codP'])){
		$codProf = $_GET['codP'];
	}
	$codUser=0;
    if (isset($_COOKIE["codUser"])) {
        $codUser = $_COOKIE["codUser"];
    }

    function getUserIP(){
	
	    $client  = @$_SERVER['HTTP_CLIENT_IP'];
	    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
	    $remote  = $_SERVER['REMOTE_ADDR'];

	    if(filter_var($client, FILTER_VALIDATE_IP))
	    {
	        $ip = $client;
	    }
	    elseif(filter_var($forward, FILTER_VALIDATE_IP))
	    {
	        $ip = $forward;
	    }
	    else
	    {
	        $ip = $remote;
	    }

	    return $ip;
	}



	//Completar pesquisa
	$search_sql = mysqli_query($con,"SELECT professores.nome_professor, professores.media_avaliacao, universidades.apelido_universidade, universidades.nome_universidade FROM professores INNER JOIN universidades ON professores.cod_universidade = universidades.cod_universidade  WHERE professores.cod_professor LIKE '$codProf'");
	$search_sql2 = mysqli_query($con,"SELECT cursos.nome_curso FROM cursos INNER JOIN professores_cursos
		ON cursos.cod_curso = professores_cursos.cod_curso INNER JOIN professores ON professores_cursos.cod_professor = professores.cod_professor WHERE professores.cod_professor LIKE '$codProf'" );
	$search_sql3 = mysqli_query($con,"SELECT disciplinas.nome_disciplina FROM disciplinas INNER JOIN disciplinas_professores
		ON disciplinas.cod_disciplina = disciplinas_professores.cod_disciplina INNER JOIN professores ON disciplinas_professores.cod_professor = professores.cod_professor WHERE professores.cod_professor LIKE '$codProf'" );
	$search_sql4 = mysqli_query($con, "SELECT avaliacoes.cod_avaliacao, avaliacoes.notaGeral, avaliacoes.nivelDificuldade, avaliacoes.repetirProf, avaliacoes.presenca, avaliacoes.comentario, avaliacoes.passou, avaliacoes.notaRecebida, avaliacoes.like_num, avaliacoes.dislike_num, avaliacoes.cod_curso, avaliacoes.cod_disciplina FROM avaliacoes WHERE avaliacoes.cod_professor LIKE '$codProf' ");
	$search_sql5 = mysqli_query($con, "SELECT avaliacoes.notaGeral, avaliacoes.nivelDificuldade, avaliacoes.repetirProf, avaliacoes.presenca, avaliacoes.comentario, avaliacoes.passou, avaliacoes.notaRecebida, avaliacoes.cod_curso, avaliacoes.cod_disciplina FROM avaliacoes WHERE avaliacoes.cod_professor LIKE '$codProf' ");
	$search_sql6 = mysqli_query($con, "SELECT avaliacoes.notaGeral, avaliacoes.nivelDificuldade, avaliacoes.repetirProf, avaliacoes.presenca, avaliacoes.comentario, avaliacoes.passou, avaliacoes.notaRecebida, avaliacoes.cod_curso, avaliacoes.cod_disciplina FROM avaliacoes WHERE avaliacoes.cod_professor LIKE '$codProf' ");
	$search_sql7 = mysqli_query($con, "SELECT avaliacoes.notaGeral, avaliacoes.nivelDificuldade, avaliacoes.repetirProf, avaliacoes.presenca, avaliacoes.comentario, avaliacoes.passou, avaliacoes.notaRecebida, avaliacoes.cod_curso, avaliacoes.cod_disciplina FROM avaliacoes WHERE avaliacoes.cod_professor LIKE '$codProf' ");
	$search_tags = mysqli_query($con, "SELECT tags.nome_tag FROM tags INNER JOIN tags_professores_avaliacoes ON tags.cod_tag = tags_professores_avaliacoes.cod_tag WHERE tags_professores_avaliacoes.cod_professor LIKE '$codProf'");
	// $search_codAva = mysqli_query($con, "SELECT cod_avaliacao FROM avaliacoes WHERE avaliacoes.cod_professor LIKE '$codProf' ");
	//$search_likeNum = mysqli_query($con, "SELECT avaliacoes.like_num FROM avaliacoes WHERE avaliacoes.cod_professor LIKE '$codProf' ");
	//$search_dislikeNum = mysqli_query($con, "SELECT avaliacoes.dislike_num FROM avaliacoes WHERE avaliacoes.cod_professor LIKE '$codProf' ");
	$row = mysqli_fetch_array($search_sql);
	$row2 = mysqli_fetch_array($search_sql2);
	$row3 = mysqli_fetch_array($search_sql3);
	$row4 = mysqli_fetch_array($search_sql4);
	$row5 = mysqli_fetch_array($search_sql5);
	$row6 = mysqli_fetch_array($search_sql6);
	$row7 = mysqli_fetch_array($search_sql7);
	$rowTag = mysqli_fetch_array($search_tags);
//	$rowLike = mysqli_fetch_array($search_likeNum);
//	$rowDislike = mysqli_fetch_array($search_dislikeNum);
	// $rowCodAva = mysqli_fetch_array($search_codAva);
	$search_nameUser = mysqli_query($con, "SELECT nome_user FROM users WHERE cod_user LIKE '$codUser'");
    $rowName = mysqli_fetch_array($search_nameUser);
    $nomeUser = $rowName['nome_user'];
	$nome = $row['nome_professor'];
	$universidadeAp = $row['apelido_universidade'];
	$universidadeNo = $row['nome_universidade'];
	$mediaA = $row['media_avaliacao'];

	//$ipAddress = $_SERVER['REMOTE_ADDR'];
	$ipAddress = getUserIP();
	//$curso = $row2['nome_curso'];

?>

<!DOCTYPE html>
<html>
<head>
	<title><?php echo "$nome";?></title>
	<link rel="stylesheet" type="text/css" href="professor.css"/>
</head>
<style>
/*.demo-table {width: 100%;border-spacing: initial;margin: 20px 0px;word-break: break-word;table-layout: auto;line-height:1.8em;color:#333;}*/
/*.demo-table th {background: #81CBFD;padding: 5px;text-align: left;color:#FFF;}
.demo-table td {border-bottom: #f0f0f0 1px solid;background-color: #ffffff;padding: 5px;}
.demo-table td div.feed_title{text-decoration: none;color:#40CD22;font-weight:bold;}
.demo-table ul{margin:0;padding:0;}
.demo-table li{cursor:pointer;list-style-type: none;display: inline-block;color: #F0F0F0;text-shadow: 0 0 1px #666666;font-size:20px;}
.demo-table .highlight, .demo-table .selected {color:#F4B30A;text-shadow: 0 0 1px #F48F0A;}
.btn-likes {float:left; padding: 0px 5px;cursor:pointer;}
.btn-likes input[type="button"]{width:20px;height:20px;border:0;cursor:pointer;}
.like {background:url('like.png')}
.unlike {background:url('unlike.png')}
.label-likes {font-size:12px;color:#2F529B;height:20px;}
.desc {clear:both;color:#999;}*/
</style>
<script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
<script>
function addLikes(id,action) {
	// $('.demo-table #tutorial-'+id+' li').each(function(index) {
	// 	$(this).addClass('selected');
	// 	$('#tutorial-'+id+' #rating').val((index+1));
	// 	if(index == $('.demo-table #tutorial-'+id+' li').index(obj)) {
	// 		return false;	
	// 	}
	// });
	$.ajax({
	url: "add_likes.php",
	data:'id='+id+'&action='+action,
	type: "POST",
	// beforeSend: function(){
	// 	$('#tutorial-'+id+' .btn-likes').html("<img src='LoaderIcon.gif' />");
	// },
	success: function(data){
	var likes = parseInt($('#likes-'+id).val());
	switch(action) {
		case "like":
		$('#tutorial-'+id+' .btn-likes').html('<input type="button" title="Unlike" class="unlike" onClick="addLikes('+id+',\'unlike\')" />');
		likes = likes+1;
		window.location.reload();
		break;
		case "unlike":
		$('#tutorial-'+id+' .btn-likes').html('<input type="button" title="Like" class="like"  onClick="addLikes('+id+',\'like\')" />');
		likes = likes-1;
		window.location.reload();
		break;
	}
	$('#likes-'+id).val(likes);
	if(likes>0) {
		$('#tutorial-'+id+' .label-likes').html(likes+" Like(s)");
	} else {
		$('#tutorial-'+id+' .label-likes').html('');
	}
	}
	});
}
function addDislikes(id,action) {
	// $('.demo-table #tutorial-'+id+' li').each(function(index) {
	// 	$(this).addClass('selected');
	// 	$('#tutorial-'+id+' #rating').val((index+1));
	// 	if(index == $('.demo-table #tutorial-'+id+' li').index(obj)) {
	// 		return false;	
	// 	}
	// });
	$.ajax({
	url: "add_likes.php",
	data:'id='+id+'&action='+action,
	type: "POST",
	// beforeSend: function(){
	// 	$('#tutorial-'+id+' .btn-likes').html("<img src='LoaderIcon.gif' />");
	// },
	success: function(data){
	var likes = parseInt($('#likes-'+id).val());
	switch(action) {
		case "dislike":
		$('#tutorial-'+id+' .btn-likes').html('<input type="button" title="Undislike" class="unlike" onClick="addLikes('+id+',\'undislike\')" />');
		likes = likes+1;
		window.location.reload();
		break;
		case "undislike":
		$('#tutorial-'+id+' .btn-likes').html('<input type="button" title="Dislike" class="like"  onClick="addLikes('+id+',\'dislike\')" />');
		likes = likes-1;
		window.location.reload();
		break;
	}
	$('#likes-'+id).val(likes);
	if(likes>0) {
		$('#tutorial-'+id+' .label-likes').html(likes+" Like(s)");
	} else {
		$('#tutorial-'+id+' .label-likes').html('');
	}
	}
	});
}
</script>
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
	<div>
		<h1><?php echo "$nome";?></h1>
		<h3><?php echo "$universidadeAp";?></h3>
		<h4><?php echo "$universidadeNo";?></h4>
		<!--<h4>Cursos Professor</h4>
		<h4>Disciplinas Professor</h4>-->
	</div>
	<div>
		<select>
			<option value="todos">Mostrar Todos</option>
			<?php
				if(mysqli_num_rows($search_sql2)!=0){
					do  {				
						$curso = $row2['nome_curso'];
				?>
				<option value= <?php echo "$curso";?> > <?php echo "$curso";?> </option>
		<?php } while ($row2 = mysqli_fetch_array($search_sql2));
	
		}
			?>
			
			<!--<option value="adicionarC">Adicionar Curso</option>-->
		</select>
		<select>
			<option value="todos">Mostrar Todos</option>
			<?php
				if(mysqli_num_rows($search_sql3)!=0){
					do  {				
						$disciplina = $row3['nome_disciplina'];
				?>
				<option value= <?php echo "$disciplina";?> > <?php echo "$disciplina";?> </option>
		<?php } while ($row3 = mysqli_fetch_array($search_sql3));
	
		}
			?>
			<!--<option value="adicionarD">Adicionar Disciplina</option>-->
		</select>
		<div></div>
		<button name = "avaliar" class = "aval" type="submit" >Avaliar Professor</button>
	</div>
	<div>
		<h3>Nota media: <?php 
			$mediaAva = 0;
			$count = 0;
			do{

				$notaG = $row5['notaGeral'];
				$count = $count + 1;
				$mediaAva = $mediaAva + $notaG;

			}while($row5 = mysqli_fetch_array($search_sql5));
			$mediaAva = $mediaAva/$count;

			if($mediaAva != 0){
				echo round($mediaAva,1);		
			}else{
				echo "Ainda não possui avaliaçōes";
			}

		?></h3>
		<h3>Nivel de dificuldade: <?php 
			$mediaDif = 0;
			$count2 = 0;
			do{

				$notaD = $row6['nivelDificuldade'];
				$count2 = $count2 + 1;
				$mediaDif = $mediaDif + $notaD;

			}while($row6 = mysqli_fetch_array($search_sql6));
			$mediaDif = $mediaDif/$count2;

			if($mediaDif != 0){
				echo round($mediaDif,1);		
			}else{
				echo "Ainda não possui avaliaçōes";
			}

		?>
		</h3>
		<h3>Repetiria o professor: <?php 
			$countTotal = 0;
			$countSim = 0;
			do{

				$repetP = $row7['repetirProf'];
				if($repetP == 1){
					$countSim = $countSim + 1;
				}
				$countTotal = $countTotal + 1;
				//$mediaSim = $mediaDif + $notaD;

			}while($row7 = mysqli_fetch_array($search_sql7));
			//$mediaDif = $mediaDif/$count2;
			$porcentagemSim = ($countSim*100)/$countTotal;
			if($countSim != 0){
				echo round($porcentagemSim,1)."%";		
			}else{
				echo "Ainda não possui avaliaçōes";
			}

		?></h3>
		<h3>Top Tags:</h3>
		<div>
			<?php
				// $tagArrays[] = $rowTag['nome_tag'];
				// $tagUnique = array_unique($tagArrays);
				do {
				 	$tagArrays[] = $rowTag['nome_tag'];
				 } while ($rowTag = mysqli_fetch_array($search_tags));
				$j=0;
				$numTag = count($tagArrays);
				
				 do{
					$count = 0;
					// $numTag = count($tagArrays);
					
					// $tagArrays = array();
					// $numTagUni = count($tagUnique);
					$tagUnique[] = array_unique($tagArrays);
					$numTagUnique = count($tagUnique);
					$tag = $tagArrays[$j];
					
					for ($i=0; $i < $numTag ; $i++) { 
						if ($tag == $tagArrays[$i]) {
							$count = $count + 1;
						}
					}		
					?>
						<p><?php echo "$tag ($count)"?></p>
					<?php			
					
					$j++;
					// for ($i=0; $i < $numTagUni ; $i++) { 
					// 	
					// }
					
					// foreach ($tagArrays as $rowTag['nome_tag']) { 
					// 	if($tag == $rowTag['nome_tag']){
					// 		$count = $count + 1;
					// 								
					// 	}
					// }
					// if ($tag = "") {
					// 	
					//<!-- 	<h3>Ainda não possui avaliaçōes</h3>-->
					// 	<?php
					// }
					// else{
						
					// }


				 }while($j<$numTag);


			?>

		</div>
	</div>
	<div>
		<table style="width:100%">
			<tr>
				<th>Curso</th>
				<th>Disciplina</th>
				<th>Nota Geral</th>
				<th>Nivel Dificuldade</th>
				<th>Repetiria o professor</th>
				<th>Presença</th>
				<th>Tags Utilizadas</th>
				<th>Comentario</th>
				<th>Passou na disciplina</th>
				<th>Nota recebida na disciplina</th>
			</tr>
			
			<?php
				do{
					$codCurso = $row4['cod_curso'];
					$codDis = $row4['cod_disciplina'];
					$search = mysqli_query($con, "SELECT nome_curso FROM cursos WHERE cod_curso LIKE '$codCurso' ");
					$search2 = mysqli_query($con, "SELECT nome_disciplina FROM disciplinas WHERE cod_disciplina LIKE '$codDis' ");
					$result = mysqli_fetch_array($search);
					$result2 = mysqli_fetch_array($search2);
					$nomeCurso = $result['nome_curso'];
					$nomeDisc = $result2['nome_disciplina'];
					$notaGer = $row4['notaGeral'];
					$niveDif = $row4['nivelDificuldade'];
					$repetProf = $row4['repetirProf'];
					$pres = $row4['presenca'];
					$com = $row4['comentario'];
					$pass = $row4['passou'];
					$notaR = $row4['notaRecebida'];
					$likeNum = $row4['like_num'];
					$dislikeNum = $row4['dislike_num'];
					$codAvaliacao = $row4['cod_avaliacao'];
					$search_tagUsu = mysqli_query($con, "SELECT tags.nome_tag FROM tags INNER JOIN tags_professores_avaliacoes ON tags.cod_tag = tags_professores_avaliacoes.cod_tag WHERE tags_professores_avaliacoes.cod_avaliacao LIKE '$codAvaliacao'");
					$rowTagUser = mysqli_fetch_array($search_tagUsu);
					

					if($repetProf == 1){
						$repetProf = "Sim";
					}					
					else if($repetProf == 2){
						$repetProf = "Nao";
					}
					if($pres == 3){
						$pres = "Rigido";
					}
					else if($pres == 1){
						$pres = "Flexivel";
					}
					else if($pres == 2){
						$pres = "Nem precisa ir";
					}
					if($pass == 5){
						$pass = "Nao foi informado";
					}
					else if($pass == 1){
						$pass = "Sim";
					}
					else if($pass == 2){
						$pass = "Tranquei";
					}			
					else if($pass == 4){
						$pass = "Nao";
					}
					if($notaR == 42){
						$notaR = "Nao foi informado";
					}
					?>
					<tr>
						<td><?php echo "$nomeCurso";?></td>
						<td><?php echo "$nomeDisc";?></td>
						<td><?php echo "$notaGer";?></td>
						<td><?php echo "$niveDif";?></td>
						<td><?php echo "$repetProf";?></td>
						<td><?php echo "$pres";?></td>
						<td><?php 
							do{
								$tagsUtilAvaliador = $rowTagUser['nome_tag'];
								echo "$tagsUtilAvaliador ";
							}while($rowTagUser = mysqli_fetch_array($search_tagUsu));
						?></td>
						<td><?php echo "$com";?></td>
						<td><?php echo "$pass";?></td>
						<td><?php echo "$notaR";?></td>
						<tr class="reportTable">
							<?php
								$query ="SELECT * FROM ipaddress_likes_map WHERE cod_avaliacao LIKE '$codAvaliacao' and ip_address LIKE '$ipAddress' and like_dislike LIKE '1'";
								$resultIp = mysqli_query($con, $query);
								$count = mysqli_num_rows($resultIp);
								$str_like = "like";
								if (!empty($count)) {
									$str_like = "unlike";
								}
							?>
							<td><?php echo "$likeNum";?> <input type="button" value="Like" onClick="addLikes(<?php echo $codAvaliacao; ?>,'<?php echo $str_like; ?>')"></td>
							<?php
								$query ="SELECT * FROM ipaddress_likes_map WHERE cod_avaliacao LIKE '$codAvaliacao' and ip_address LIKE '$ipAddress' and like_dislike LIKE '2'";
								$resultIp = mysqli_query($con, $query);
								$count = mysqli_num_rows($resultIp);
								$str_dislike = "dislike";
								if (!empty($count)) {
									$str_dislike = "undislike";
								}
							?>
							<td><?php echo "$dislikeNum";?> <input type="button" value="Dislike" onClick="addDislikes(<?php echo $codAvaliacao; ?>,'<?php echo $str_dislike; ?>')"></td>
							<td><a href="denunciar.php?codAv=<?php echo $codAvaliacao;?>">Denunciar</a></td>
						</tr>
					<?php
				} while ($row4 = mysqli_fetch_array($search_sql4));
			?>
					</tr>
				

			
		</table>
		<form action = "avaliarProfessor.php" method="get">
			<input type="hidden" name="codP" value="<?=$codProf?>">
			<button name = "avaliar" class = "aval" type="submit" >Avaliar Professor</button>
		</form>
	</div>

</body>

</html>