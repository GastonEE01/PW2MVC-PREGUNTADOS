<?php

class AdminModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function clasificarUsuariosPorEdad() {
        $sql = "SELECT id, nombre, fecha_nacimiento FROM Usuario";
        $result = $this->database->execute($sql, []);

        // Arreglos para clasificar usuarios
        $totalNiños = 0;
        $totalAdolescentes = 0;
        $totalAdultos = 0;
        $totalAncianos = 0;

        // Recorrer los resultados
        foreach ($result as $row) {
            $fechaNacimiento = $row['fecha_nacimiento'];
            $edad = $this->calcularEdad($fechaNacimiento);

            // Clasificar por edad
            if ($edad < 10) {
                $totalNiños++;
            } elseif ($edad < 20) {
                $totalAdolescentes++;
            } elseif ($edad < 40) {
                $totalAdultos++;
            } else {
                $totalAncianos++;
            }
        }
        $totalUsuarios = $totalNiños + $totalAdolescentes + $totalAdultos + $totalAncianos;

        // Calcular porcentajes
        $porcentajeNiños = round(($totalNiños / $totalUsuarios) * 100, 2);
        $porcentajeAdolescentes = round(($totalAdolescentes / $totalUsuarios) * 100, 2);
        $porcentajeAdultos = round(($totalAdultos / $totalUsuarios) * 100, 2);
        $porcentajeAncianos = round(($totalAncianos / $totalUsuarios) * 100, 2);
        // Retornar los resultados clasificados
        return [
            $porcentajeNiños,
            $porcentajeAdolescentes,
            $porcentajeAdultos,
            $porcentajeAncianos
        ];
    }

    public function traerPreguntasCorrectas(){
        $sql = "SELECT * FROM Pregunta ";

        $result= $this->database->execute($sql, []);

        $correctas=0;
        $incorrectas=0;
        foreach ($result as $respuestas){
            $respuestasCorrectas=$respuestas['acertada'];
            $respuestasIncorrectas=$respuestas['mostrada']-$respuestas['acertada'];

            $correctas+=$respuestasCorrectas;
            $incorrectas+=$respuestasIncorrectas;
        }
        $sumaDeAmbas=$correctas+$incorrectas;
        $porcentajeCorrectas =round(($correctas / $sumaDeAmbas) * 100, 2) ;
        $porcentajeIncorrectas = round( ($incorrectas / $sumaDeAmbas) * 100,2);

        $correctaseIncorrectas=[$porcentajeCorrectas,$porcentajeIncorrectas];
        return $correctaseIncorrectas;
    }
    private function calcularEdad($fechaNacimiento) {
        $fechaNac = new DateTime($fechaNacimiento);
        $hoy = new DateTime();
        $edad = $hoy->diff($fechaNac)->y;
        return $edad;
    }

    /*  public function getAllJugadores(){
          $sql = "SELECT
          u.*,
          COUNT(pp.idPregunta) AS cantidadPreguntas
      FROM
          usuario u
      LEFT JOIN
          partida p ON u.id = p.idUsuario
      LEFT JOIN
          partida_pregunta pp ON p.id = pp.idPartida
      WHERE
          u.tipoUsuario = 'Jugador'
      GROUP BY
          u.id";
          return $this->database->query($sql);
      }
      public function getAllPartidas(){
          $sql = "SELECT p.id, p.idUsuario, p.fechaRealizado, COUNT(pp.correcta) AS puntaje
              FROM partida p
              LEFT JOIN partida_pregunta pp ON p.id = pp.idPartida AND pp.correcta = 1
              GROUP BY p.id";
          return $this->database->query($sql);
      }
      public function getNombrePorId($idUsuario){
          $sql = "SELECT nombre FROM usuario WHERE id = $idUsuario";
          return $this->database->query($sql);
      }
      public function getAllPreguntas(){
          $sql = "SELECT * FROM pregunta";
          return $this->database->query($sql);
      }
      public function getAllPreguntasActivas(){
          $sql = "SELECT * FROM pregunta Where estado = 'Activa'";
          return $this->database->query($sql);
      }

      public function getUsuariosNuevos($fechaDesde = null, $fechaHasta = null){
          $whereClause = '';

          if (!empty($fechaDesde && !empty($fechaHasta))) {
              $whereClause = "WHERE fechaRegistro BETWEEN '$fechaDesde' AND '$fechaHasta'";
          } else {
              $whereClause = "WHERE fechaRegistro >= DATE_SUB(CURDATE(), INTERVAL 2 DAY)";
          }
          $consulta = "SELECT * FROM usuario $whereClause";
          return $this->database->query($consulta);
      }


      public function imprimirUsuariosNuevos($fechaDesde = null, $fechaHasta= null){
          $whereClause = '';

          if (!empty($fechaDesde && !empty($fechaHasta))) {
              $whereClause = "WHERE fechaRegistro BETWEEN '$fechaDesde' AND '$fechaHasta'";
          } else {
              $whereClause = "WHERE fechaRegistro >= DATE_SUB(CURDATE(), INTERVAL 2 DAY)";
          }
          $consulta = "SELECT * FROM usuario $whereClause";
          return $this->database->print($consulta);
      }
      public function imprimirTodosLosJugadores(){
          $sql = "SELECT * FROM usuario WHERE tipoUsuario = 'Jugador'";
          $result = $this->database->print($sql);
          return $result;
      }

      public function imprimirTodasLasPartidas(){
          $query = "SELECT p.id, p.idUsuario, p.fechaRealizado, COUNT(pp.correcta) AS puntaje
              FROM partida p
              LEFT JOIN partida_pregunta pp ON p.id = pp.idPartida AND pp.correcta = 1
              GROUP BY p.id";
          return $this->database->print($query);
      }

      public function imprimirTodasLasPreguntas(){
          $query = "SELECT * FROM pregunta";
          $result = $this->database->print($query);
          return $result;
      }

      public function imprimirTodasLasPreguntasActivas(){
          $query = "SELECT * FROM pregunta Where estado = 'Activa'";
          $result = $this->database->print($query);
          return $result;
      }

      private function convertirArrayAJSONPorcentajeRespuesta($queryResult, $cabecera) {
          $result = [];
          $result[] = $cabecera;

          if (is_array($queryResult)) {
              foreach ($queryResult as $row) {
                  $result[] = [$row['nombre'], (float) $row['porcentajeRespuestasCorrectas']];
              }
          } else {
              foreach ($queryResult->result_array() as $row) {
                  $result[] = [$row['nombre'], (float) $row['porcentajeRespuestasCorrectas']];
              }
          }

          return json_encode($result);
      }

      public function getRespuestasCorrectasPorUsuario($fechaDesde = null, $fechaHasta = null)
      {
          $whereClause = '';

          if (!empty($fechaDesde) && !empty($fechaHasta)) {
              $whereClause = "and u.fechaRegistro BETWEEN '$fechaDesde' AND '$fechaHasta'";
          }

          $consulta = "SELECT
          u.nombreCompleto AS nombre,
          CASE
              WHEN COUNT(pp.idPregunta) = 0 THEN 0
              ELSE (SUM(pp.correcta) / COUNT(pp.idPregunta)) * 100
          END AS porcentajeRespuestasCorrectas
      FROM
          usuario u
      LEFT JOIN
          partida p ON u.id = p.idUsuario
      LEFT JOIN
          partida_pregunta pp ON p.id = pp.idPartida
          where u.tipoUsuario = 'Jugador'
          $whereClause
      GROUP BY
          u.nombreCompleto";

          $query = $this->database->query($consulta);

          $cabecera = ['nombre', 'porcentajeRespuestasCorrectas'];

          return $this->convertirArrayAJSONPorcentajeRespuesta($query, $cabecera);
      }

      public function getUsuariosPorPaisFiltradoPorFecha($fechaDesde = null, $fechaHasta = null){
          $whereClause = '';

          if (!empty($fechaDesde && !empty($fechaHasta))) {
              $whereClause = "WHERE fechaRegistro BETWEEN '$fechaDesde' AND '$fechaHasta' ";
          }

          $consulta = "SELECT pais, COUNT(*) AS cantidad FROM usuario $whereClause GROUP BY pais";

          $query = $this->database->query($consulta);

          $cabecera = ['Pais', 'Cantidad'];

          return $this->convertirArrayAJSONPorPais($query, $cabecera);
      }

      public function getUsuariosPorPais()
      {
          $consulta = "SELECT pais, COUNT(*) AS cantidad FROM usuario  GROUP BY pais";

          $query = $this->database->query($consulta);

          $cabecera = ['Pais', 'Cantidad'];

          return $this->convertirArrayAJSONPorPais($query, $cabecera);
      }
      private function convertirArrayAJSONPorPais($queryResult, $cabecera) {
          $result = [];
          $result[] = $cabecera;

          if (is_array($queryResult)) {
              foreach ($queryResult as $row) {
                  $result[] = [$row['pais'], (float) $row['cantidad']];
              }
          } else {
              foreach ($queryResult->result_array() as $row) {
                  $result[] = [$row['pais'], (float) $row['cantidad']];
              }
          }

          return json_encode($result);
      }

      public function getUsuariosPorSexoFiltradoPorFechaYRol($fechaDesde = null, $fechaHasta = null)
      {
          $whereClause = '';

          if (!empty($fechaDesde && !empty($fechaHasta))) {
              $whereClause = "WHERE fechaRegistro BETWEEN '$fechaDesde' AND '$fechaHasta'";
              $whereClause .= "";
          }

          $consulta = "SELECT sexo, COUNT(*) AS cantidad FROM usuario $whereClause GROUP BY sexo";

          $query = $this->database->query($consulta);

          $cabecera = ['Sexo', 'Cantidad'];

          return $this->convertirArrayAJSONPorSexo($query, $cabecera);
      }

      public function getUsuariosPorSexoYRol($rol)
      {
          $consulta = "SELECT sexo, COUNT(*) AS cantidad FROM usuario WHERE tipoUsuario = $rol GROUP BY sexo";

          $query = $this->database->query($consulta);

          $cabecera = ['Sexo', 'Cantidad'];

          return $this->convertirArrayAJSON($query, $cabecera);
      }

      private function convertirArrayAJSONPorSexo($queryResult, $cabecera) {
          $result = [];
          $result[] = $cabecera;

          if (is_array($queryResult)) {
              foreach ($queryResult as $row) {
                  $result[] = [$row['sexo'], (float) $row['cantidad']];
              }
          } else {
              foreach ($queryResult->result_array() as $row) {
                  $result[] = [$row['sexo'], (float) $row['cantidad']];
              }
          }

          return json_encode($result);
      }

      public function getUsuariosPorEdadFiltradoPorFecha($fechaDesde = null, $fechaHasta = null)
      {
          $whereClause = '';

          if (!empty($fechaDesde && !empty($fechaHasta))) {
              $whereClause = "WHERE fechaRegistro BETWEEN '$fechaDesde' AND '$fechaHasta'";
          }

          $consulta = "SELECT CASE WHEN YEAR(CURDATE()) - anioNacimiento < 18 THEN 'Menores'
          WHEN YEAR(CURDATE()) - anioNacimiento BETWEEN 18 AND 60 THEN 'Mayores'
          WHEN YEAR(CURDATE()) - anioNacimiento > 60 THEN 'Jubilados'
          END AS Grupo, COUNT(*) AS Cantidad FROM usuario $whereClause GROUP BY Grupo";

          $query = $this->database->query($consulta);

          $cabecera = ['Grupo', 'Cantidad'];

          return $this->convertirArrayAJSONPorEdad($query, $cabecera);
      }

      public function getUsuariosPorEdad()
      {
          $consulta = "SELECT CASE WHEN YEAR(CURDATE()) - anioNacimiento < 18 THEN 'Menores'
          WHEN YEAR(CURDATE()) - anioNacimiento BETWEEN 18 AND 60 THEN 'Mayores'
          WHEN YEAR(CURDATE()) - anioNacimiento > 60 THEN 'Jubilados'
          END AS Grupo, COUNT(*) AS Cantidad FROM usuario GROUP BY Grupo";

          $query = $this->database->query($consulta);

          $cabecera = ['Grupo', 'Cantidad'];

          return $this->convertirArrayAJSONPorEdad($query, $cabecera);
      }

      private function convertirArrayAJSONPorEdad($queryResult, $cabecera) {
          $result = [];
          $result[] = $cabecera;

          if (is_array($queryResult)) {
              foreach ($queryResult as $row) {
                  $result[] = [$row['Grupo'], (float) $row['Cantidad']];
              }
          } else {
              foreach ($queryResult->result_array() as $row) {
                  $result[] = [$row['Grupo'], (float) $row['Cantidad']];
              }
          }

          return json_encode($result);
      }

      public function getUsuarioById($idUsuario)
      {
          $sql = "SELECT * FROM usuario WHERE id = '$idUsuario' LIMIT 1";
          $result = $this->database->query($sql);
          return $result[0];
      }*/
}