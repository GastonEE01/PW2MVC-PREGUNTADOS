<?php

class PartidaController
{
    private $model;
    private $presenter;

    public function __construct($model, $presenter)
    {
        $this->model = $model;
        $this->presenter = $presenter;
    }

    public function crearPartida()
    {
         $sesion = new ManejoSesiones();
         $user = $sesion->obtenerUsuario();
         $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : null;
         $result = $this->model->crearPartida($descripcion, $user['id']);
         $partida = $this->model->buscarPorID($result['user_id']);
         $cantRegistros = count($partida);
         $cantRegistros -= 1;
         $fotoIMG = $user['Path_img_perfil'] ?? 'Invitado';

         $partidas = $this->model->obtenerPartidasEnCurso($user['id']);
         $mejoresPunutajesJugador = $this->model->trearMejoresPuntajesJugadores();

         echo $this->presenter->render('view/home.mustache', ['partidas' => $partidas,
             'nombre_usuario' => $user['nombre_usuario'],
             'puntajes' => $mejoresPunutajesJugador,
             'Path_img_perfil' => $fotoIMG,
         ]);
    }

    public function jugarPartida(){
        $url = $_SERVER['REQUEST_URI'];

        // Dividir la URL en partes (separadas por '/')
        $parts = explode('/', $url);

        // Capturar el último elemento (que sería el ID)
        $id_partida = end($parts);

        // Validar que sea un número o manejar errores
        //$id_partida = is_numeric($id_partida) ? $id_partida : null;
        $sesion = new ManejoSesiones();
        $usuario = $sesion->obtenerUsuario();
        $username = $usuario['nombre_usuario'] ?? 'Invitado';
        $fotoIMG = $usuario['Path_img_perfil'] ?? 'Invitado';
        $sesion->guardarIdPartida($id_partida);
        $categoria=$this->model-> obtenerCategoriaAlAzar();

        echo $this->presenter->render("view/partida.mustache", [
            'categoria'=>$categoria[0]['categoria'],
            'id_partida'=> $id_partida,
            'nombre_usuario'=>$username,
            'Path_img_perfil' => $fotoIMG,

        ]);

    }

    public function mostrarPregunta() {
        $sesion = new ManejoSesiones();
        $user = $sesion->obtenerUsuario();
        $id_partida = $sesion->obtenerIdPartida();
        $username = $user['nombre_usuario'] ?? 'Invitado';

      //  $id_partida = isset($_GET['id_partida']) ? $_GET['id_partida'] : null;
        $categoria = isset($_GET['categoria']) ? $_GET['categoria'] : null;
        $nivelUsuario = $this->model->verificarNivelDeUsuario($user['id']);
        $pregunta = $this->model->buscarPregunta($categoria, $nivelUsuario);
        $opcion = $this->model->traerRespuestasDePregunta($pregunta['ID']);
        $fotoIMG = $user['Path_img_perfil'] ?? 'Invitado';
        //$mostrarModal = "NoEligioOpcion";

        $data = [
            'pregunta' => $pregunta['Pregunta'],
            'id_pregunta' => $pregunta['ID'],
            'opcion1' => $opcion[0]['Texto_respuesta'],
            'opcion2' => $opcion[1]['Texto_respuesta'],
            'opcion3' => $opcion[2]['Texto_respuesta'],
            'opcion4' => $opcion[3]['Texto_respuesta'],
            'id_partida' => $id_partida,
            'categoria' => $categoria,
            'nombre_usuario' => $username,
            //'mostrarModal' => $mostrarModal,
            'Path_img_perfil' => $fotoIMG,
        ];

        echo $this->presenter->render('view/preguntaPartida.mustache', $data);
    }

public function validarRespuesta()
{

    $id = isset($_POST['id_partida']) ? $_POST['id_partida'] : null;
    $id_partida = intval($id);
    $respuesta = isset($_POST['answer']) ? $_POST['answer'] : null;
    $tiempo = isset($_POST['tiempo']) ? $_POST['tiempo'] : null;
    $tiempo_int = intval($tiempo);
    $sesion = new ManejoSesiones();
    $user = $sesion->obtenerUsuario();
    $fotoIMG = $user['Path_img_perfil'] ?? 'Invitado';

    if ($respuesta != null) {
        $respuesVerificada = $this->model->verificarRespuesta($respuesta, $user['id'], $id_partida, $tiempo_int);
        if ($respuesVerificada != null) {
            $categoria = $this->model->obtenerCategoriaAlAzar();
            echo $this->presenter->render("view/partida.mustache", [
                'categoria' => $categoria[0]['categoria'],
                'id_partida' => $id_partida,
                'Es_correcta' => $respuesVerificada,
                'Path_img_perfil' => $fotoIMG
            ]);
        } else {
            $sesion = new ManejoSesiones();
            $user = $sesion->obtenerUsuario();
            $mejoresPuntajesJugador = $this->model->trearMejoresPuntajesJugadores();
            $actualizarPartida = $this->model->actualizarPartida($id_partida);
            $partidas = $this->model->obtenerPartidasEnCurso($user['id']);
            $fotoIMG = $user['Path_img_perfil'] ?? 'Invitado';
            echo $this->presenter->render('view/home.mustache', ['partidas' => $partidas,
                'puntajes' => $mejoresPuntajesJugador,
                'nombre_usuario' => $user['nombre_usuario'],
                'Es_correcta' => $respuesVerificada,
                'Path_img_perfil' => $fotoIMG]);
        }
    } else {
        // Actualziar el ranking despues de jugar una partida
        $actualizarPartida = $this->model->actualizarPartida($id_partida);
        $sesion = new ManejoSesiones();
        $user = $sesion->obtenerUsuario();
        $fotoIMG = $user['Path_img_perfil'] ?? 'Invitado';
        $mejoresPuntajesJugador1 = $this->model->trearMejoresPuntajesJugadores();
        $partidas1 = $this->model->obtenerPartidasEnCurso($user['id']);
        echo $this->presenter->render('view/home.mustache', ['partidas' => $partidas1,
            'puntajes' => $mejoresPuntajesJugador1,
            'nombre_usuario' => $user['nombre_usuario'],
            'Path_img_perfil' => $fotoIMG
        ]);
    }
}

    // CON MODAL
/*
    public function validarRespuesta() {
        $sesion = new ManejoSesiones();
        $user = $sesion->obtenerUsuario();
        $id = isset($_POST['id_partida']) ? $_POST['id_partida'] : null;
        $id_partida = intval($id);
        $respuesta = isset($_POST['answer']) ? $_POST['answer'] : null;
        $tiempo = isset($_POST['tiempo']) ? $_POST['tiempo'] : null;
        $tiempo_int = intval($tiempo);
        print_r($user);
        if ($respuesta != null ) {
            // Verifica si la respuesta es correcta
            $respuesVerificada = $this->model->verificarRespuesta($respuesta, $user['id'], $id_partida, $tiempo_int);
            if ($respuesVerificada != null) {
                // Respuesta correcta
                $mostrarModal = "correcto"; // Modal para respuesta correcta
                $categoria = $this->model->obtenerCategoriaAlAzar();

                echo $this->presenter->render('view/preguntaPartida.mustache', [
                    'categoria' => $categoria[0]['categoria'],
                    'id_partida' => $id_partida,
                    'Es_correcta' => $respuesVerificada,
                    //'mostrarModal' => $mostrarModal // Pasamos la variable correcta
                ]);
            } else {
                // Respuesta incorrecta
                $mostrarModal = "incorrecto"; // Modal para respuesta incorrecta
                $mejoresPuntajesJugador = $this->model->trearMejoresPuntajesJugadores();
                $actualizarPartida = $this->model->actualizarPartida($id_partida);
                $partidas = $this->model->obtenerPartidasEnCurso($user['id']);
                echo $this->presenter->render('view/preguntaPartida.mustache', [
                    'partidas' => $partidas,
                    'puntajes' => $mejoresPuntajesJugador,
                    'nombre_usuario' => $user['nombre_usuario'],
                    'Es_correcta' => $respuesVerificada,
                   // 'mostrarModal' => $mostrarModal // Pasamos la variable incorrecta
                ]);
            }
        } else {
            // Si no se eligió una opción
            $actualizarPartida = $this->model->actualizarPartida($id_partida);
            $sesion = new ManejoSesiones();
            $user = $sesion->obtenerUsuario();
            $mejoresPuntajesJugador1 = $this->model->trearMejoresPuntajesJugadores();
            $partidas1 = $this->model->obtenerPartidasEnCurso($user['id']);
            $mostrarModal = "NoEligioOpcion"; // Modal para cuando no se eligió una opción
            echo $this->presenter->render('view/preguntaPartida.mustache', [
                'partidas' => $partidas1,
                'puntajes' => $mejoresPuntajesJugador1,
                'nombre_usuario' => $user['nombre_usuario'],
                'mostrarModal' => $mostrarModal // Pasamos la variable NoEligioOpcion
            ]);
        }
    }

    public function usuarioRespondioBien(){
        $sesion=New ManejoSesiones();
        $user = $sesion->obtenerUsuario();
        if($user != null) {
            //$id = isset($_POST['id_partida']) ? $_POST['id_partida'] : null;
           // $id_partida = intval($id);
            $fotoIMG = $user['Path_img_perfil'] ?? 'Invitado';
            $categoria = $this->model->obtenerCategoriaAlAzar();
            $id_partida = $sesion->obtenerIdPartida();

            echo $this->presenter->render("view/partida.mustache", [
                'categoria' => $categoria[0]['categoria'],
                'id_partida' => $id_partida,
                'nombre_usuario' => $user['nombre_usuario'],
                'Path_img_perfil' => $fotoIMG,
            ]);
        }
    }

    public function usuarioRespondioMal()
    {
        $sesion=New ManejoSesiones();
        $user = $sesion->obtenerUsuario();
        $id_partida = $sesion->obtenerIdPartida();
        $mejoresPuntajesJugador = $this->model->trearMejoresPuntajesJugadores();
        $id=isset($_POST['id_partida'])?$_POST['id_partida']:null;
        $id_partida=intval($id);
        //print_r($id_partidaActual);
        $actualizarPartida = $this->model->actualizarPartida($id_partida);
        $partidas = $this->model->obtenerPartidasEnCurso($user['id']);
        $fotoIMG = $user['Path_img_perfil'] ?? 'Invitado';
        if($user != null) {
            echo $this->presenter->render('view/home.mustache', ['partidas' => $partidas,
                'puntajes' => $mejoresPuntajesJugador,
                'nombre_usuario' => $user['nombre_usuario'],
                'Path_img_perfil' => $fotoIMG,
                'id_partida' => $id_partida,

            ]);
        }
    }
*/

}
?>
