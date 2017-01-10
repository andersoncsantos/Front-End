<?php

	//inicia a sessão usuário
    session_start();
    if(!isset($_SESSION['usuario'])) header("Location: index.php?erro=1");
	
	//instanciando a classe banco de dados
	require_once('bd.class.php');
    
    $objBd = new bd();
    $objBd->conecta_mysql();

	$id_usuario = $_SESSION['id_usuario'];

	//query - quantidade de tweets
	$sql = " SELECT COUNT(*) AS qtde_tweets FROM tweet WHERE id_usuario = $id_usuario ";

	//conexão com o banco
	$link = $objBd->conecta_mysql();

	//consulta ao banco
    $resultado_id = mysqli_query($link, $sql);

	//retorno da consulta de acordo com os parâmetros passados na variável $sql
	$qtde_tweets = mysqli_fetch_array($resultado_id);

	//query - quantidade de seguidores
	$sql = " SELECT COUNT(*) AS qtde_seguidores FROM usuarios_seguidores WHERE seguindo_id_usuario = $id_usuario ";

	//conexão com o banco
	$link = $objBd->conecta_mysql();

	//consulta ao banco
    $resultado_id = mysqli_query($link, $sql);

	//retorno da consulta de acordo com os parâmetros passados na variável $sql
	$qtde_seguidores = mysqli_fetch_array($resultado_id);
	
?>

<!DOCTYPE HTML>
<html lang="pt-br">
	<head>
		<meta charset="UTF-8">

		<title>Twitter clone</title>
		
		<!-- jquery - link cdn -->
		<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>

		<!-- bootstrap - link cdn -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

		<script type="text/javascript">

		//funções ajax
		$(document).ready(function(){
			
			$('#btn-tweet').click(function(){
				
				if($('#txt_tweet').val().length > 0){
						
						$.ajax({
							
							//submete as informações à página inclui_tweet
							url: 'inclui_tweet.php',
							method: 'post',
							data: $('#form_tweet').serialize(),

							success: function(data){
								$('#txt_tweet').val('');
								atualizaTweets();

							}
						})
					}
				})

				function atualizaTweets(){
					
					$.ajax({
					
						//submete as informações à página get_tweet
						url: 'get_tweet.php',
						method: 'post',
						
						success: function(data){
							$('#tweets').html(data);

						}
					})

				}

				atualizaTweets();


			})
		</script>
	
	</head>

	<body>

		<!-- Static navbar -->
	    <nav class="navbar navbar-default navbar-static-top">
	      <div class="container">
	        <div class="navbar-header">
	          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
	            <span class="sr-only">Toggle navigation</span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	          </button>
	          <img src="imagens/icone_twitter.png" />
	        </div>
	        
	        <div id="navbar" class="navbar-collapse collapse">
	          <ul class="nav navbar-nav navbar-right">
	            <li><a href="sair.php">Sair</a></li>
	          </ul>
	        </div><!--/.nav-collapse -->
	      </div>
	    </nav>


	    <div class="container">

	    	<div class="col-md-3">
					<div class="panel panel-default">
					<div class="panel-body">
						<h4><?= $_SESSION['usuario']?></h4>
						<hr>
						<div class="col-md-6">
							TWEETS<br>
							<?=$qtde_tweets['qtde_tweets']?>
						</div>
						<div class="col-md-6">
							SEGUIDORES<br>
							<?=$qtde_seguidores['qtde_seguidores']?>
						</div>
					</div>
				</div>
				</div>

	    	<div class="col-md-6">

					<form id="form_tweet">
						<div class="panel panel-default">
							<div class="panel-body">
								<div class="input-group">
									<input type="text" class="form-control" id="txt_tweet" name="txt_tweet" placeholder="O que está acontecendo agora?" maxlenght="140">
										<span class="input-group-btn">
											<button class="btn btn-default" id="btn-tweet" type="button">Tweet</button>
										</span>
									</div>
								</div>
							</div>
					 </form>

					<div id="tweets" class="list-group">
					</div>

				</div>
				
					<div class="col-md-3">
						<div class="panel panel-default">
							<div class="panel-body">
								<h4><a href="procurar_pessoas.php">Procurar por pessoas</a> </h4>
							</div>
						</div>
					</div>

			<div class="clearfix"></div>
			

		</div>


	    </div>
	
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	
	</body>
</html>