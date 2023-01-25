
<?php
    include_once '../banco/conexao.php';
    $conectar = getConnection();
?>

<?php
    //pega o id da url
    $id = isset($_GET['id']) ? $_GET['id'] : null;
    
    // valida o id
    if (empty($id)){
        echo "ID não informado";
        exit;
    }
    
    $sql = "SELECT arquivo FROM aluno WHERE id_aluno=:id_aluno";
    $busca_arquivo = $conectar->prepare($sql);
    $busca_arquivo ->bindParam(':id_aluno', $id);
    $busca_arquivo ->execute();

    $num_linhas=$busca_arquivo->rowCount();


    if ($num_linhas != 0) {
        //remove do banco
        $sql = "DELETE FROM aluno WHERE id_aluno = :id_aluno";
        $consulta = $conectar->prepare($sql);
        $consulta->bindParam(':id_aluno', $id, PDO::PARAM_INT);

        if ($consulta->execute()){
            $dados_aluno = $busca_arquivo->fetch(PDO::FETCH_ASSOC);

            if(!empty($dados_aluno['arquivo'])){
                $pdf=$dados_aluno['arquivo'];
                $arquivo="../uploads/".$pdf;
                
                if (file_exists($arquivo)){
                    unlink($arquivo);
                    }
            }
    
    header('Location:../view/tela_listagem.php');
   
} else {
    echo "Erro ao remover";
    print-r($consulta->errorInfo());
}
}  else {
    echo "Erro ao remover";
    print_r(errorInfo());
}

?>