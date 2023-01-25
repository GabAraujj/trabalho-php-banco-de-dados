
<?php
	  include_once '../banco/conexao.php';
  	$conectar = getConnection();
?>

<?php
  $contarAluno = $conectar->prepare("SELECT * FROM aluno");
  $contarAluno->execute();

  $contagem = $contarAluno->fetchAll(); // Pega todos os registros de uma vez.
?>


<!DOCTYPE html>
<html> 
 	<head>
 		<title> LISTAGEM </title>  
 	    <meta charset="utf-8"> 
    <!--  <meta http-equiv="refresh" content="3">  Atualiza a página à cada nº segundos -->

  <!-- CSS only -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    

 	<style>
	body {
	  background-image: url('../imagens/3.png');
	  background-repeat: no-repeat;
	  background-attachment: fixed;  
	  background-size: cover;	  
	}
	
  #numero{
    font-size: 30px;
  }

  #btn-acao{
    width: 40px;
  }

  #btn-certidao{
    width: 50px;
  }


  table{
    width: 50px;
  }

  #tabela{
    width: 800px;
  }

  .input-group{
    width: 450px;
  }
  #btn-menu{
    color:white;
		background-color:black;
		font-family:arial;
		height:30px;
		margin-left:-5px;
		padding:5px;
		position: relative;
		top:-5px;
	}
	#btn-menu:hover{
		color:black;
		background-color:white;
		border:0px;
	}

	</style>
    
	</head>



<body>  <br><br>
<div style="background-color:black; padding-left:30px; padding-bottom:-10px; height:30px; position:relative; top:-50px">
		<a href="tela_cadastro.php">
		<button id="btn-menu">Cadastrar Aluno </button></a>
		<a href="tela_listagem.php">
		<button id="btn-menu">Listagem 1 </button></a>
		<a href="tela_listagem2.php">
		<button id="btn-menu"> Listagem2 </button></a>
	</div>

<center>

<h1> LISTAGEM </h1> 

  <?php
    // A variável recebe o nome do aluno, que foi inserido no campo de pesquisa.
    $nomeAluno = isset($_GET['nomeAluno']) ? $_GET['nomeAluno'] : null;
    /* $nomeAluno = filter_input_array(INPUT_GET, FILTER_DEFAULT);
    */

    date_default_timezone_set('America/Sao_Paulo');
      $today = date('d/m/y')." | ".date('H:i:s');; // Data formatada
    echo $today;
  ?>

</center>

<br>
<!-- CAMPO DE PESQUISA -->
<form action="tela_listagem2.php" method="GET"> <!-- GET, pega o valor através da url. -->
        <center><p> 
        <div class="input-group"> 

          <input type="text" name="nomeAluno" placeholder="Nome do Aluno" class="form-control" id="campoPesquisa">
          <input type="submit" value="Pesquisar" class="btn btn-primary">

        </div>
        </p>
      </form>

<br><br>

<center>
<!-- <h2>Inner Join</h2> <br> -->

<?php
    
      //$pesquisa =  $nomeAluno['nomeAluno'] . "%";
      $pesquisa =  $nomeAluno . "%";

        //SQL para selecionar os registros
       $sql = "SELECT a.id_aluno, a.nome_aluno, a.idade, a.data_nascimento, a.matricula, c.curso, a.data_registro, a.arquivo FROM aluno a INNER JOIN curso c on a.id_curso = c.id_curso WHERE nome_aluno LIKE :aluno ORDER BY id_aluno ASC";

       /*
        $sql = "SELECT a.id_aluno, a.nome_aluno, a.idade, a.data_nascimento, a.matricula, c.curso, a.data_registro FROM aluno a INNER JOIN curso c on a.id_curso = c.id_curso ORDER BY id_aluno ASC WHERE nome_aluno LIKE :aluno";
       */

       $consulta = $conectar->prepare($sql);

       $consulta->bindParam(':aluno',$pesquisa, PDO::PARAM_STR);

       $consulta->execute();
       if (!$consulta) {
         die("Erro no Banco!");
       }
       

       foreach ($consulta as $aluno){

        ?>
        <div style="float: center; width:1400px;">
            <div style='width: 250px; height: 240px; float:left; ,margin-left:12px; margin-bottom:10px;'>
            <!--Gera relatorio do aluno-->
            <a href="gerar_pdf.php?id=<?php echo $aluno["id_aluno"]?>" name="relatorio">
                <img src="../imagens/ID.png" id="fotoId">
       </a>
       <br>
            <?php echo $aluno["nome_aluno"]?>
        </br>
        <b><?php echo $aluno["curso"]; ?> </b>
       
     
                 
       

       <?php
          $ext = pathinfo($aluno['arquivo'],PATHINFO_EXTENSION); // Pega a extensão do meu arquivo
          if ($ext == 'pdf') {
            echo "<td><center> <a href='../uploads/" . $exibir["arquivo"] . "'> <
            img src='../imagens/pdf.png' id='btn-certidao'> </a> </center></td>";
          } else if (($ext == 'jpg')||($ext == 'jpeg')||($ext == 'png')) {
            echo "<td><center><img src='../uploads/" . $exibir['arquivo'] . "'
            style='width: 80px; '></center></td>";
          } else if (($ext != 'pdf') && ($ext != 'jpg') && ($ext != 'jpeg') && ($ext != 'png')) {
            echo "<td><center> <i>Arquivo não enviado</i></center></td>";
          }
        ?>

        
          <center>
            <a href="tela_atualizacao.php?id=<?php echo $aluno["id_aluno"]?>">
            <img src="../imagens/atualização.png"  id="btn-acao">                 
            </a>

            <a href="../model/deletar.php?id=<?php echo $aluno["id_aluno"]?>">
            <img src="../imagens/excluir.png" id="btn-acao">
        </a>

        <br>

            </div>
        </div>
        <?php
            }
       ?>

          </center>
     

    <?php
     
     
        
    ?>

      <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
      <?php //visao maior

  $sql="SELECT aluno, matricula, curso FROM maior ORDER BY aluno ASC";
  $tabela=$conectar->prepare($sql);
  $tabela->execute();

  if(!$tabela){
    die("Erro no Banco!");
  }

  echo "<h2> Alunos com mais de 40 anos </h2>";
  foreach ($tabela as $visao) {
    echo "<br>".$visao['aluno']." - <i>".$visao['matricula']."</i>-".$visao['curso'];
  }
?>
        <!-- Botão Relatório -->  
        <a class="Relatorio" href="gerar_pdf.php" name="relatorio">
            <img src="../imagens/relatorio.png">
        </a>


        <!-- Botão Imprimir -->
        <a type="button" onclick="window.print()" name="btn_imprimir">
            <img src="../imagens/imprimir.png">
        </a>

        

    

        <?php
          //$nome = isset($_GET['nomeAluno']) ? (string) $_GET['nomeAluno'] : null;
          //echo "$nome";
        ?>

      <a class="Relatorio" href="gerar_pdf_BUSCA.php?nomeAluno=<?php echo $nomeAluno; ?>" name="busca_alunos">
        <img src="../imagens/pessoas.png">
      </a>

</center>



</body>

</html>

