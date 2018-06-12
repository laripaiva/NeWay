<?php
require_once("dompdf/dompdf_config.inc.php");
// referenciando o namespace do dompdf


// instanciando o dompdf

$dompdf = new Dompdf();

//lendo o arquivo HTML correspondente

$html = 'boleto_itau.php';

//inserindo o HTML que queremos converter

$dompdf->load_html($html);

// Definindo o papel e a orientação

//$dompdf->setPaper('A4', 'landscape');

// Renderizando o HTML como PDF

$dompdf->render();

// Enviando o PDF para o browser

$dompdf->stream('boleto.pdf');
?>
