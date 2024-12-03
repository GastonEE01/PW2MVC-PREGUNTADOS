<?php
//require '../vendor/autoload.php';
//require  'libs/dompdf';
//require('libs/fpdf/fpdf.php');
require 'libs/dompdf/autoload.inc.php';

// Incluye el archivo de carga automática de dompdf
use Dompdf\Dompdf;
use Dompdf\Options;

class descargar_pdf
{
    public function descargarPDF()
    {


// Configuración de Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);

// Contenido HTML del PDF
        $html = '
<!DOCTYPE html>
<html>
<head>
    <title>Reporte de Usuarios por Edad</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; }
        img { max-width: 100%; height: auto; margin: 20px 0; }
    </style>
</head>
<body>
    <h1>Reporte de Usuarios por Edad</h1>
    <img src="http://localhost/PW2MVC-PREGUNTADOS/public/imagenes/grafico/chart.png" alt="Gráfico de Usuarios por Edad">
</body>
</html>
';

// Generar el PDF
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape'); // Cambiar orientación si es necesario
        $dompdf->render();

// Enviar el PDF al navegador
        $dompdf->stream('usuarios_por_edad.pdf', ['Attachment' => 0]); // 'Attachment' => 0 para visualizar
    }
}