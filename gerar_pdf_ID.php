<?php
include_once("../banco/conexao.php");
$conectar = getConnection();
?>
<?php
    //pega o ID da URL
    $id = isset($_GET['id'])?(int) $_GET['id']: null;
?>
<?php
    //$relatorio = "SELECT*FROM aluno WHERE id = 'Sid' LIMIT 1"?
    $relatorio = "SELECT a.id_aluno, a.nome_aluno, a.idade,a.data_nascimento,a.matricula
    id_curso WHERE id_aluno = '$id' LIMIT 1;

    $resultado_relatorio = $connectar->prepare ($relatorio);
    $resultado_relatorio->execute();
    $linha = $resultado_relatorio->fetch(PDO::FETCH_ASSOC);

    $pagina = 
        "<html>
            <body>
                <h4>Informações do Relatorio</h4>
                ID: ".$Linha['id_aluno']."<br>
                Aluno(a): ".$linha['id_aluno']."<br>
                Idade: ".$linha['idade']."<br>
                Data de Nascimento: ".$linha['data_nascimento']."<br>
                Matrícula: ".$linha['curso']."<br>
            </body>
        </html>
        ";s
    
     

    referenciar o DomPDF com namespace
    use Dompdf\Dompdf;
    incluide autoloader
    require("dompdf/vendor/autoload.php");
    //Criando a Instância
    $dompdf=new DOMPDF();
    //Defini o tipo de Papel e sua Orientação
    $dompdf->setPaper('A4','landscape');
    //Carrega seu HTML
    $dompdf->load_html('<h1 style="text-align: center;"> Relatorio <br>' . $pagina .)    
    ?>
