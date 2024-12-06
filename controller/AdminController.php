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
            $this->vistaLogin();
            return;
        }

        $this->presenter->render('view/admin.mustache', [
            'nombre_usuario' => $user['nombre_usuario'],
            'id' => $id_usuario,
            'Path_img_perfil' => $fotoIMG,
        ]);
    }

    public function obtenerUsuarioPorEdad() {
        $data = $this->model->clasificarUsuariosPorEdad(); // Ejemplo: ['Niños (0-12)' => 5, 'Adultos Jóvenes (18-35)' => 15]
        $width = 1000;
        $height = 500;

// Crear una imagen en blanco
        $image = imagecreate($width, $height);

// Colores
        $white = imagecolorallocate($image, 255, 255, 255);
        $black = imagecolorallocate($image, 0, 0, 0);
        $blue = imagecolorallocate($image, 100, 149, 237);

// Fondo blanco
        imagefill($image, 0, 0, $white);

// Dibujar el gráfico de barras
        $barWidth = 40;
        $barSpacing = 120;
        $baseLine = $height - 50;
        $font = 5;  // Tamaño de la fuente

// Definir etiquetas para las barras
        $labels = ['niños'.$data[0].'%','adolescentes'.$data[1].'%','adultos'.$data[2].'%','ancianos'.$data[3].'%'];  // Etiquetas de las barras
        $x = $barSpacing;
        foreach ($data as $index => $value) {
            $barHeight = $value * 5; // Escalar los valores, ajusta el factor si es necesario
            imagefilledrectangle($image, $x, $baseLine - $barHeight, $x + $barWidth, $baseLine, $blue);
            imagestring($image, $font, $x, $baseLine + 20, $labels[$index], $black); // Etiqueta debajo de la barra
            $x += $barWidth + $barSpacing;
        }
// Guardar la imagen como archivo
        $filePath = __DIR__ . '/../public/imagenes/grafico/graficoUsuarioPorEdad.png';
        imagepng($image, $filePath);
        imagedestroy($image);
        $this->generarPDF->descargarPDF();

      //  $this->generarPDF->descargarPDFUsuarioPorEdad($data[0],$data[1],$data[2],$data[3]);
    }


    public function obtenerEstadisticasPreguntas() {
        // Datos ficticios que podrían venir de una consulta a la base de datos
        $data=$this->model->traerPreguntasCorrectas();
        // Datos ficticios que podrían venir de una consulta a la base de datos
        // $data = [55, 44];  // Ejemplo de datos numéricos

        $width = 500;
        $height = 300;

// Crear una imagen en blanco
        $image = imagecreate($width, $height);

// Colores
        $white = imagecolorallocate($image, 255, 255, 255);
        $black = imagecolorallocate($image, 0, 0, 0);
        $blue = imagecolorallocate($image, 100, 149, 237);

// Fondo blanco
        imagefill($image, 0, 0, $white);

// Dibujar el gráfico de barras
        $barWidth = 40;
        $barSpacing = 120;
        $baseLine = $height - 50;
        $font = 5;  // Tamaño de la fuente

// Definir etiquetas para las barras
        $labels = ['correctas '.$data[0]. "%", 'incorrectas '.$data[1]. "%"];  // Etiquetas de las barras

        $x = $barSpacing;
        foreach ($data as $index => $value) {
            $barHeight = $value * 5; // Escalar los valores, ajusta el factor si es necesario
            imagefilledrectangle($image, $x, $baseLine - $barHeight, $x + $barWidth, $baseLine, $blue);
            imagestring($image, $font, $x, $baseLine + 20, $labels[$index], $black); // Etiqueta debajo de la barra
            $x += $barWidth + $barSpacing;
        }

// Guardar la imagen como archivo
        $filePath = __DIR__ . '/../public/imagenes/grafico/grafcioEstadisticasPreguntas.png';
        imagepng($image, $filePath);
        imagedestroy($image);

        $this->generarPDF->descargarPDF();
    }

}
