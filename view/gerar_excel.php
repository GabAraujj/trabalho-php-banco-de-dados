<?php


//Incluir a conexao com BD
    include_once("../banco/conexao.php");
    $conectar = getConnection();

//Query para recuperar os registros do banco de dados
$sql = "SELECT nome_aluno, idade, data_nascimento, matricula, id_curso, data_registro, arquivo 
FROM aluno ORDER BY nome_aluno";

//Preparar a Query
$listagem = $conectar->prepare($sql);
//Executar a Query
$listagem->execute();
//Acessa o IF quando encontrar registro no banco de dados
if(($listagem) and ($listagem->rowCount() !=0)){

    //Aceitar csv ou texto
    header('Content-Type: text/csv; charset=utf-8');
    //Nome arquivo
    header('Content-Disposition: attachment; filename=Listagem.csv');
    //Gravar no buffer
    $resultado = fopen("php://output",'w');
    //Criar o cabeçalho do Excel - Usar a função mb_convert _encoding para converter carateres especiais
    $cabecalho = ['ID', 'Aluno(a)','Idade', 'Data de Nascimento', mb_convert_encoding('Matricula','ISO-8859-1','UTF-8')
    ,'ID Curso', 'Data Registro','Arquivo'];
    //Escrever o cabeçalho no arquivo
    fputcsv($resultado, $cabecalho, ';');
    //Ler os registros retornado do banco de dados
    while($linha = $listagem->fetch(PDO::FETCH_ASSOC)){
        //escrever o conteudo no arquvio
        fputcsv($resultado, $linha, ';');
    }
        //fechar arquivo
        fclose($resultado);
    }else{
        header("Location: tela_listagem.php");
    }
    ?>





















?>