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
        $porcentajeDeCategoriaIncorrectaYCorrecta = $this->model->cantidadDePreguntaIncorrectaPorCategoria();
        $dataEdad = $this->model->clasificarUsuariosPorEdad();
        $dataCantidadPreguntasPorDificultad = $this->model->cantidadDePreguntasPorDificultadYCategoria();

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
            'historia' => $dataPreguntaPorCategoria[2], // Deporte
            'deporte' => $dataPreguntaPorCategoria[3], // Historia
            'ciencia' => $dataPreguntaPorCategoria[4], // Ciencia
            'geografia' => $dataPreguntaPorCategoria[5],// Geografia
            // Pasar la cantidad de preguntas correctas e incorrectas por categoría
            'arteCorrectas' => $porcentajeDeCategoriaIncorrectaYCorrecta[0][0],
            'arteIncorrectas' => $porcentajeDeCategoriaIncorrectaYCorrecta[0][1],
            'cineCorrectas' => $porcentajeDeCategoriaIncorrectaYCorrecta[1][0],
            'cineIncorrectas' => $porcentajeDeCategoriaIncorrectaYCorrecta[1][1],
            'historiaCorrectas' => $porcentajeDeCategoriaIncorrectaYCorrecta[2][0],
            'historiaIncorrectas' =>$porcentajeDeCategoriaIncorrectaYCorrecta[2][1],
            'deporteCorrectas' => $porcentajeDeCategoriaIncorrectaYCorrecta[3][0],
            'deporteIncorrectas' => $porcentajeDeCategoriaIncorrectaYCorrecta[3][1],
            'cienciaCorrectas' => $porcentajeDeCategoriaIncorrectaYCorrecta[4][0],
            'cienciaIncorrectas' => $porcentajeDeCategoriaIncorrectaYCorrecta[4][1],
            'geografiaCorrectas' => $porcentajeDeCategoriaIncorrectaYCorrecta[5][0] ,
            'geografiaIncorrectas' => $porcentajeDeCategoriaIncorrectaYCorrecta[5][1],
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
        $data = $this->model->clasificarUsuariosPorEdad();

        $this->generarGraficoUsuarioPorEdad($data);

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

        // Grafico circular
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

        $filePath = __DIR__ . '/../public/imagenes/grafico/graficoUsuarioPorEdad.png';
        imagepng($image, $filePath);
        imagedestroy($image);
    }


    public function obtenerEstadisticaPregunta() {
        $data = $this->model->traerPreguntasCorrectas();

        $this->generarGraficoEstadisticaPregunta($data);

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
        $font = 5;

        $labels = ['Correctas', 'Incorrectas'];
        $x = $barSpacing;
        foreach ($data as $index => $value) {
            $barHeight = $value * 2; // Ajusta este factor para que las barras se vean bien
            imagefilledrectangle($image, $x, $baseLine - $barHeight, $x + $barWidth, $baseLine, $blue);
            imagestring($image, $font, $x + 10, $baseLine + 10, $labels[$index] . ': ' . $value . '%', $black);
            $x += $barWidth + $barSpacing;
        }

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
