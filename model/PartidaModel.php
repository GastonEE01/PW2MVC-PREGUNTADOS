<?php

class PartidaModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function crearPartida($descripcion, $id_usuario)
    {
        $fechaInicio = date('Y-m-d H:i:s');
        $Status_ids = 1;
        $puntaje = 0;

        $sql = "INSERT INTO partida (Descripcion,Puntuacion,Puntuacion_porcentaje,Usuario_id,Fecha_creada,Fecha_finalizada) 
            VALUES ( ?, ?, ?, ? ,? ,?)";

        try {
            $result = $this->database->execute($sql, [ $descripcion, $puntaje, 0, $id_usuario, $fechaInicio, null]);
            return $result;
        } catch (PDOException $e) {
            error_log("Error al crear partida: " . $e->getMessage());
        }
    }

    public function buscarPorID($id)
    {
        $sql = "SELECT * FROM Partida WHERE ID=?";

        try {

            $result = $this->database->execute($sql, [$id]);
            return $result;
        } catch (PDOException $e) {
            error_log("Error al crear partida: " . $e->getMessage());
            // Maneja el error adecuadamente
        }
    }

    public function obtenerPartidasEnCurso($id_user)
    {
        $sql = "SELECT * FROM Partida WHERE Usuario_id=? AND Fecha_finalizada is null ";

        try {

            $result = $this->database->execute($sql, [$id_user]);
            return $result;
        } catch (PDOException $e) {
            error_log("Error al buscar las partidas: " . $e->getMessage());
            // Maneja el error adecuadamente
        }
    }

    public function obtenerPartidasFinalizada($id_user)
    {
        $sql = "SELECT * FROM Partida WHERE Usuario_id=? AND Fecha_finalizada is not null ";

        try {
            $result=$this->database->execute($sql,[$id_user]);
            return $result;
        } catch (PDOException $e) {
            error_log("Error al buscar las partidas: " . $e->getMessage());
            // Maneja el error adecuadamente
        }
    }

    public function trearMejoresPuntajesJugadores()
    {
        $sql = "SELECT 
        u.nombre_usuario,
         p.ID AS id_partida,
         p.Puntuacion,
        p.Puntuacion_porcentaje,
        p.Fecha_creada
        FROM 
        Usuario u
        JOIN 
        Partida p ON u.id = p.Usuario_id
        WHERE 
         p.Puntuacion = (
        SELECT MAX(p2.Puntuacion)
        FROM Partida p2
        WHERE p2.Usuario_id = u.id
    )
ORDER BY 
    p.Puntuacion DESC;
";
        try {

            $result = $this->database->execute($sql, []);
            return $result;
        } catch (PDOException $e) {
            error_log("Error al traer los datos: " . $e->getMessage());
            // Maneja el error adecuadamente
        }
    }

    public function obtenerCategoriaAlAzar()
    {
        $numRandom = rand(1, 6);
        $arrayRandom = [];
        array_push($arrayRandom, $numRandom);
        $sql = "SELECT categoria From Categoria where id=?";
        $result = $this->database->execute($sql, $arrayRandom);
        return $result;
    }

    public function verificarNivelDeUsuario($id)
    {
        $sql = "SELECT * FROM Usuario WHERE id=?";
        $result = $this->database->execute($sql, [$id]);
        if ($result != null) {
            $total_respuestas_correctas = $result[0]['total_respuestas_correctas'];
            $total_respuestas = $result[0]['total_respuestas'];
            $porcentajeDeAcierto = ($total_respuestas_correctas / $total_respuestas) * 100;
            if ($porcentajeDeAcierto >= 70) {
                return 3;
            } elseif ($porcentajeDeAcierto <= 30) {
                return 1;
            } else {
                return 2;
            }

        }
        return null;
    }

    public function buscarPregunta($categoria, $nivelDeUsuario)
    {
        $sql = "SELECT P.* FROM Pregunta P INNER JOIN Categoria C ON P.Categoria_id = C.ID
                WHERE C.Categoria =? and p.Dificultad= ?";


        $sql1 = "SELECT * FROM Pregunta P";
        $result = $this->database->execute($sql1, []);
        foreach ($result as $pregunta) { //en este for each actualizo la dificultad de cada pregunta de la base de datos
            $mostrada = $pregunta['mostrada'];
            $acertada = $pregunta['acertada'];
            $dificultad = ($acertada / $mostrada) * 100;

            if ($pregunta['ID'] != 7 &&
                $pregunta['ID'] != 8 &&
                $pregunta['ID'] != 9 &&
                $pregunta['ID'] != 10 &&
                $pregunta['ID'] != 17 &&
                $pregunta['ID'] != 18 &&
                $pregunta['ID'] != 19 &&
                $pregunta['ID'] != 20 &&
                $pregunta['ID'] != 27 &&
                $pregunta['ID'] != 28 &&
                $pregunta['ID'] != 29 &&
                $pregunta['ID'] != 30 &&
                $pregunta['ID'] != 37 &&
                $pregunta['ID'] != 38 &&
                $pregunta['ID'] != 39 &&
                $pregunta['ID'] != 40 &&
                $pregunta['ID'] != 47 &&
                $pregunta['ID'] != 48 &&
                $pregunta['ID'] != 49 &&
                $pregunta['ID'] != 50 &&
                $pregunta['ID'] != 57 &&
                $pregunta['ID'] != 58 &&
                $pregunta['ID'] != 59 &&
                $pregunta['ID'] != 60
            ) {


                if ($dificultad >= 70) {
                    $sql_actualizarDificultad = "UPDATE Pregunta
                SET Dificultad = 1
                WHERE ID = ?";
                    $this->database->execute($sql_actualizarDificultad, [$pregunta['ID']]);


                } elseif ($dificultad <= 30) {
                    $sql_actualizarDificultad = "UPDATE Pregunta
                SET Dificultad = 3
                WHERE ID = ?";
                    $this->database->execute($sql_actualizarDificultad, [$pregunta['ID']]);

                } else {
                    $sql_actualizarDificultad = "UPDATE Pregunta
                SET Dificultad = 2
                WHERE ID = ?";
                    $this->database->execute($sql_actualizarDificultad, [$pregunta['ID']]);
                }
            }
        }
        try {

            $result = $this->database->execute($sql, [$categoria, $nivelDeUsuario]);
            $min = 0; // Este debe ser el índice mínimo
            $max = count($result) - 1; // Este debe ser el índice máximo, ajustando según tu arreglo
            $randomIndex = rand($min, $max);

            return $result[$randomIndex];
        } catch (PDOException $e) {
            error_log("Error al crear partida: " . $e->getMessage());
            // Maneja el error adecuadamente
        }
    }

    public function traerRespuestasDePregunta($id)
    {
        $sql = "SELECT * FROM Respuesta WHERE pregunta_id=? ";

        try {

            // $stmt = $this->database->prepare($sql);
            $result = $this->database->execute($sql, [$id]);
            shuffle($result);
            return $result;
        } catch (PDOException $e) {
            error_log("Error al traer las respuestas: " . $e->getMessage());
            // Maneja el error adecuadamente
        }
    }

    public function verificarRespuesta($respuesta, $userID, $id_partida, $tiempo)
    {
        if($id_partida == null){
            echo "no se encontro id partida";
        }
        if ($tiempo == 0) {
            $sql1_buscaPregunta = "SELECT p.*
                        FROM Pregunta p
                        JOIN Respuesta r ON p.ID = r.Pregunta_id
                        WHERE r.Texto_respuesta = ?"; //busca pregunta que tenga como campo pregunta la respuesta que envio el usuario

            $pregunta = $this->database->execute($sql1_buscaPregunta, [$respuesta]);

            $sql_actualizaPreguntaErrada = "UPDATE Pregunta
                                            SET mostrada = mostrada + 1
                                            WHERE Pregunta=?"; //si no es acertada solo suma un punto en el campo mostrada

            $sql_ActualizarUsuario_respondeMal = "UPDATE Usuario
                                            SET total_respuestas =total_respuestas + 1
                                            WHERE id=?";

            $this->database->execute($sql_actualizaPreguntaErrada, [$pregunta[0]['Pregunta']]);
            $this->database->execute($sql_ActualizarUsuario_respondeMal, [$userID]);
            return null;
        }
        $sql = "SELECT * FROM Respuesta 
            WHERE Texto_respuesta = ?";

        $sql1_buscaPregunta = "SELECT p.*
                        FROM Pregunta p
                        JOIN Respuesta r ON p.ID = r.Pregunta_id
                        WHERE r.Texto_respuesta = ?"; //busca pregunta que tenga como campo pregunta la respuesta que envio el usuario
        try {
            $result = $this->database->execute($sql, [$respuesta]);
            $pregunta = $this->database->execute($sql1_buscaPregunta, [$respuesta]);
            if ($result && $result[0]['Es_correcta']) {

                $sql_actualizaPreguntaAcertada = "UPDATE Pregunta
                                            SET mostrada = mostrada + 1,
                                                acertada = acertada + 1
                                            WHERE Pregunta=?";// si la encuentra y es correcta actualiza los campo mostrada ya certada un punto mas

                $sql_ActualizarUsuario_respondeBien = "UPDATE Usuario
                                            SET total_respuestas_correctas = total_respuestas_correctas + 1,
                                                total_respuestas =total_respuestas + 1
                                            WHERE id=?";


                $sql = "UPDATE Partida SET puntuacion = puntuacion + 1 
                    WHERE Usuario_id = ? AND ID = ?";

                try {
                    $this->database->execute($sql, [$userID, $id_partida]);
                    $this->database->execute($sql_actualizaPreguntaAcertada, [$pregunta[0]['Pregunta']]);
                    $this->database->execute($sql_ActualizarUsuario_respondeBien, [$userID]);

                    return $result;
                } catch (PDOException $e) {
                    error_log("Error al actualizar el puntaje en la partida: " . $e->getMessage());
                    return null;
                }
            } else {
                $sql_actualizaPreguntaErrada = "UPDATE Pregunta
                                            SET mostrada = mostrada + 1
                                            WHERE Pregunta=?"; //si no es acertada solo suma un punto en el campo mostrada

                $sql_ActualizarUsuario_respondeMal = "UPDATE Usuario
                                            SET total_respuestas =total_respuestas + 1
                                            WHERE id=?";

                $this->database->execute($sql_actualizaPreguntaErrada, [$pregunta[0]['Pregunta']]);
                $this->database->execute($sql_ActualizarUsuario_respondeMal, [$userID]);

            }

            return null;
        } catch (PDOException $e) {
            error_log("Error al verificar respuesta: " . $e->getMessage());
            return null;
        }
    }

    public function actualizarPartida($idPartida)
    {
        $fechaFinalizada = date('Y-m-d H:i:s');
        $sql = "UPDATE partida 
                SET Fecha_finalizada  = ?
                WHERE ID = ?";
        $result =$this->database->execute($sql,[$fechaFinalizada,$idPartida]);
        return $result;
    }



    /*  public function iniciarPartidaConUsuario($idUsuario){
          $fecha_actual = date('Y-m-d H:i:s');
          $this->database->execute("INSERT INTO partida (idUsuario, fechaRealizado) VALUES ('$idUsuario', '$fecha_actual');");
      }

      public function getIdPartida($idUsuario){
          $this->iniciarPartidaConUsuario($idUsuario);
          $sql = "SELECT id FROM partida ORDER BY id DESC LIMIT 1;";
          $resultado= $this->database->query($sql);
          return $resultado[0]['id'];
      }

      public function getRespuestasByPregunta($preguntaID)
      {
          $sql = "SELECT * FROM respuesta AS r WHERE r.pregunta = '$preguntaID' ORDER BY RAND()";
          return $this->database->query($sql);
      }

      public function getPreguntaSinNivel($idUsuario)
      {
          $sql = "SELECT * FROM pregunta AS p
  WHERE estado = 'Activa'
  AND p.id NOT IN (
      SELECT pp.idPregunta
      FROM partida_pregunta AS pp
      JOIN partida AS pa ON pp.idPartida = pa.id
      WHERE pa.idUsuario = '$idUsuario'
  )
  LIMIT 1";
          $result= $this->database->query($sql);
          return $result;
      }

      public function getPreguntaConNivel($idUsuario, $nivel)
      {
          $sql = "SELECT * FROM pregunta AS p
              WHERE p.nivel = '$nivel' and estado = 'Activa'
              AND p.id NOT IN (
                  SELECT pp.idPregunta
                  FROM partida_pregunta AS pp
                  JOIN partida AS pa ON pp.idPartida = pa.id
                  WHERE pa.idUsuario = '$idUsuario'
              )
              LIMIT 1";
          return $this->database->query($sql);
      }

      public function getPreguntaParaUsuario($idUsuario)
      {
          $usuario = $this->getUsuarioById($idUsuario);
          $nivel = $usuario['nivel'];
          if($usuario['nivel'] !== null) {
              $result = $this->getPreguntaConNivel($idUsuario, $nivel);
              if (!$result) {
                  $sqlRandom = "SELECT * FROM pregunta WHERE estado = 'Activa' AND nivel = '$nivel' ORDER BY RAND() LIMIT 1";
                  return $this->database->query($sqlRandom);
              }
          }else{
              $result = $this->getPreguntaSinNivel($idUsuario);
              if (!$result) {
                  $sqlRandom = "SELECT * FROM pregunta WHERE estado = 'Activa' ORDER BY RAND() LIMIT 1";
                  return $this->database->query($sqlRandom);
              }
      }
          return $result;
      }

      public function guardarPreguntaDePartida($idUsuario, $idPartida,$idPregunta, $idRespuesta)
      {
          $this->marcarEntregaEnLaPregunta($idPregunta);
          if (empty($idRespuesta)) {
              $correcta = 0;
          } else {
              $correcta = $this->verificarRespuestaCorrecta($idPregunta ,$idRespuesta);
          }
          if ($correcta) {
              $this->sumarPuntajeAUsuario($idUsuario);
              $this->marcarHitEnLaPregunta($idPregunta);
          }
          $fecha_actual = date('Y-m-d H:i:s');
          $this->database->execute("INSERT INTO partida_pregunta (idPartida, idPregunta, fechaRealizado, correcta) VALUES ('$idPartida', '$idPregunta', '$fecha_actual', '$correcta')");
          $partidasTotalesPregunta = $this->partidasTotalesPorPregunta($idPregunta);
          if ($partidasTotalesPregunta >= 10) {
              $this->nivelarPregunta($idPregunta);
          }
          $partidasTotalesUsuario = $this->partidasTotalesPorUsuario($idUsuario);
          if ($partidasTotalesUsuario >= 10) {
              $this->nivelarUsuario($idUsuario);
          }
          return $correcta;
      }

      public function verificarRespuestaCorrecta($idPregunta, $idRespuesta)
      {
          $sql = "SELECT correcta FROM respuesta WHERE id = '$idRespuesta' AND pregunta = '$idPregunta'";
          $result = $this->database->query($sql);
          if ($result[0]['correcta'] == 1) {
              return 1;
          } else {
              return 0;
          }
      }

      private function sumarPuntajeAUsuario($idUsuario)
      {
          return $this->database->execute("UPDATE Usuario SET puntaje = puntaje + 1 WHERE id = '$idUsuario'");
      }

      public function getUsuarioById($idUsuario)
      {
          $sql = "SELECT * FROM usuario WHERE id = '$idUsuario' LIMIT 1";
          $result = $this->database->query($sql);
          return $result[0];
      }

      public function nivelarUsuario($idUsuario)
      {
          $sql = " SELECT SUM(CASE WHEN pp.correcta = 1 THEN 1 ELSE 0 END) AS correctas
          FROM partida p
          INNER JOIN partida_pregunta pp ON p.id = pp.idPartida
          WHERE p.idUsuario = '$idUsuario'
          ORDER BY p.id DESC
          LIMIT 10";

          $result = $this->database->query($sql);
          if (count($result) > 0) {
              $correctas = $result[0]['correctas'];
              $nivel = 'Facil';

              if ($correctas >= 7) {
                  $nivel = 'Dificil';
              } else if ($correctas >= 4) {
                  $nivel = 'Intermedio';
              }

              $sqlUpdate = "UPDATE usuario SET nivel = '$nivel' WHERE id = '$idUsuario'";
              $this->database->execute($sqlUpdate);
          }
      }

      public function nivelarPregunta($idPregunta)
      {
          $porcentajeHits = $this->obtenerPorcentajeDeHits($idPregunta);
          $porcentajeFinal = $porcentajeHits;
          $nivel = 'Dificil';

          if ($porcentajeFinal > '66.6') {
              $nivel = 'Facil';
          } else if ($porcentajeFinal > 33.3 and $porcentajeFinal <= 66.6) {
              $nivel = 'Intermedio';
          }

          $sqlUpdate = "UPDATE pregunta SET nivel = '$nivel' WHERE id = '$idPregunta'";
          $this->database->execute($sqlUpdate);
      }

      private function obtenerPorcentajeDeHits($idPregunta)
      {
          $sql = "
          SELECT
              CASE
                  WHEN veces_entregada IS NULL OR veces_entregada < 10 THEN NULL
                  ELSE (COALESCE(hits, 0) / veces_entregada) * 100
              END AS porcentajeHits
          FROM pregunta
          WHERE id = '$idPregunta'
      ";

          $result = $this->database->query($sql);
          if (count($result) > 0) {
              return $result[0]['porcentajeHits'];
          } else {
              return 0;
          }
      }

      public function partidasTotalesPorUsuario($idUsuario)
      {
          $sql = " SELECT COUNT(*) AS preguntasTotales
          FROM partida_pregunta pp
          JOIN partida p ON pp.idPartida = p.id
          WHERE p.idUsuario = '$idUsuario'";
          $result= $this->database->query($sql);
          return $result[0]['preguntasTotales'];
      }

      public function partidasTotalesPorPregunta($idPregunta)
      {
          $sql = "SELECT veces_entregada FROM pregunta WHERE id = '$idPregunta'";
          $result= $this->database->query($sql);
          return $result[0]['veces_entregada'];
      }

      public function marcarHitEnLaPregunta($idPregunta)
      {
          $sql = "UPDATE pregunta SET hits = hits + 1 WHERE id = '$idPregunta'";
          $this->database->execute($sql);
      }

      public function marcarEntregaEnLaPregunta($idPregunta)
      {
          $sql = "UPDATE pregunta SET veces_entregada = veces_entregada + 1 WHERE id = '$idPregunta'";
          $this->database->execute($sql);
      }

      public function colorDeCategoria($categoria){
          $sql = "SELECT color FROM categoria_color WHERE categoria = '$categoria'";
          $result= $this->database->query($sql);
          return $result[0]['color'];
      }

      public function reportarPreguntaPorId($idPregunta){
          $sql = "UPDATE pregunta SET estado = 'Reportada' WHERE id = '$idPregunta'";
          $this->database->execute($sql);
      }
  */
}

?>
