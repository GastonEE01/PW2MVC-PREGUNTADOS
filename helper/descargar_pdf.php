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

    public function descargarPDFUsuarioPorEdad($niños,$adolescentes,$adultos,$ancianos)
    {
        // Configuración de Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);

        // Obtener los datos del modelo
        $model = new AdminModel(); // Asegúrese de que esta clase exista y esté correctamente importada
        $data = $model->clasificarUsuariosPorEdad();

        // Contenido HTML del PDF
        $html = '
        <!DOCTYPE html>
        <html>
        <head>
            <title>Reporte de Usuarios por Edad</title>
            <style>
                body { font-family: Arial, sans-serif; text-align: center; }
                img { max-width: 100%; height: auto; margin: 20px 0; }
                table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                th { background-color: #f2f2f2; }
            </style>
        </head>
        <body>
            <h1>Reporte de Usuarios por Edad</h1>
            <img src="' . __DIR__ . '/../public/imagenes/grafico/graficoUsuarioPorEdad.png" alt="Gráfico de Usuarios por Edad">
            <table>
                <thead>
                    <tr>
                        <th>Rango de Edad</th>
                        <th>Porcentaje de Usuarios</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Niños</td><td>' . $niños . '%</td></tr>
                    <tr><td>Adolescentes</td><td>' . $adolescentes . '%</td></tr>
                    <tr><td>Adultos</td><td>' . $adultos . '%</td></tr>
                    <tr><td>Ancianos</td><td>' . $ancianos . '%</td></tr>
                </tbody>
            </table>
        </body>
        </html>';

        // Generar el PDF
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Enviar el PDF al navegador
        $dompdf->stream('usuarios_por_edad.pdf', ['Attachment' => 0]);
    }
}