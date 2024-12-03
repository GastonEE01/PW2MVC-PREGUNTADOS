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
            return null; // Devolver null si hay datos faltantes
        }

        $sql = "SELECT contrasenia FROM usuario WHERE nombre_usuario = ?"; //buscamos la contraseña hasheada
        $stmt1 = $this->database->execute($sql, [$nombre_usuario]);

        if (empty($stmt1)) {
            return null;
        }

        $hashAlmacenado = $stmt1[0]['contrasenia'];//almacenamos la contraceña hasheada
        if ($hashAlmacenado && password_verify($contrasenia, $hashAlmacenado)) {//verificamos si la contraceña que ingreso el usuario concuerda con la contraseña hasheada en la base de datos

            // Contraseña válida
            $sql = "SELECT * FROM usuario WHERE nombre_usuario = ?"; // Usamos la clase MysqlObjectDatabase, que ya tiene la conexión manejada
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
        // Ajustamos la consulta SQL. Eliminamos 'ID' si es una columna autoincremental.
        $sql = "INSERT INTO sugerencia (pregunta, opcionA, opcionB, opcionC, opcionD, opcionCorrecta, categoria, Usuario_id) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        // Ajustamos los parámetros para coincidir con la consulta
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

        // Ejecutamos la consulta
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
          // Maneja el error adecuadamente
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

        return $count > 0; // Devuelve true si el nombre de usuario ya existe
    }

    public function crearUsuario($data,$token) {
        if (isset($_FILES["fotoIMG"]) && $_FILES["fotoIMG"]["error"] === UPLOAD_ERR_OK) {
            // Nombre del archivo y ruta temporal
            $archivo = $_FILES["fotoIMG"]["name"];
            $rutaTemporal = $_FILES["fotoIMG"]["tmp_name"];

            // Carpeta de destino
            $directorioDestino = $_SERVER['DOCUMENT_ROOT'] . "/PreguntadosPWII-main/public/imagenes/usuarios/";

            // Crear nombre único para evitar conflictos
            $nombreImagen = pathinfo($archivo, PATHINFO_FILENAME);
            $extension = pathinfo($archivo, PATHINFO_EXTENSION);
            $rutaDestino = $directorioDestino . $nombreImagen . "_" . time() . "." . $extension;

            // Mover el archivo
            if (move_uploaded_file($rutaTemporal, $rutaDestino)) {
                error_log("Imagen subida exitosamente a: $rutaDestino");
                // Guarda la ruta relativa en $data['fotoIMG']
                //$data['fotoIMG'] = "/PreguntadosPWII-main/public/imagenes/usuarios/" . $nombreImagen . "_" . time() . "." . $extension;
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
            $data['fotoIMG'],//linea 172
            $token,
            $data['latitude'],
            $data['longitude'],
        ];

        return $this->database->execute($sql, $params);


    }

    public function validarToken($userId, $token)
    {
        // Aquí haces la consulta a la base de datos para verificar el token
        $sql = "SELECT * FROM usuario WHERE id = ? AND token = ?";
        $stmt = $this->database->getConnection()->prepare($sql);
        $stmt->bind_param("is", $userId, $token);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0; // Devuelve verdadero si hay una coincidencia
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







/* public function logearse($nombreUsuario, $password)
 {
     $sql = "SELECT * FROM usuario WHERE nombreUsuario = '$nombreUsuario' LIMIT 1";
     $result = $this->database->query($sql);

     if (count($result) > 0 && password_verify($password, $result[0]['password'])) {
         $_SESSION["id"] = $result[0]['id'];
         if ($result[0]['activo'] == 1) {
             return ['success' => true, 'message' => 'Inicio de sesión exitoso'];
         } else {
             return ['success' => false, 'message' => 'Debe activar su cuenta para iniciar sesion!'];
         }
     } else {
         return ['success' => false, 'message' => 'Nombre de usuario o contraseña incorrectos'];
     }
 }

 public function logout()
 {
     session_destroy();
 }

 public function buscarUsuario($nombreUsuario, $mail)
 {
     $usuarioExistenteSQL = "SELECT 1 FROM usuario WHERE nombreUsuario = '$nombreUsuario' OR mail = '$mail'";
     return $this->database->query($usuarioExistenteSQL);
 }

 public function registro($nombreCompleto, $anioNacimiento, $sexo, $pais, $ciudad, $mail, $password, $nombreUsuario, $fotoTmp, $hash, $latitud, $longitud)
 {
     $hashPass = password_hash($password, PASSWORD_BCRYPT);
     if($fotoTmp){
         $carpeta = "public/imagenes/usuarios/";
         $imagen_nombre = "$nombreUsuario.jpg";
         move_uploaded_file($fotoTmp, $carpeta . $imagen_nombre);

         return $this->database->execute(
             "INSERT INTO `Usuario`(`nombreCompleto`, `anioNacimiento`, `sexo`, `pais` , `ciudad` , `mail` , `password` , `nombreUsuario` , `fechaRegistro`, `tipoUsuario` ,`foto`, `puntaje`, `activo`, `hash`, `latitud`, `longitud`)
                     VALUES ('$nombreCompleto', '$anioNacimiento', '$sexo', '$pais','$ciudad','$mail','$hashPass','$nombreUsuario', NOW(),'Jugador','$imagen_nombre','0', '0', '$hash', '$latitud', '$longitud')");
     }
     return $this->database->execute(
         "INSERT INTO `Usuario`(`nombreCompleto`, `anioNacimiento`, `sexo`, `pais` , `ciudad` , `mail` , `password` , `nombreUsuario` , `tipoUsuario` , `puntaje`, `activo`, `hash`, `latitud`, `longitud`)
                     VALUES ('$nombreCompleto', '$anioNacimiento', '$sexo', '$pais','$ciudad','$mail','$hashPass','$nombreUsuario','Jugador','0', '0', '$hash', '$latitud', '$longitud')");
 }

 public function confirmacionCuenta($hashUsuario)
 {
     $query = "SELECT 1 FROM usuario WHERE hash = '$hashUsuario' LIMIT 1";
     $result = $this->database->query($query);
     if (count($result) == 1) {
         $queryConfirmacion = "UPDATE usuario SET activo = 1, hash = NULL WHERE hash = '$hashUsuario'";
         $this->database->execute($queryConfirmacion);
         return true;
     }

     return false;
 }

 public function getUsuarioById($idUsuario)
 {
     $sql = "SELECT * FROM usuario WHERE id = '$idUsuario' LIMIT 1";
     $result = $this->database->query($sql);
     return $result[0];
 }

 public function getJugadoresConPuntajeYPartidasJugadas()
 {
     $sql = "SELECT
     u.nombreUsuario AS nombreCompleto,
     u.puntaje AS puntajeTotal,
     u.id AS id,
     u.foto AS foto,  -- Agregar el campo 'foto'
     COALESCE(partidas.totalPartidas, 0) AS totalPartidas,
     COALESCE(mejorPartida.correctas, 0) AS mejorPartida
 FROM
     usuario u
 LEFT JOIN (
     SELECT
         p.idUsuario,
         COUNT(p.id) AS totalPartidas
     FROM
         partida p
     GROUP BY
         p.idUsuario
 ) AS partidas ON u.id = partidas.idUsuario
 LEFT JOIN (
     SELECT
         sub.idUsuario,
         sub.correctas
     FROM (
         SELECT
             p.idUsuario,
             pp.idPartida,
             SUM(CASE WHEN pp.correcta = 1 THEN 1 ELSE 0 END) AS correctas,
             p.fechaRealizado,
             ROW_NUMBER() OVER (PARTITION BY p.idUsuario ORDER BY SUM(CASE WHEN pp.correcta = 1 THEN 1 ELSE 0 END) DESC, p.fechaRealizado DESC) AS rn
         FROM
             partida_pregunta pp
         JOIN
             partida p ON pp.idPartida = p.id
         GROUP BY
             p.idUsuario, pp.idPartida, p.fechaRealizado
     ) sub
     WHERE sub.rn = 1
 ) AS mejorPartida ON u.id = mejorPartida.idUsuario
 ORDER BY
     u.puntaje DESC";

     return $this->database->query($sql);
 }

 public function getPartidasTotalesPorUsuario($idUsuario)
 {
     $sql = "SELECT COUNT(*) AS partidasTotales FROM partida WHERE idUsuario = '$idUsuario'";
     return $this->database->query($sql);
 }

}*/

?>
