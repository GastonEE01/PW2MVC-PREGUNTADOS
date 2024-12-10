<?php

class EditorController
{
    private $model;
    private $presenter;
    private $modelUsuario;

    public function __construct($model, $presenter,$modelUsuario)
    {
        $this->model = $model;
        $this->presenter = $presenter;
        $this->modelUsuario = $modelUsuario;

    }

    public function vistaEditor()
    {
        $sesion = new ManejoSesiones();
        $user = $sesion->obtenerUsuario();
        $sesion->iniciarSesion($user);
        $id_usuario = $sesion->obtenerUsuarioID();

        if (empty($user)) {
            header("Location: /PW2MVC-PREGUNTADOS/Usuario/login");
            exit();
        }

        $pregutasSugeridas = $this->modelUsuario->obtenerPreguntasSugeridas();
        $reportes = $this->modelUsuario-> obtenerReportes();
        $fotoIMG = $user['Path_img_perfil'] ?? 'Invitado';

        $this->presenter->render('view/editor.mustache', [
            'nombre_usuario' => $user['nombre_usuario'],
            'id' => $id_usuario,
            'reportes' => $reportes,
            'preguntasSugeridas' => $pregutasSugeridas,
            'Path_img_perfil' => $fotoIMG,
            ]);
    }

    public function eliminarPregunta()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ID'])) {
            $id = $_POST['ID'];
            print_r($id);

            $this->model->eliminarPregunta($id);
        }
        $this->vistaEditor();

    }

    public function agregarPregunta()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ID'])) {

            $id = $_POST['ID'];

            $pregunta=isset($_POST['Pregunta'])?$_POST['Pregunta']:null;

            $OpcionA=isset($_POST['OpcionA'])?$_POST['OpcionA']:null;

            $OpcionB=isset($_POST['OpcionB'])?$_POST['OpcionB']:null;

            $OpcionC=isset($_POST['OpcionC'])?$_POST['OpcionC']:null;

            $OpcionD=isset($_POST['OpcionD'])?$_POST['OpcionD']:null;

            $OpcionCorrecta=isset($_POST['OpcionCorrecta'])?$_POST['OpcionCorrecta']:null;

            $Categoria=isset($_POST['Categoria'])?$_POST['Categoria']:null;

            if ($pregunta !=null && $OpcionA !=null  && $OpcionB !=null&& $OpcionC !=null&& $OpcionD !=null&& $OpcionCorrecta !=null && $Categoria!=null) {
                try {

                    $this->model->agregarPregunta($pregunta,$OpcionA,$OpcionB,$OpcionC,$OpcionD,$OpcionCorrecta,$Categoria);
                    $this->model->eliminarPregunta($id);
                    $this->vistaEditor();

                } catch (Exception $e) {
                    echo "Error al agregar la pregunta: " . $e->getMessage() ;
                }
            } else {
                echo "Faltan parámetros para agregar la pregunta.";
            }
        } else {
            echo "No se proporcionó un ID para eliminar.";
        }
    }
    public function modificarPregunta() {
        $Usuario_id = isset($_POST['Usuario_id'])?$_POST['Usuario_id']:null;

        $Pregunta=isset($_POST['Pregunta'])?$_POST['Pregunta']:null;

        $OpcionA=isset($_POST['OpcionA'])?$_POST['OpcionA']:null;

        $OpcionB=isset($_POST['OpcionB'])?$_POST['OpcionB']:null;

        $OpcionC=isset($_POST['OpcionC'])?$_POST['OpcionC']:null;

        $OpcionD=isset($_POST['OpcionD'])?$_POST['OpcionD']:null;

        $OpcionCorrecta=isset($_POST['OpcionCorrecta'])?$_POST['OpcionCorrecta']:null;

        $Categoria=isset($_POST['Categoria'])?$_POST['Categoria']:null;

        $ID=isset($_POST['ID'])?$_POST['ID']:null;

        $resultado = $this->model->modificarPreguntaSugerida($Pregunta, $OpcionA, $OpcionB, $OpcionC, $OpcionD, $OpcionCorrecta, $Categoria,$Usuario_id,$ID);

        if ($resultado['affected_rows'] > 0) {
            $this->vistaEditor();
        } else {
            echo "Advertencia: No se actualizó ninguna fila. Verifica que el ID existe y los datos han cambiado.";
        }
    }

    public function rechazarReporte() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ID'])) {
            $idReporte = $_POST['ID'];

            $this->model->eliminarReporte($idReporte);
        }
        $this->vistaEditor();
    }

    public function aprobarReporte() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ID']) && isset($_POST['Pregunta_id'])) {
            $idReporte = $_POST['ID'];
            $idPregunta = $_POST['Pregunta_id'];

            $this->model->eliminarRespuestas($idPregunta);
            $this->model->eliminarReporteRelacionado($idPregunta);

            $this->model->eliminarPreguntaRe($idPregunta);
            $this->model->eliminarReporte($idReporte);

        }
        $this->vistaEditor();
    }
}
