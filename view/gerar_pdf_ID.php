<?php
   include_once("../banco/conexao.php");
   $conectar = getConnection();
?>

<?php
	// pega o ID da URL
	$id = isset($_GET['id']) ? (int) $_GET['id'] : null;
?>

<?php	
	//$relatorio = "SELECT * FROM aluno WHERE id = '$id' LIMIT 1";
	$relatorio = "SELECT a.id_aluno, a.nome_aluno, a.idade, a.data_nascimento, a.matricula, c.curso, a.data_registro FROM aluno a INNER JOIN curso c on a.id_curso = c.id_curso WHERE id_aluno = '$id' LIMIT 1";

	$resultado_relatorio = $conectar->prepare ($relatorio);
  	$resultado_relatorio->execute();
  	$linha = $resultado_relatorio->fetch(PDO::FETCH_ASSOC);
		
	$pagina = 
		"<html>
			<body>
				<h4>Informações do Relatorio</h4>
				ID: ".$linha['id_aluno']."<br>
				Aluno(a): ".$linha['nome_aluno']."<br>
				Idade: ".$linha['idade']."<br>
				Data de Nascimento: ".$linha['data_nascimento']."<br>
				Matrícula: ".$linha['curso']."<br>
			</body>
		</html>
		";

//referenciar o DomPDF com namespace
	use Dompdf\Dompdf;

	// include autoloader
	require("dompdf/vendor/autoload.php");

	//Criando a Instancia
	$dompdf = new DOMPDF();
	
	// Defini o tipo de Papel e sua Orientacao
	$dompdf->setPaper('A4','landscape');

	// Carrega seu HTML
	$dompdf->load_html(' <h1 style="text-align: center;"> Relatorio <br>' . $pagina .'	');


	//Renderizar o html
	$dompdf->render();

	//Exibibir a página
	$dompdf->stream(
		"relatorio.pdf", 
		array(
			"Attachment" => false //Para realizar o download somente, alterar para true.
		)
	);
?>