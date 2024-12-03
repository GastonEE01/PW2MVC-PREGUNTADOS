<?php

class EditorModel
{

    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function modificarPreguntaSugerida($pregunta, $opcionA, $opcionB, $opcionC, $opcionD, $opcionCorrecta, $categoria,$idUsuario,$ID) {
        $sql = "UPDATE Sugerencia 
        SET Pregunta = ?, OpcionA = ?, OpcionB = ?, OpcionC = ?, OpcionD = ?, OpcionCorrecta = ?, Categoria = ?, Usuario_id = ?
        WHERE ID = ?";



        return $this->database->execute($sql, [

            $pregunta,
            $opcionA,
            $opcionB,
            $opcionC,
            $opcionD,
            $opcionCorrecta,
            $categoria,
            $idUsuario,
            $ID
        ]);
    }

    public function agregarPregunta($pregunta, $opcionA, $opcionB, $opcionC, $opcionD, $opcionCorrecta, $categoria)
    {
        // Obtener id de categoria
        $idCategoria = $this->obtenerCategoria($categoria); // Llama a obtenerCategoria usando $this

        // agregar pregunta
        $sqlPregunta = "INSERT INTO Pregunta (Pregunta, Dificultad, Categoria_id,mostrada,acertada) VALUES (?, ?, ?,?,?)";
        $dificultad = 1; // Nivel de dificultad predeterminado
        $this->database->execute($sqlPregunta, [$pregunta, $dificultad, $idCategoria,1,1]);

        // Obtener el ID de la última pregunta insertada
        $sqlLastInsertId = "SELECT ID FROM Pregunta ORDER BY ID DESC LIMIT 1    ";
        $result = $this->database->execute($sqlLastInsertId,[]);

        if (count($result) > 0) {
            $preguntaId = $result[0]['ID'];
        } else {
            throw new Exception("No se pudo obtener el ID de la última pregunta.");
        }
        switch ($opcionCorrecta){
            case "A" :
                $this->insertarRespuesta($opcionA, 1, $preguntaId);
                $this->insertarRespuesta($opcionB, 0, $preguntaId);
                $this->insertarRespuesta($opcionC, 0, $preguntaId);
                $this->insertarRespuesta($opcionD, 0, $preguntaId);
                break;
            case "B":
                $this->insertarRespuesta($opcionA, 0, $preguntaId);
                $this->insertarRespuesta($opcionB, 1, $preguntaId);
                $this->insertarRespuesta($opcionC, 0, $preguntaId);
                $this->insertarRespuesta($opcionD, 0, $preguntaId);
                break;
            case "C":
                $this->insertarRespuesta($opcionA, 0, $preguntaId);
                $this->insertarRespuesta($opcionB, 0, $preguntaId);
                $this->insertarRespuesta($opcionC, 1, $preguntaId);
                $this->insertarRespuesta($opcionD, 0, $preguntaId);
                Break;
            case "D":
                $this->insertarRespuesta($opcionA, 0, $preguntaId);
                $this->insertarRespuesta($opcionB, 0, $preguntaId);
                $this->insertarRespuesta($opcionC, 0, $preguntaId);
                $this->insertarRespuesta($opcionD, 1, $preguntaId);
                Break;
            default:

                break;
        }
    }

    public function obtenerCategoria($categoria)
    {

        switch ($categoria) {
            case "Arte" :
                return 1;
                break;
            case "Cine":
                return 2;
                break;
            case "Deportes":
                return 3;
                break;
            case "Historia":
                return 4;
                break;
            case "Ciencia":
                return 5;
                break;
            case "Geografía":
                return 6;
                break;
            default:
                break;
        }

    }

    private function insertarRespuesta($respuesta, $esCorrecta, $preguntaId)
    {
        $sqlRespuesta = "INSERT INTO respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES (?, ?, ?)";
        $this->database->execute($sqlRespuesta, [$respuesta, $esCorrecta, $preguntaId]);
    }
    public function eliminarPregunta($id){
        $sql = "DELETE FROM sugerencia WHERE ID = ?";
        $this->database->execute($sql, [$id]);
    }

    public function eliminarReporte($idReporte){
        $sql = "DELETE FROM reporte WHERE ID = ?";
        $this->database->execute($sql, [$idReporte]);
    }

    public function eliminarRespuestas($idPregunta) {
        $sql = "DELETE FROM respuesta WHERE Pregunta_id = ?";
        $this->database->execute($sql, [$idPregunta]);
    }
    public function eliminarPreguntaRe($idPregunta){
        $sql = "DELETE FROM pregunta WHERE ID = ?";
        $this->database->execute($sql, [$idPregunta]);
    }
    public function eliminarReporteRelacionado($idPregunta) {
        $sql = "DELETE FROM reporte WHERE Pregunta_id = ?";
        $this->database->execute($sql, [$idPregunta]);
    }




/*
    public function agregarPregunta($categoria, $pregunta, $rtaCorrecta, $opcion2, $opcion3, $opcion4, $estado,$dificultad)
    {
        $insertPregunta = "INSERT INTO pregunta (`categoria`, `pregunta`, `estado`, `nivel`, `veces_entregada`, `hits`, `fechaRealizado`) VALUES ('$categoria', '$pregunta', '$estado', '$dificultad' ,0 , 0, NOW())";
        $this->database->execute($insertPregunta);
        $preguntaId = mysqli_insert_id($this->database->getConnection());

        $insertRespuestas = "INSERT INTO respuesta (`respuesta`, `correcta`, `pregunta`) VALUES ('$rtaCorrecta', true, '$preguntaId'), ('$opcion2', false, '$preguntaId'), ('$opcion3', false, '$preguntaId'), ('$opcion4', false, '$preguntaId')";
        $this->database->execute($insertRespuestas);
    }

    public function editarPregunta($idPregunta, $categoria, $pregunta, $rtaCorrecta, $opcion2, $opcion3, $opcion4)
    {
        $updatePregunta = "UPDATE pregunta SET `categoria` = '$categoria', `pregunta` = '$pregunta', `fechaRealizado` = NOW() WHERE `id` = '$idPregunta'";
        $this->database->execute($updatePregunta);

        $selectRespuestas = "SELECT id FROM respuesta WHERE pregunta = '$idPregunta'";
        $respuestas = $this->database->query($selectRespuestas);
        $respuestaIds = array_column($respuestas, 'id');
        $updateRespuestas = [
            "UPDATE respuesta SET `respuesta` = '$rtaCorrecta', `correcta` = 1 WHERE `id` = '{$respuestaIds[0]}'",
            "UPDATE respuesta SET `respuesta` = '$opcion2', `correcta` = 0 WHERE `id` = '{$respuestaIds[1]}'",
            "UPDATE respuesta SET `respuesta` = '$opcion3', `correcta` = 0 WHERE `id` = '{$respuestaIds[2]}'",
            "UPDATE respuesta SET `respuesta` = '$opcion4', `correcta` = 0 WHERE `id` = '{$respuestaIds[3]}'"
        ];

        foreach ($updateRespuestas as $updateQuery) {
            $this->database->execute($updateQuery);
        }
    }

    public function eliminarPregunta($idPregunta)
    {
        try {
            $selectPregunta = "SELECT 1 FROM pregunta WHERE id = '$idPregunta' LIMIT 1";
            $pregunta = $this->database->query($selectPregunta);

            if (count($pregunta) == 1) {
                $deleteRespuestas = "DELETE FROM respuesta WHERE pregunta = '$idPregunta'";
                $this->database->execute($deleteRespuestas);

                $deletePregunta = "DELETE FROM pregunta WHERE id = '$idPregunta'";
                $this->database->execute($deletePregunta);
            }
        } catch (Exception $e) {
            $this->database->rollback();
        }
    }

    public function cambiarEstadoPregunta($idPregunta)
    {
        $query = "SELECT estado FROM pregunta WHERE id = '$idPregunta' LIMIT 1";
        $result = $this->database->query($query);

        if ($result[0]['estado'] == 'Inactiva') {
            $this->database->execute("UPDATE pregunta SET estado = 'Activa' WHERE id = '$idPregunta'");
        } else {
            $this->database->execute("UPDATE pregunta SET estado = 'Inactiva' WHERE id = '$idPregunta'");
        }
    }

    public function obtenerPreguntaConRespuestas($idPregunta)
    {
        $sqlPregunta = "SELECT * FROM pregunta WHERE id = '$idPregunta'";
        $pregunta = $this->database->query($sqlPregunta);

        $sqlRespuestas = "SELECT respuesta FROM respuesta WHERE pregunta = '$idPregunta'";
        $respuestas = $this->database->query($sqlRespuestas);

        return [
            'pregunta' => $pregunta[0],
            'correcta' => $respuestas[0]['respuesta'],
            'opcion2' => $respuestas[1]['respuesta'],
            'opcion3' => $respuestas[2]['respuesta'],
            'opcion4' => $respuestas[3]['respuesta'],
        ];
    }

    public function getPreguntasEditor()
    {
        $sql = "SELECT * FROM pregunta";
        return $this->database->query($sql);
    }

    public function getPreguntasEditorSugeridas()
    {
        $sql = "SELECT * FROM pregunta where estado ='Sugerida'";
        return $this->database->query($sql);
    }

    public function getPreguntasEditorReportadas()
    {
        $sql = "SELECT * FROM pregunta where estado ='Reportada'";
        return $this->database->query($sql);
    }

    public function getUsuarioById($idUsuario)
    {
        $sql = "SELECT * FROM usuario WHERE id = '$idUsuario' LIMIT 1";
        $result = $this->database->query($sql);
        return $result[0];
    }
*/

}

?>
