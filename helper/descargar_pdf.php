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

    public function descargarPDFEstadisticaPreguntaDelJuego($data)
    {
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);

        $imagePath = __DIR__ . '/../public/imagenes/grafico/graficoEstadisticasPreguntas.png';

        $imageData = base64_encode(file_get_contents($imagePath));
        $src = 'data:image/png;base64,' . $imageData;

        $html = "
        <!DOCTYPE html>
        <html lang='es'>
        <head>
            <meta charset='UTF-8'>
            <title>Estadísticas de Preguntas del Juego</title>
            <style>
                body { 
                    font-family: 'Poppins', sans-serif; 
                    background-color: #2C3E50;
                    color: #ECF0F1;
                }
                h1 { 
                    color: #E74C3C; 
                    text-align: center; 
                    font-size: 24px;
                    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
                }
                .chart-container { 
                    text-align: center; 
                    margin: 20px 0; 
                    background-color: #34495E;
                    padding: 20px;
                    border-radius: 10px;
                }
                img { 
                    max-width: 100%; 
                    height: auto; 
                }
                table { 
                    width: 100%; 
                    border-collapse: collapse; 
                    margin-top: 20px; 
                    background-color: #34495E;
                }
                th, td { 
                    border: 1px solid #ECF0F1; 
                    padding: 8px; 
                    text-align: left; 
                }
                th { 
                    background-color: #3498DB; 
                    color: white;
                }
            </style>
        </head>
        <body>
            <h1>🎮 Estadísticas de Preguntas del Juego - Preguntados 🎮</h1>
            <div class='chart-container'>
                <img src='$src' alt='Gráfico de Estadísticas de Preguntas'>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Tipo de Respuesta</th>
                        <th>Porcentaje</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Correctas</td><td>{$data[0]}%</td></tr>
                    <tr><td>Incorrectas</td><td>{$data[1]}%</td></tr>
                </tbody>
            </table>
        </body>
        </html>";

        // Generar el PDF
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $dompdf->stream('estadisticas_preguntas_juego.pdf', ['Attachment' => 1]);
    }


    public function descargarPDFUsuarioPorEdad($data)
    {
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);

        $imagePath = __DIR__ . '/../public/imagenes/grafico/graficoUsuarioPorEdad.png';

        $imageData = base64_encode(file_get_contents($imagePath));
        $src = 'data:image/png;base64,' . $imageData;

        $html = "
        <!DOCTYPE html>
        <html lang='es'>
        <head>
            <meta charset='UTF-8'>
            <title>Distribución de Usuarios por Edad</title>
            <style>
                body { 
                    font-family: 'Poppins', sans-serif; 
                    background-color: #2C3E50;
                    color: #ECF0F1;
                }
                h1 { 
                    color: #E74C3C; 
                    text-align: center; 
                    font-size: 24px;
                    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
                }
                .chart-container { 
                    text-align: center; 
                    margin: 20px 0; 
                    background-color: #34495E;
                    padding: 20px;
                    border-radius: 10px;
                }
                img { 
                    max-width: 100%; 
                    height: auto; 
                }
                table { 
                    width: 100%; 
                    border-collapse: collapse; 
                    margin-top: 20px; 
                    background-color: #34495E;
                }
                th, td { 
                    border: 1px solid #ECF0F1; 
                    padding: 8px; 
                    text-align: left; 
                }
                th { 
                    background-color: #3498DB; 
                    color: white;
                }
            </style>
        </head>
        <body>
            <h1>🎮 Distribución de Usuarios por Edad - Preguntados 🎮</h1>
            <div class='chart-container'>
                <img src='$src' alt='Gráfico de Usuarios por Edad'>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Rango de Edad</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody>";

        $labels = ['Niños', 'Adolescentes', 'Adultos', 'Ancianos'];
        foreach ($data as $index => $value) {
            $html .= "<tr><td>{$labels[$index]}</td><td>{$value}</td></tr>";
        }

        $html .= "
                </tbody>
            </table>
        </body>
        </html>";

        // Generar el PDF
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $dompdf->stream('usuarios_por_edad.pdf', ['Attachment' => 1]);
    }


}