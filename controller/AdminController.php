<?php

class AdminController
{
    private $model;
    private $presenter;
    private $generarPDF;

    private $textoNav = "";

    public function __construct($model, $presenter,$generarPDF)
    {
        $this->model = $model;
        $this->presenter = $presenter;
        $this->generarPDF = $generarPDF;

    }

   public function vistaAdmin()
    {
        $sesion = new ManejoSesiones();
        $user = $sesion->obtenerUsuario();
        $sesion->iniciarSesion($user);
        $id_usuario = $sesion->obtenerUsuarioID();
        $fotoIMG = $user['Path_img_perfil'] ?? 'Invitado';
        if (empty($user)) {
            header("Location: /PW2MVC-PREGUNTADOS/Usuario/login");
            exit();
        }
        $dataPreguntaPorCategoria  = $this->model->cantidadDePreguntaPorCategoria();
        $dataCantidadPreguntaCorrectaCategoria = $this->model->cantidadDePreguntaCorrectaPorCategoria();
        $dataCantidadPreguntaIncorrectaCategoria = $this->model->cantidadDePreguntaIncorrectaPorCategoria();
        $dataEdad = $this->model->clasificarUsuariosPorEdad();
        $dataCantidadPreguntasPorDificultad = $this->model->cantidadDePreguntasPorDificultadYCategoria();

       /* $categorias = [];
        foreach ($dataPregunta as $pregunta) {
            $categorias[] = [
                'NombreCategoria' => $pregunta['NombreCategoria'],
                'TotalPreguntas' => $pregunta['TotalPreguntas']
            ];
        }*/

        $this->presenter->render('view/admin.mustache', [
            'nombre_usuario' => $user['nombre_usuario'],
            'id' => $id_usuario,
            'Path_img_perfil' => $fotoIMG,
            'ninio' => $dataEdad[0],
            'adolescente' => $dataEdad[1],
            'adulto' => $dataEdad[2],
            'ancianos' => $dataEdad[3],
            'arte' => $dataPreguntaPorCategoria[0], // Arte
            'cine' => $dataPreguntaPorCategoria[1], // Cine
            'historia' => $dataPreguntaPorCategoria[2], // Historia
            'deporte' => $dataPreguntaPorCategoria[3], // Deporte
            'ciencia' => $dataPreguntaPorCategoria[4], // Ciencia
            'geografia' => $dataPreguntaPorCategoria[5],
            'preguntaCorrectaArte' => $dataPreguntaPorCategoria[5],
            // Pasar la cantidad de preguntas correctas e incorrectas por categoría
            'arteCorrectas' => $dataCantidadPreguntaCorrectaCategoria['Arte'],
            'arteIncorrectas' => $dataCantidadPreguntaIncorrectaCategoria['Arte'],
            'cineCorrectas' => $dataCantidadPreguntaCorrectaCategoria['Cine'],
            'cineIncorrectas' => $dataCantidadPreguntaIncorrectaCategoria['Cine'],
            'historiaCorrectas' => $dataCantidadPreguntaCorrectaCategoria['Historia'],
            'historiaIncorrectas' => $dataCantidadPreguntaIncorrectaCategoria['Historia'],
            'deporteCorrectas' => $dataCantidadPreguntaCorrectaCategoria['Deporte'],
            'deporteIncorrectas' => $dataCantidadPreguntaIncorrectaCategoria['Deporte'],
            'cienciaCorrectas' => $dataCantidadPreguntaCorrectaCategoria['Ciencia'],
            'cienciaIncorrectas' => $dataCantidadPreguntaIncorrectaCategoria['Ciencia'],
            'geografiaCorrectas' => $dataCantidadPreguntaCorrectaCategoria['Geografía'],
            'geografiaIncorrectas' => $dataCantidadPreguntaIncorrectaCategoria['Geografía'],
            // Filtro de cantidad de preguntado por dificultad de cada categoria
            'cantidadFacilArte' => $dataCantidadPreguntasPorDificultad['Arte'][1],
            'cantidadNormalArte' => $dataCantidadPreguntasPorDificultad['Arte'][2],
            'cantidadDificilArte' => $dataCantidadPreguntasPorDificultad['Arte'][3],
            'cantidadFacilCine' => $dataCantidadPreguntasPorDificultad['Cine'][1],
            'cantidadNormalCine' => $dataCantidadPreguntasPorDificultad['Cine'][2],
            'cantidadDificilCine' => $dataCantidadPreguntasPorDificultad['Cine'][3],
            'cantidadFacilHistoria' => $dataCantidadPreguntasPorDificultad['Historia'][1],
            'cantidadNormalHistoria' => $dataCantidadPreguntasPorDificultad['Historia'][2],
            'cantidadDificilHistoria' => $dataCantidadPreguntasPorDificultad['Historia'][3],
            'cantidadFacilDeporte' => $dataCantidadPreguntasPorDificultad['Deporte'][1],
            'cantidadNormalDeporte' => $dataCantidadPreguntasPorDificultad['Deporte'][2],
            'cantidadDificilDeporte' => $dataCantidadPreguntasPorDificultad['Deporte'][3],
            'cantidadFacilCiencia' => $dataCantidadPreguntasPorDificultad['Ciencia'][1],
            'cantidadNormalCiencia' => $dataCantidadPreguntasPorDificultad['Ciencia'][2],
            'cantidadDificilCiencia' => $dataCantidadPreguntasPorDificultad['Ciencia'][3],
            'cantidadFacilGeografia' => $dataCantidadPreguntasPorDificultad['Geografía'][1],
            'cantidadNormalGeografia' => $dataCantidadPreguntasPorDificultad['Geografía'][2],
            'cantidadDificilGeografia' => $dataCantidadPreguntasPorDificultad['Geografía'][3],
        ]);

    }

    public function obtenerUsuarioPorEdad() {
        // Obtener los datos reales de la base de datos
        $data = $this->model->clasificarUsuariosPorEdad();

        // Generar el gráfico
        $this->generarGraficoUsuarioPorEdad($data);

        // Generar y descargar el PDF
        $this->generarPDF->descargarPDFUsuarioPorEdad($data);
    }


    private function generarGraficoUsuarioPorEdad($data) {
        $width = 500;
        $height = 300;

        // Crear una imagen en blanco
        $image = imagecreate($width, $height);

        // Colores
        $white = imagecolorallocate($image, 255, 255, 255);
        $colors = [
            imagecolorallocate($image, 255, 99, 132),
            imagecolorallocate($image, 54, 162, 235),
            imagecolorallocate($image, 255, 206, 86),
            imagecolorallocate($image, 75, 192, 192)
        ];

        // Fondo blanco
        imagefill($image, 0, 0, $white);

        // Dibujar el gráfico circular
        $total = array_sum($data);
        $startAngle = 0;
        $centerX = $width / 2;
        $centerY = $height / 2;
        $radius = min($width, $height) / 3;

        foreach ($data as $index => $value) {
            $endAngle = $startAngle + ($value / $total) * 360;
            imagefilledarc($image, $centerX, $centerY, $radius * 2, $radius * 2, $startAngle, $endAngle, $colors[$index], IMG_ARC_PIE);
            $startAngle = $endAngle;
        }

        // Guardar la imagen como archivo
        $filePath = __DIR__ . '/../public/imagenes/grafico/graficoUsuarioPorEdad.png';
        imagepng($image, $filePath);
        imagedestroy($image);
    }


    public function obtenerEstadisticaPregunta() {
        $data = $this->model->traerPreguntasCorrectas();

        // Generar el gráfico
        $this->generarGraficoEstadisticaPregunta($data);

        // Generar y descargar el PDF
        $this->generarPDF->descargarPDFEstadisticaPreguntaDelJuego($data);
    }

    private function generarGraficoEstadisticaPregunta($data) {
        $width = 500;
        $height = 300;

        // Crear una imagen en blanco
        $image = imagecreate($width, $height);

        // Colores
        $white = imagecolorallocate($image, 255, 255, 255);
        $blue = imagecolorallocate($image, 100, 149, 237);
        $black = imagecolorallocate($image, 0, 0, 0);

        // Fondo blanco
        imagefill($image, 0, 0, $white);

        // Dibujar el gráfico de barras
        $barWidth = 100;
        $barSpacing = 100;
        $baseLine = $height - 50;
        $font = 5;  // Tamaño de la fuente

        $labels = ['Correctas', 'Incorrectas'];
        $x = $barSpacing;
        foreach ($data as $index => $value) {
            $barHeight = $value * 2; // Ajusta este factor para que las barras se vean bien
            imagefilledrectangle($image, $x, $baseLine - $barHeight, $x + $barWidth, $baseLine, $blue);
            imagestring($image, $font, $x + 10, $baseLine + 10, $labels[$index] . ': ' . $value . '%', $black);
            $x += $barWidth + $barSpacing;
        }

        // Guardar la imagen como archivo
        $filePath = __DIR__ . '/../public/imagenes/grafico/graficoEstadisticasPreguntas.png';
        imagepng($image, $filePath);
        imagedestroy($image);
    }


    public function filtroPreguntaDificultad() {
        $dificultad = $_POST['dificultad'] ?? null;
        if($dificultad == 1){

        }else if ($dificultad == 2){

        }else if($dificultad == 3){

        }

    }

}
