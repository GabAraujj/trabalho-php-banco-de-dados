<?php

   include_once("../banco/conexao.php");
   $conectar = getConnection();

// Carregar o Composer
require 'dompdf/vendor/autoload.php';

$sql = $conectar->query('SELECT a.id_aluno, a.nome_aluno, a.idade, a.data_nascimento, a.matricula, c.curso, a.data_registro FROM aluno a INNER JOIN curso c on a.id_curso = c.id_curso ORDER BY id_aluno ASC');

$html ='<h1> Relatorio de Alunos</h1>';
$html .= '<table border=1 width=80%>';
$html .= '<thead>';
$html .= '<tr>';
$html .= '<td width="5%"><center> ID </center></td>';
$html .= '<td width="18%"><center> Aluno </center></td>';
$html .= '<td width="5%"><center> Idade </center></td>';
$html .= '<td width="5%"><center> Matrícula </center></td>';
$html .= '<td width="12%"><center> Curso </center></td>';
$html .= '</tr>';
$html .= '</thead>';

while ($linha = $sql->fetch(PDO::FETCH_ASSOC)) {
	$html .='<tbody>';
	$html .= '<tr><td> <center>'.$linha['id_aluno'] .'  </center></td>';
	$html .= '<td>  <center>'.$linha['nome_aluno'] .'  </center></td>';
	$html .= '<td>  <center>'.$linha['idade'] .'  </center></td>';
	$html .= '<td>  <center>'.$linha['matricula'] .'  </center></td>';
	$html .= '<td>  <center>'.$linha['curso'] .'  </center></td></tr>';
	$html .='</tbody>';	
}
$html .='</table>';

// Referenciar o namespace Dompdf
use Dompdf\Dompdf;

// Instanciar e usar a classe dompdf
$dompdf = new Dompdf();

// Instanciar o metodo loadHtml e enviar o conteudo do PDF
	$dompdf->loadHtml($html);

// Configurar o tamanho e a orientacao do papel
// landscape - Imprimir no formato paisagem
//$dompdf->setPaper('A4', 'landscape');
// portrait - Imprimir no formato retrato
$dompdf->setPaper('A4', 'portrait');

// Renderizar o HTML como PDF
$dompdf->render();

// Gerar o PDF
$dompdf->stream("Listagem de Alunos.pdf", 
		array(
			"Attachment" => false //Para realizar o download somente alterar para true
		)
		);

?>