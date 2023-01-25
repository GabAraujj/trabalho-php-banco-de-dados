

<?php
	include_once '../banco/conexao.php';
  	$conectar = getConnection();
?>



<!DOCTYPE html>
<html>
<head>
	<title> Cadastro </title>
	<meta charset="utf-8"> 

  <!-- CSS only -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

<style>
	body{
	background-image: url('../imagens/3.png');
      background-repeat: no-repeat;
      background-attachment: fixed;  
      background-size: cover;  
	}
	.container{
		margin-Left:21%;
		background-color: rgba(255, 255, 255, 0.322);
		border-radius:10px;
		font-family:arial;
        width: 500px;
        height: 550px;
		padding:10px;
	}
	.form-control{
		width: 300px;
	}
	input{
		width: 100px;
	}
	.botoes{
		margin-left: -20%;
	}
	#formFilemultiple{
		margin-left: 75px;
	}
	.form-control{
		width: 300px;
	}

	.container{
		margin-left: 21%;
	}
	input{
		width: 100px;
	}
	.botoes{
		margin-left: -20%;
	}
	#btn-menu{
		color:white;
		background-color:rgb(211, 144, 19);
		font-family:arial;
		height:30px;
		margin-left:-5px;
		padding-top:0px;
		position: relative;
		top:-1px;

	}
	#btn-menu:hover{
		color:black;
		background-color:yellow;
		border:0px;
	}

</style>

</head>


<br><br><br>

<body>
<div style="background-color:orange; padding-left:30px; padding-bottom:-30px; height:30px; position:relative; top:-72px;">
		<a href="tela_cadastro.php">
		<button id="btn-menu">Cadastrar Aluno </button></a>
		<a href="tela_listagem.php">
		<button id="btn-menu">Listagem 1 </button></a>
		<a href="tela_listagem2.php">
		<button id="btn-menu"> Listagem2 </button></a>
	</div>
<center>

<h1> Cadastro de Alunos </h1> <br>


<form action="../model/cadastro.php" method="POST" enctype="multipart/form-data">

	<div class="container mt-2 ml-2">
    <div class="form-group row">
	 <div class="col-sm-7">
		<div class="form-group row">
			<label for="description" class="col-sm-5 col-form-label">Nome: </label>

			<div class="col-sm-7">
			<input type="text" name="nome" class="form-control form-control-sm"> <br>
			</div>
		</div>

		<!--<div class="form-group row">
			<label for="description" class="col-sm-5 col-form-label">Idade: </label>

			<div class="col-sm-7">
			<input type="number" name="idade" min="18" max="60" placeholder="Apartir de 18 anos" class="form-control form-control-sm"> <br>
			</div>
		</div>-->

		<div class="form-group row">
			<label for="description" class="col-sm-5 col-form-label">Data de Nascimento: </label>

			<div class="col-sm-7">
			<input type="date" name="dataNascimento" class="form-control form-control-sm" required> <br>
			</div>
		</div>

		<div class="form-group row">
			<label for="description" class="col-sm-5 col-form-label">Matrícula: </label>

			<div class="col-sm-7">
			<input type="text" name="matricula" class="form-control form-control-sm" required> <br>
			</div>
		</div>

			<div class="form-group row">
			<label for="description" class="col-sm-5 col-form-label">Curso: </label>

			<div class="col-sm-7">
			<select name="curso" class="form-control form-control-sm" required>
		        <option value="">Selecione um Curso</option>

		        <?php
			        $sql = $conectar->query("SELECT * FROM curso ORDER BY curso ASC");
			        $listagem = $sql->fetchAll(PDO::FETCH_ASSOC);

			        foreach($listagem as $exibir) {
		        ?>

		        <option value="<?php echo $exibir['id_curso']?>">
		        	<?php 
		        		echo $exibir['curso'];
		        		//echo utf8_encode($exibir['curso']);
		        	?>
		        </option>

		        <?php
		        	} // Fecha o FOREACH.
		        ?>

		    </select>

			</div>
		</div>
	<div class="form-group now">
		<label for="description" class="col-sm-5 col-form-label">Certidão de Nascimento: </label>
		<input class="form-control" type="file" id="formFileMultiple" name="arquivo">
	</div>
	</div>
	<hr> 
	<div class="botoes">   
		<input type="submit" name="cadastrar" value="Cadastrar" class="btn btn-dark"> <!-- Botão CADASTRAR -->   
		<input type="reset" name="limpar" value="Limpar" class="btn btn-dark"> <!-- Botão LIMPAR -->   
		  <!--botao voltar-->
		  <a href="../tela_listagem"
	</div>
</div>




</form>


</center>




</body>






</html>