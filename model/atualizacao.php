<?php	
    include_once '../banco/conexao.php';
  	$conectar = getConnection();
?>

<?php

	if(isset($_POST['editar'])){
        $id_aluno = $_POST['idAluno'];     
        $id_curso = $_POST['curso'];
    
        // Verificando os campos se estao preenchidos
        if( empty($id_aluno) || empty($id_curso) ) {
                echo "<font color='red'>Campo Obrigatorio.</font><br/>";
        } else {
                    //atualizado dados na tabela
            $sql = "UPDATE aluno SET id_curso = :id_curso WHERE id_aluno = :id";
    
            $consulta = $conectar->prepare($sql);
    
            $consulta->bindparam(':id', $id_aluno);
            $consulta->bindparam(':id_curso', $id_curso);
        }
    
        if ($consulta->execute()) {     
            header("Location: ../view/tela_listagem.php");
        } 
    }

                  


?>