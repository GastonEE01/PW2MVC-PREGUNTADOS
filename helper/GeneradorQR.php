<?php

include("libs/qr/phpqrcode/qrlib.php");

class GeneradorQR
{

    public function __construct($outputDir = "public/imagenes/qr/")
    {
        $this->outputDir = $outputDir;

       //  Asegúrate de que el directorio exista
        if (!is_dir($this->outputDir)) {
            mkdir($this->outputDir, 0777, true);
        }
    }

    public function generarQRUsuario($nombre_usuario,$ciudad,$pais,$gmail)
    {
        $datos = "Nombre: $nombre_usuario\nCiudad: $ciudad\nPaís: $pais\nGmail: $gmail";

        $nombreArchivo = $this->outputDir . "qr_" . $nombre_usuario . ".png";

        QRcode::png($datos, $nombreArchivo, QR_ECLEVEL_L, 8);

        //QR_ECLEVEL_L es el nivel de corrección de errores del QR
        //8 es el tamaño del pixelado del QR (8 es el mas grande).
        return $nombreArchivo; // Retorna la ruta del archivo generado

     /*   $datos = "Nombre:Cacho";
        QRcode::png($datos, false, QR_ECLEVEL_L, 8);


        QRcode::png('xdlfjhsdfljghsfd', 'cacho.png');*/
    }
}