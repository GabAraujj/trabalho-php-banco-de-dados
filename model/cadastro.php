
<?php
  include '../banco/conexao.php';
  $conectar = getConnection();
?>

<?php
function data($data){
    return date("d/m/Y",strtotime($data));
    // Y = Ano inteiro (ex: 2020)
    // y = Ano pelo metade (ex: 20) 
}

    //$sql = 'INSERT INTO produto (descricao,qtd,valor) VALUES (:desc,:qtd,:valor)';
    $sql = 'INSERT INTO aluno (nome_aluno,idade,data_nascimento,matricula,id_curso, data_registro) 
            VALUES (:nome_aluno,:idade,:data_nascimento,:matricula,:id_curso, :data_registro)';

    date_default_timezone_set('America/Sao_Paulo');
    setlocale(LC_TIME, "pt_BR");
            
    $agora = getdate();

    $a = $agora["year"];
    $m = $agora["mon"];//utf8_encode(strftime("%B"));
    $d = $agora["mday"];
 
    

    $nome = $_POST["nome"];
    $idade = $_POST["idade"];
    $data_nascimento = data($_POST["dataNascimento"]);
    $matricula = $_POST["matricula"];
    $id_curso = $_POST["curso"];
    $data_registro = $d . "/" . $m . "/" . $a;

    
 
    $inserir = $conectar->prepare($sql);
    $inserir->bindParam(':nome_aluno', $nome);
    $inserir->bindParam(':idade', $idade);
    $inserir->bindParam(':data_nascimento', $data_nascimento);
    $inserir->bindParam(':matricula', $matricula);
    $inserir->bindParam(':id_curso', $id_curso);
    $inserir->bindParam(':data_registro', $data_registro);
   

    if($inserir->execute()){
        //echo 'Salvo com sucesso!';        
        header("location: ../view/tela_cadastro.php");
    }else{
        echo ' Erro ao salvar!';
    }

?>
