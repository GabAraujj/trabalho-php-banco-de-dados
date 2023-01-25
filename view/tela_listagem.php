
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
<div style="background-color:black; padding-left:30px; padding-bottom:-10px; height:30px; position: relative; top:-50px;">
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
<form action="tela_listagem.php" method="GET"> <!-- GET, pega o valor através da url. -->
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
       
       /*
       echo' 
                 <a href="gerar_pdf_BUSCA.php?nome=<?php echo $nomeAluno["nome_aluno"]?>" >
                     <img src="../imagens/ID.png">
                 </a>'
          ; */

       echo '<div id="tabela">';  
       echo '<table class="table table-striped">';
       echo "<thead>";
       echo "<tr>";
       echo "<th width='1%'><center> ID </center></th>";
       echo "<th width='1%'><center> Aluno </center></th>";
       echo "<th width='1%'><center> Idade </center></th>"; 
       //echo "<th width='1%'><center> Data de Nascimento </center></th>"; 
       echo "<th width='1%'><center> Matrícula </center></th>"; 
       echo "<th width='3%'><center> Curso </center></th>"; 
       echo "<th width='1%'> Certidão </th>"; 
       //echo "<th width='1%'><center> Data de Registro </center></th>";
       echo "<th width='5%'><center> Ação </center></th>";             
       echo "</tr>";
       echo "</thead>";
       echo "<tbody>";

       while ($exibir = $consulta->fetch(PDO::FETCH_ASSOC)) {
          echo "<tr>";
          echo "<th><center>" . $exibir['id_aluno'] . "</center></th>";
          echo "<td><center>" . $exibir['nome_aluno'] . "</center></td>";
          echo "<td><center>" . $exibir['idade'] . "</center></td>";
          //echo "<td><center>" . $exibir['data_nascimento'] . "</center></td>";
          echo "<td><center>" . $exibir['matricula'] . "</center></td>";
          //echo "<td><center>" . utf8_encode($exibir['curso']) . "</center></td>";
          echo "<td><center>" . $exibir['curso'] . "</center></td>";
          //echo "<td><center>" . $exibir['data_registro'] . "</center></td>";

          $ext = pathinfo($exibir['arquivo'],PATHINFO_EXTENSION); // Pega a extensão do meu arquivo
          if ($ext == 'pdf') {
            echo "<td><center> <a href='../uploads/" . $exibir["arquivo"] . "'> <img src='../imagens/pdf.png' id='btn-certidao'> </a> </center></td>";
          }
        ?>

        <td>
          <center>
            <a href="tela_atualizacao.php?id=<?php echo $exibir["id_aluno"]?>">
            <img src="../imagens/atualização.png"  id="btn-acao">                 
            </a>

            <a href="../model/deletar.php?id=<?php echo $exibir["id_aluno"]?>">
            <img src="../imagens/excluir.png" id="btn-acao">
            </a>


            <!-- Gera Relatório do Aluno -->  
        <a href="gerar_pdf_ID.php?id=<?php echo $exibir["id_aluno"]?>" name="relatorio">
              <img src="../imagens/ID.png">
        </a>

          </center>
        </td>

    <?php
          echo "</tr>";
        }
        
        echo "</tbody>";        
        echo "</table>";
        echo "</div>";
        
    ?>
  <div style="margin-left:-190px; width:1100px;">
  <!--Formulario para enviar arquivo .csv-->
  <form method="POST" action="../model/upload_excel.php" enctype="multipart/form-data">
    <div class="mb-3" style="margin-left:250px; width:-100px;">
    <label class="form-label" style="float: left;">Upload Excel</label>
    <input class="form-control form-control-sm" name="arquivo" id="formFileSm" type="file"
    style="width:350px; float:left; margin-left:15px;">

    <input type="image" name="up_excel" src="../imagens/upload_excel.png">
      </div>
      </form>
  <div style ="width:230px; margin-left:700px; margin-top:-10px;">
        <!-- Botão Relatório -->  
        <a class="Relatorio" href="gerar_pdf.php" name="relatorio">
            <img src="../imagens/relatorio.png">
        </a>


        <!-- Botão Imprimir -->
        <a type="button" onclick="window.print()" name="btn_imprimir">
            <img src="../imagens/imprimir.png">
        </a>
        <a class="relatorio" href="gerar_pdf_BUSCA.php?nomeAluno=<?php echo $nomeAluno;
          ?>" name="busca_alunos">
          <img src="../imagens/pessoas.png">
      </a>
      <a href="gerar_excel.php" name="btn_excel">
        <img src="../imagens/excel.png">
      </a>
  </div>
  </div>


       

</center>



</body>

</html>
