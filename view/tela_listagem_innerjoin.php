
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

  <!-- CSS only -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    

 	<style>
	body {
	  background-image: url('fundo_login.jpg');
	  background-repeat: no-repeat;
	  background-attachment: fixed;  
	  background-size: cover;	  
	}
	
  #numero{
    font-size: 30px;
  }

	</style>
    
	</head>



<body>  <br><br>

<center>

<h1> LISTAGEM </h1> 

  <?php
    date_default_timezone_set('America/Sao_Paulo');
      $today = date('d/m/y')." | ".date('H:i:s');; // Data formatada
    echo $today;
  ?>

</center>

<br><br><br>

<center>
<h2>Inner Join</h2> <br>

<?php
    
        //SQL para selecionar os registros
       $sql = "SELECT a.id_aluno, a.nome_aluno, a.idade, a.data_nascimento, a.matricula, c.curso, a.data_registro FROM aluno a INNER JOIN curso c on a.id_curso = c.id_curso ORDER BY id_aluno ASC";

       $consulta = $conectar->prepare($sql);

       $consulta->execute();
       if (!$consulta) {
         die("Erro no Banco!");
       }
       
      
       echo '<table class="table table-striped">';
       echo "<thead>";
       echo "<tr>";
       echo "<th width='10%'><center> ID </center></th>";
       echo "<th width='10%'><center> Aluno </center></th>";
       echo "<th width='10%'><center> Idade </center></th>"; 
       echo "<th width='10%'><center> Data de Nascimento </center></th>"; 
       echo "<th width='10%'><center> Matrícula </center></th>"; 
       echo "<th width='10%'><center> Curso </center></th>";  
       echo "<th width='10%'><center> Data de Registro </center></th>";             
       echo "</tr>";
       echo "</thead>";
       echo "<tbody>";

       while ($exibir = $consulta->fetch(PDO::FETCH_ASSOC)) {
          echo "<tr>";
          echo "<th><center>" . $exibir['id_aluno'] . "</center></th>";
          echo "<td><center>" . $exibir['nome_aluno'] . "</center></td>";
          echo "<td><center>" . $exibir['idade'] . "</center></td>";
          echo "<td><center>" . $exibir['data_nascimento'] . "</center></td>";
          echo "<td><center>" . $exibir['matricula'] . "</center></td>";
          //echo "<td><center>" . utf8_encode($exibir['curso']) . "</center></td>";
          echo "<td><center>" . $exibir['curso'] . "</center></td>";
          echo "<td><center>" . $exibir['data_registro'] . "</center></td>";
        ?>


    <?php
          echo "</tr>";
        }
        
        echo "</tbody>";        
        echo "</table>";

        ?>

</center>

<br><br>

<table align="center">
  <td>
    <h2> Número de Alunos: </h2> 
  </td>
  <td id="numero">  
    <?php 
      print count($contagem); 
    ?>
  </td>    
</table>  


<!--               2ª PARTE                 
<div class="contagem">
    <h2>Nº de Alunos: </h2>   
    <?php  
      print  count($contagem); 
    ?>
</div>
 -->

<br><br>

<center>
<!--               3ª PARTE                  -->

<!-- Lista o nome do curso e sua quantidade de Alunos -->
<h2>Group By</h2> <br>

<?php

$sql_group = "SELECT c.id_curso, c.curso, c.horas, count(a.id_curso) as contagem FROM aluno a INNER JOIN curso c on a.id_curso = c.id_curso GROUP BY c.id_curso";

  $resultado = $conectar->prepare($sql_group);
  $resultado->execute();

echo '<table class="table table-striped">';
       echo "<thead>";
       echo "<tr>";
       echo "<th width='10%'><center> Curso </center></th>";
       echo "<th width='10%'><center> ID </center></th>";
       echo "<th width='10%'><center> Horas </center></th>"; 
       echo "<th width='10%'><center> Quantidade de Alunos </center></th>"; 
       echo "</tr>";
       echo "</thead>";
       echo "<tbody>";

  while ($exibir = $resultado->fetch(PDO::FETCH_ASSOC)) {
   // var_dump($exibir);
    extract($exibir);
    echo "<tr>";
    //echo "<td><center>".utf8_encode($exibir['curso'])."</center></td>";
    echo "<td><center>".$exibir['curso']."</center></td>";
    echo "<td><center>".$exibir['id_curso']."</center></td>";
    echo "<td><center>".$exibir['horas']."</center></td>";
    echo "<td><center>".$contagem."</center></td>";
    echo "</tr>";
        
    }
        
        echo "</tbody>";        
        echo "</table>";

/*
  $query_usuarios = "SELECT c.id_curso AS id_curso, c.curso, c.horas,
                            COUNT(a.id_curso) AS qnt_alunos
                            FROM curso AS c
                            LEFT JOIN aluno AS a ON c.id_curso=a.id_curso
                            GROUP BY c.id_curso";
        $result_usuarios = $conectar->prepare($query_usuarios);
        $result_usuarios->execute();

        while($row_usuario = $result_usuarios->fetch(PDO::FETCH_ASSOC)){
            //var_dump($row_usuario);
            extract($row_usuario);
            echo "ID: $id_curso <br>";
            echo "Curso: ". utf8_encode($curso). "<br>";
            echo "E-mail: $horas <br>";
            //echo "ID da compra: $id_car <br>";
            echo "Quantidade de Alunos: $qnt_alunos <br>";
            echo "<hr>";
        }
*/
?>

<br><br>




<h2>Group By 2</h2> <br>

<?php


$sql_group = "SELECT idade, count(id_aluno) as quant_idade FROM aluno GROUP BY idade";

  $resultado = $conectar->prepare($sql_group);
  $resultado->execute();

echo '<table class="table table-striped">';
       echo "<thead>";
       echo "<tr>";
       echo "<th width='10%'><center> Idade </center></th>";
       echo "<th width='10%'><center> Quantidade </center></th>"; 
       echo "</tr>";
       echo "</thead>";
       echo "<tbody>";

  while ($exibir = $resultado->fetch(PDO::FETCH_ASSOC)) {
   // var_dump($exibir);
    extract($exibir);
    echo "<tr>";
    //echo "<td><center>".utf8_encode($exibir['curso'])."</center></td>";
    echo "<td><center>".$exibir['idade']."</center></td>";
    echo "<td><center>".$quant_idade."</center></td>";
    echo "</tr>";
        
    }
        
        echo "</tbody>";        
        echo "</table>";

/*
  $query_usuarios = "SELECT c.id_curso AS id_curso, c.curso, c.horas,
                            COUNT(a.id_curso) AS qnt_alunos
                            FROM curso AS c
                            LEFT JOIN aluno AS a ON c.id_curso=a.id_curso
                            GROUP BY c.id_curso";
        $result_usuarios = $conectar->prepare($query_usuarios);
        $result_usuarios->execute();

        while($row_usuario = $result_usuarios->fetch(PDO::FETCH_ASSOC)){
            //var_dump($row_usuario);
            extract($row_usuario);
            echo "ID: $id_curso <br>";
            echo "Curso: ". utf8_encode($curso). "<br>";
            echo "E-mail: $horas <br>";
            //echo "ID da compra: $id_car <br>";
            echo "Quantidade de Alunos: $qnt_alunos <br>";
            echo "<hr>";
        }
*/
?>

<br><br>



<!--               4ª PARTE                  -->
<h2>LIMIT</h2> <br>

<?php


$sql_limit = "SELECT a.id_aluno, a.nome_aluno, a.idade, a.data_nascimento, a.matricula, c.curso, a.data_registro FROM aluno a INNER JOIN curso c on a.id_curso = c.id_curso LIMIT 5 OFFSET 3";

  $resultado = $conectar->prepare($sql_limit);
  $resultado->execute();

echo '<table class="table table-striped">';
       echo "<thead>";
       echo "<tr>";
       echo "<th width='10%'><center> ID </center></th>";
       echo "<th width='10%'><center> Aluno </center></th>";
       echo "<th width='10%'><center> Idade </center></th>"; 
       echo "<th width='10%'><center> Data de Nascimento </center></th>"; 
       echo "<th width='10%'><center> Matrícula </center></th>"; 
       echo "<th width='10%'><center> Curso </center></th>";  
       echo "<th width='10%'><center> Data de Registro </center></th>";
       echo "</tr>";
       echo "</thead>";
       echo "<tbody>";

  while ($exibir = $resultado->fetch(PDO::FETCH_ASSOC)) {
   // var_dump($exibir);
    extract($exibir);
    echo "<tr>";
          echo "<th><center>" . $exibir['id_aluno'] . "</center></th>";
          echo "<td><center>" . $exibir['nome_aluno'] . "</center></td>";
          echo "<td><center>" . $exibir['idade'] . "</center></td>";
          echo "<td><center>" . $exibir['data_nascimento'] . "</center></td>";
          echo "<td><center>" . $exibir['matricula'] . "</center></td>";
          echo "<td><center>" . $exibir['curso'] . "</center></td>";
          //echo "<td><center>" . utf8_encode($exibir['curso']) . "</center></td>";
          echo "<td><center>" . $exibir['data_registro'] . "</center></td>";
    echo "</tr>";
        
    }
        
        echo "</tbody>";        
        echo "</table>";

?>

</center>





<br><br><br><br>

</body>

</html>
