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

    public function vistaLogin()
    {
        $sesion = new ManejoSesiones();
        $sesion->limpiarCache();
        $this->presenter->render("view/login.mustache");
    }

    public function volverAlHome()
    {
        header("Location: /PW2MVC-PREGUNTADOS/Usuario/vistaHome");
        exit();
    }
    public function crearPartida()
    {
         $sesion = new ManejoSesiones();
         $user = $sesion->obtenerUsuario();
         $id_usuario = $sesion->obtenerUsuarioID();
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
             'id' => $id_usuario,
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
        $id_usuario = $sesion->obtenerUsuarioID();

        if (empty($usuario)) {
            header("Location: /PW2MVC-PREGUNTADOS/Usuario/login");
            exit();
        }

        $sesion->guardarIdPartida($id_partida);
        $categoria=$this->model-> obtenerCategoriaAlAzar();

        echo $this->presenter->render("view/partida.mustache", [
            'categoria'=>$categoria[0]['categoria'],
            'id_partida'=> $id_partida,
            'nombre_usuario'=>$username,
            'Path_img_perfil' => $fotoIMG,
            'id' => $id_usuario,
        ]);

    }

    public function mostrarPregunta() {
        $sesion = new ManejoSesiones();
        $user = $sesion->obtenerUsuario();
        $id_partida = $sesion->obtenerIdPartida();
        $id_usuario = $sesion->obtenerUsuarioID();
        $username = $user['nombre_usuario'] ?? 'Invitado';

        $categoria = isset($_GET['categoria']) ? $_GET['categoria'] : null;
        $nivelUsuario = $this->model->verificarNivelDeUsuario($user['id']);
        $pregunta = $this->model->buscarPregunta($categoria, $nivelUsuario);
        $opcion = $this->model->traerRespuestasDePregunta($pregunta['ID']);
        $fotoIMG = $user['Path_img_perfil'] ?? 'Invitado';

        if (empty($user)) {
            header("Location: /PW2MVC-PREGUNTADOS/Usuario/login");
            exit();
        }
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
            'id' => $id_usuario,

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
    $id_usuario = $sesion->obtenerUsuarioID();
    $fotoIMG = $user['Path_img_perfil'] ?? 'Invitado';

    if ($respuesta != null) {
        $respuesVerificada = $this->model->verificarRespuesta($respuesta, $user['id'], $id_partida, $tiempo_int);
        if ($respuesVerificada != null) {
            $categoria = $this->model->obtenerCategoriaAlAzar();
            echo $this->presenter->render("view/partida.mustache", [
                'categoria' => $categoria[0]['categoria'],
                'id_partida' => $id_partida,
                'Es_correcta' => $respuesVerificada,
                'Path_img_perfil' => $fotoIMG,
                'nombre_usuario' => $user['nombre_usuario'],
                'id' => $id_usuario,
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

}
?>
