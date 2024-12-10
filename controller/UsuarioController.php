<?php
require 'libs/PHPMailer/src/Exception.php';
require 'libs/PHPMailer/src/PHPMailer.php';
require 'libs/PHPMailer/src/SMTP.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
class UsuarioController
{
    private $model;
    private $presenter;
    private $modelPartida;
    private $senderEmailPHPMailer;
    private $generadorQR;

    public function __construct($model, $presenter,$modelPartida,$senderEmailPHPMailer,$generadorQR)
    {
        $this->model = $model;
        $this->presenter = $presenter;
        $this->modelPartida = $modelPartida;
        $this->senderEmailPHPMailer = $senderEmailPHPMailer;
        $this->generadorQR = $generadorQR;

    }

    public function vistaRegistro()
    {
        $this->presenter->render("view/registro.mustache");
    }

    public function vistaLogin()
    {
        // Si pongo esto se rompe la parte de las pregunta partida
        // $sesion = new ManejoSesiones();
        // $sesion->limpiarCache();
        $this->presenter->render("view/login.mustache");
    }

    public function cerrarSesion()
    {
        $sesion = new ManejoSesiones();
        $sesion->cerrarSesion();
        $this->presenter->render("view/login.mustache");
    }

    public function vistaHome()
    {
        $sesion = new ManejoSesiones();
        $user = $sesion->obtenerUsuario();
        $sesion->iniciarSesion($user);
        $id_usuario = $sesion->obtenerUsuarioID();

        if (empty($user)) {
            $this->vistaLogin();
            return;
        }

        $mejoresPuntajesJugador = $this->modelPartida->trearMejoresPuntajesJugadores();
        $partidas = $this->modelPartida->obtenerPartidasEnCurso($user['id']);
        $fotoIMG = $user['Path_img_perfil'] ?? 'Invitado';
            $this->presenter->render('view/home.mustache', ['partidas' => $partidas,
                'nombre_usuario' => $user['nombre_usuario'],
                'id' => $id_usuario,
                'puntajes' => $mejoresPuntajesJugador,
                'Path_img_perfil' => $fotoIMG,
            ]);
    }

    public function vistaPerfil()
    {
        $sesion = new ManejoSesiones();
        $user = $sesion->obtenerUsuario();
        $id_usuario = $sesion->obtenerUsuarioID();
        $pais = $user['pais'] ?? 'Invitado';
        $ciudad = $user['ciudad'] ?? 'Invitado';
        $nombre_usuario = $user['nombre_usuario'] ?? 'Invitado';
        $gmail= $user['email'] ?? 'Invitado';
        $longitudMapa = $user['latitudMapa'] ?? 'Invitado';
        $latitudMapa = $user['longitudMapa'] ?? 'Invitado';
        $fotoIMG = $user['Path_img_perfil'] ?? 'Invitado';

        if (empty($user)) {
            $this->vistaLogin();
            return;
        }

        $partidas = $this->modelPartida->obtenerPartidasFinalizada($user['id']);
        $generarQR = $this->generadorQR->generarQRUsuario($nombre_usuario,$ciudad,$pais,$gmail);


        $this->presenter->render('view/perfil.mustache', ['partidas' => $partidas,
            'nombre_usuario' => $nombre_usuario,
            'id' => $id_usuario,
            'pais' => $pais,
            'ciudad' => $ciudad,
            'fotoIMG' => $fotoIMG,
            'longitudMapa' => $longitudMapa,
            'latitudMapa' => $latitudMapa,
            'Path_img_perfil' => $fotoIMG,
            'qrUsuario'=> $generarQR,
            'email'=> $gmail,

        ]);
    }

    public  function registro($data){
        $errors = [];

        // Validar email
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL) || strpos($data['email'], '@gmail.com') === false) {
            $errors[] = 'El email debe ser un Gmail válido.';
        }

        // Validar que el usuario sea unico
        if ($this->model->verificarNombreUsuario($data['nombre_usuario'])){
            $errors[] = 'El nombre de usuario ya existe.';
        }

        // Validar contraseña
        if (strlen($data['contrasenia']) < 5 || !preg_match('/[A-Za-z]/', $data['contrasenia']) || !preg_match('/[0-9]/', $data['contrasenia'])) {
            $errors[] = 'La contraseña debe tener al menos 5 caracteres, incluyendo al menos 1 letra y 1 número.';
        }

        // Verificar que la contraseña y la repetición coincidan
        if ($data['contrasenia'] !== $data['repeatPassword']) {
            $errors[] = 'Las contraseñas no coinciden.';
        }

        if (!empty($errors)) {
            echo $this->presenter->render('view/registro.mustache', ['errors' => $errors]);
            return;
        }
        $data['contrasenia'] = password_hash($data['contrasenia'], PASSWORD_DEFAULT);
        // Generar un token antes de crear el usuario
        $token = bin2hex(random_bytes(16));
        $userID =  $this->model->crearUsuario($data,$token);
        if ($userID['affected_rows']) {
            $this->senderEmailPHPMailer->sendActivationEmail($userID['user_id'], $data['email'], $token);
        } else {
            echo "Error al registrar el usuario.";
        }
        echo $this->presenter->render('view/login.mustache', ['success' => 'Revisa tu correo para activar tu cuenta.']);
    }
    public function  activarCuenta()
    {
        $token=isset($_GET['token'])?$_GET['token']:null;
        $idUser=isset( $_GET['id'])?$_GET['id']:null;
        if ($idUser!=null){
            $this->model->activarUsuario($idUser,$token);

        }
        echo $this->presenter->render('view/login.mustache');
    }

    public function validarUsuario($formData)
    {
        $nombre_usuario = $formData['nombre_usuario'] ?? null;
        $contrasenia = $formData['contrasenia'] ?? null;

        // Usa el modelo para validar al usuario
        $user = $this->model->loginUser($nombre_usuario, $contrasenia);

        if ($user && isset($user['activo']) && $user['activo'] == 1) {
            $sesion = new ManejoSesiones();
            $sesion->iniciarSesion($user);

            $user = $sesion->obtenerUsuario();
            $id_usuario = $sesion->obtenerUsuarioID();
            $fotoIMG = $user['Path_img_perfil'] ?? 'Invitado';

            $mejoresPuntajesJugador = $this->modelPartida->trearMejoresPuntajesJugadores();
            $partidas = $this->modelPartida->obtenerPartidasEnCurso($user['id']);

            // Redirige según el rol del usuario
            if ($user['rol'] == 2) {
                $pregutasSugeridas = $this->model->obtenerPreguntasSugeridas();
                $reportes = $this->model-> obtenerReportes();
                $usuarios=$this->model->ObtenerTodosLosUsuarios();
                foreach ($reportes as &$reporte) {
                    foreach ($usuarios as $usuario) {
                        if ($reporte['Usuario_id'] === $usuario['id']) {
                            $reporte['nombre_usuario'] = $usuario['nombre'];
                            break;
                        }
                    }
                }
                    $this->presenter->render('view/editor.mustache',[
                    'nombre_usuario' => $user['nombre_usuario'],
                    'id' => $id_usuario,
                    'reportes' => $reportes,
                    'preguntasSugeridas' => $pregutasSugeridas,
                        'Path_img_perfil' => $fotoIMG]);
            } elseif ($user['rol'] == 3) {
                header("Location: /PW2MVC-PREGUNTADOS/Admin/vistaAdmin");
                exit();
            } else {
                $this->presenter->render('view/home.mustache', ['partidas' => $partidas,
                    'nombre_usuario' => $user['nombre_usuario'],
                    'id' => $id_usuario,
                    'puntajes' => $mejoresPuntajesJugador,
                    'Path_img_perfil' => $fotoIMG]);
            }
            exit;
        } else {
            $this->presenter->render("view/login.mustache", [
                'error' => 'Nombre de usuario o contraseña incorrectos'
            ]);
        }
    }

    public function usuarioSugerirPregunta()
    {
        $sesion = new ManejoSesiones();
        $id_usuario = $sesion->obtenerUsuarioID();

        $data = [
            'Pregunta' => $_POST['pregunta'] ?? '',
            'OpcionA' => $_POST['optionA'] ?? '',
            'OpcionB' => $_POST['optionB'] ?? '',
            'OpcionC' => $_POST['optionC'] ?? '',
            'OpcionD' => $_POST['optionD'] ?? '',
            'OpcionCorrecta' => $_POST['opcionCorrecta'] ?? '',
            'Categoria' => $_POST['categoriaElegida'] ?? ''
        ];

        $this->model->crearSugerenciaPregunta($data, $id_usuario);
        $partidas = $this->modelPartida->obtenerPartidasEnCurso($id_usuario);
        $mejoresPuntajesJugador = $this->modelPartida->trearMejoresPuntajesJugadores();
        $user = $sesion->obtenerUsuario();
        $fotoIMG = $user['Path_img_perfil'] ?? 'Invitado';
        echo $this->presenter->render("view/home.mustache", [
            'partidas' => $partidas,
            'puntajes' => $mejoresPuntajesJugador,
            'nombre_usuario' => $user['nombre_usuario'],
            'Path_img_perfil' => $fotoIMG,
        ]);
    }

    public function reportarPregunta()
    {
        $sesion = new ManejoSesiones();
        $usuario = $sesion->obtenerUsuario();
        $id_usuario = $sesion->obtenerUsuarioID();
        $idUsuario = $usuario['id'] ?? 'Invitado';
        $user = $sesion->obtenerUsuario();
        $fotoIMG = $user['Path_img_perfil'] ?? 'Invitado';
        $id_partida = isset($_POST['id_partida']) ? $_POST['id_partida'] : null;
        $actualizarPartida = $this->modelPartida->actualizarPartida($id_partida);

        if (isset($_POST['descripcionSeleccionada']) && isset($_POST['id_pregunta'])) {

            $data = [
                'Pregunta_id' => $_POST['id_pregunta'],
                'Descripcion' => $_POST['selectMotivo'],
                'Usuario_id' => $idUsuario,
                'nombre_usuario' => $user['nombre_usuario']
            ];

            $this->model->crearReportePregunta($data, $idUsuario);
            $partidas = $this->modelPartida->obtenerPartidasEnCurso($usuario['id']);
            $mejoresPuntajesJugador = $this->modelPartida->trearMejoresPuntajesJugadores();
            echo $this->presenter->render("view/home.mustache", ['partidas' => $partidas,
                'partidas' => $partidas,
                'puntajes' => $mejoresPuntajesJugador,
                'nombre_usuario' => $user['nombre_usuario'],
                'Path_img_perfil' => $fotoIMG,
            ]);
        } else {
            echo "Faltan datos en el formulario.";
        }
    }

    public function tiempoAcabado(){
        $sesion = new ManejoSesiones();
        $usuario = $sesion->obtenerUsuario();
        $id_usuario = $sesion->obtenerUsuarioID();
        $idUsuario = $usuario['id'] ?? 'Invitado';
        $user = $sesion->obtenerUsuario();
        $fotoIMG = $user['Path_img_perfil'] ?? 'Invitado';
        $id_partida = isset($_POST['id_partida']) ? $_POST['id_partida'] : null;
        $actualizarPartida = $this->modelPartida->actualizarPartida($id_partida);
        $partidas = $this->modelPartida->obtenerPartidasEnCurso($usuario['id']);
        $mejoresPuntajesJugador = $this->modelPartida->trearMejoresPuntajesJugadores();
        echo $this->presenter->render("view/home.mustache", ['partidas' => $partidas,
            'partidas' => $partidas,
            'puntajes' => $mejoresPuntajesJugador,
            'nombre_usuario' => $user['nombre_usuario'],
            'Path_img_perfil' => $fotoIMG,
        ]);
    }



}
