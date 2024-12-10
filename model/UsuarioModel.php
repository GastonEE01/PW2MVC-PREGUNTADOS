<?php

class UsuarioModel
{

    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function loginUser($nombre_usuario, $contrasenia)
    {
        if (empty($nombre_usuario) || empty($contrasenia)) {
            return null;
        }

        $sql = "SELECT contrasenia FROM usuario WHERE nombre_usuario = ?"; //buscamos la contraseña hasheada
        $stmt1 = $this->database->execute($sql, [$nombre_usuario]);

        if (empty($stmt1)) {
            return null;
        }

        $hashAlmacenado = $stmt1[0]['contrasenia'];//almacenamos la contraceña hasheada
        if ($hashAlmacenado && password_verify($contrasenia, $hashAlmacenado)) {//verificamos si la contraceña que ingreso el usuario concuerda con la contraseña hasheada en la base de datos

            // Contraseña válida
            $sql = "SELECT * FROM usuario WHERE nombre_usuario = ?"; // Usamos la clase Conexion_db, que ya tiene la conexión manejada
            $stmt = $this->database->getConnection()->prepare($sql); // Accedemos a la conexion
            if ($stmt === false) {
                die('Error en la preparación de la consulta: ' . $this->database->getConnection()->error);
            }
            $stmt->bind_param("s", $nombre_usuario);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                return $result->fetch_assoc();
            } else {
                return null;
            }

            $stmt->close();
        } else {
            return null;
        }

    }

    public function crearSugerenciaPregunta($data, $id_usuario)
    {
        $sql = "INSERT INTO sugerencia (pregunta, opcionA, opcionB, opcionC, opcionD, opcionCorrecta, categoria, Usuario_id) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $params = [
            $data['Pregunta'],
            $data['OpcionA'],
            $data['OpcionB'],
            $data['OpcionC'],
            $data['OpcionD'],
            $data['OpcionCorrecta'],
            $data['Categoria'],
            $id_usuario
        ];
        $this->database->execute($sql, $params);
    }

    public function crearReportePregunta($data, $idUsuario){
        $sql = "INSERT INTO reporte (Pregunta_id, Descripcion, Usuario_id)
            VALUES (?,?,?)";

        $params = [
            $data['Pregunta_id'],
            $data['Descripcion'],
            $idUsuario
        ];
        $this->database->execute($sql, $params);
    }

  public function obtenerPreguntasSugeridas()
  {
      $sql = "SELECT * FROM sugerencia";
      try {

          $result = $this->database->execute($sql, []);
          return $result;
      } catch (PDOException $e) {
          error_log("Error al obtener preguntas sugeridas: " . $e->getMessage());
      }
  }

    public function obtenerReportes()
    {
        $sql = "SELECT p.Pregunta AS texto_pregunta,r.* 
                FROM reporte r
                INNER JOIN Pregunta p ON r.Pregunta_id = p.ID";

        try {

            $result = $this->database->execute($sql, []);
            return $result;
        } catch (PDOException $e) {
            error_log("Error al obtener preguntas sugeridas: " . $e->getMessage());
        }
    }

    public function ObtenerTodosLosUsuarios()
    {
        $sql = "SELECT * FROM usuario";
        $result =$this->database->execute($sql,[]);
        return $result;
    }

    public function verificarNombreUsuario($nombre_usuario)
    {
        $query = $this->database->getConnection()->prepare("SELECT COUNT(*) FROM usuario WHERE nombre_usuario = ?");

        // Cambiar `bindParam` por `bind_param` y especificar el tipo de parámetro (en este caso, "s" para string)
        $query->bind_param("s", $nombre_usuario);

        $query->execute();
        $result = $query->get_result();
        $count = $result->fetch_row()[0];

        return $count > 0;
    }

    public function crearUsuario($data,$token) {
        if (isset($_FILES["fotoIMG"]) && $_FILES["fotoIMG"]["error"] === UPLOAD_ERR_OK) {
            // Nombre del archivo y ruta temporal
            $archivo = $_FILES["fotoIMG"]["name"];
            $rutaTemporal = $_FILES["fotoIMG"]["tmp_name"];

            // Carpeta de destino
            $directorioDestino = $_SERVER['DOCUMENT_ROOT'] . "/PW2MVC-PREGUNTADOS/public/imagenes/usuarios/";

            // Crear nombre único para evitar conflictos
            $nombreImagen = pathinfo($archivo, PATHINFO_FILENAME);
            $extension = pathinfo($archivo, PATHINFO_EXTENSION);
            $rutaDestino = $directorioDestino . $nombreImagen . "_" . time() . "." . $extension;

            // Mover el archivo
            if (move_uploaded_file($rutaTemporal, $rutaDestino)) {
                error_log("Imagen subida exitosamente a: $rutaDestino");
                $data['fotoIMG'] =  $nombreImagen . "_" . time() . "." . $extension;

            } else {
                die("Error al mover el archivo a la carpeta destino.");
            }
        } else {
            // Si no se sube una imagen, guarda un valor por defecto o null
            $data['fotoIMG'] = 'fotoPorDefecto.png';
        }


        $sql = "INSERT INTO usuario (nombre, nombre_usuario, contrasenia, fecha_nacimiento, pais, sexo, ciudad, email,Path_img_perfil,token,latitudMapa,longitudMapa)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )";

        $params = [
            $data['nombre'],
            $data['nombre_usuario'],
            $data['contrasenia'],
            $data['fecha_nacimiento'],
            $data['pais'],
            $data['sexo'],
            $data['ciudad'],
            $data['email'],
            $data['fotoIMG'],
            $token,
            $data['latitude'],
            $data['longitude'],
        ];

        return $this->database->execute($sql, $params);


    }

    public function validarToken($userId, $token)
    {
        $sql = "SELECT * FROM usuario WHERE id = ? AND token = ?";
        $stmt = $this->database->getConnection()->prepare($sql);
        $stmt->bind_param("is", $userId, $token);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }

    public function activarUsuario($userId,$token)
    {

        if ($this->validarToken($userId,$token)){

            // Actualizar la cuenta del usuario para activarla
            $sql = "UPDATE usuario SET activo = 1 WHERE id = ?";
            $stmt = $this->database->getConnection()->prepare($sql);
            $stmt->bind_param("i", $userId);
            $stmt->execute();
        }
    }
}

?>
