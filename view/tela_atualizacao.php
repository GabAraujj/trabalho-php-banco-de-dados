<?php
    include_once '../banco/conexao.php';
    $conectar = getConnection();
?>



<?php       
    $id = isset($_GET['id']) ? (int) $_GET['id'] : null; // pega o ID da URL

    /* Selecione o "curso" da  "tabela curso" juntando com a "tabela aluno" onde a coluna "id_curso" da duas tabelas
    são iguais e o "id_aluno" é igual ao id passado pelo "GET". */

    $consulta = "SELECT c.curso from curso c INNER JOIN aluno a on c.id_curso=a.id_curso WHERE a.id_aluno = :id";
   
    $conexao_atualizar = $conectar->prepare($consulta);
    $conexao_atualizar->execute(array(':id' => $id));

    $linha = $conexao_atualizar->fetch(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html> 
    <head>
        <title> Atualização </title>  
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

    .caixalogin{
        background-color: white;
        opacity: 80%;
        width: 300px;
        height: 250px
    }
    #caixalogin{
        
        border-radius: 25px;
    }

    .form-control{
        width: 300px;
    }
    </style>
    
    </head>

<body>

<br><br><br>

<center>

<div class="caixalogin" id="caixalogin">
<br><br>

<h1> Atualizar </h1> <br>
<form action="../model/atualizacao.php" method="POST">
   <div class="col-sm-7">

    <label> Escolha um Novo Curso: </label>
            <select name="curso" class="form-control form-control-sm" required>
                <option value="">
                    <?php echo $linha['curso']; ?>
                </option>

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

            <input type="hidden" name="idAluno" value="<?php echo $_GET['id']; ?>">
            </div>

       <br>     
    <p><input type="submit" name="editar" value="ATUALIZAR"></p> <!-- Botão Atualizar -->
</form>
</div>

<br><br><br>
<a href="tela_listagem.php"> 
   <img src="../imagens/voltar.png">
</a>

</center>


</body>

</html>