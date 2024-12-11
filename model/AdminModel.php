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

    public function cantidadDePreguntaPorCategoria()
    {
        $categoriasOrdenadas = ['Arte', 'Cine', 'Deporte', 'Historia', 'Ciencia', 'Geografía'];
        $cantidadPreguntas = [];

        // Preparar la consulta SQL para contar preguntas por categoría
        $sql = "SELECT Categoria.Categoria, COUNT(Pregunta.ID) AS TotalPreguntas
            FROM Pregunta
            INNER JOIN Categoria ON Pregunta.Categoria_id = Categoria.ID
            GROUP BY Categoria.Categoria";

        $result = $this->database->execute($sql);

        foreach ($categoriasOrdenadas as $categoria) {
            $cantidadPreguntas[$categoria] = 0;
        }

        // Llenar el array con los resultados de la consulta
        foreach ($result as $row) {
            $categoria = $row['Categoria'];
            if (in_array($categoria, $categoriasOrdenadas)) {
                $cantidadPreguntas[$categoria] = (int)$row['TotalPreguntas'];
            }
        }
        return array_values($cantidadPreguntas);
    }


    public function cantidadDePreguntaCorrectaPorCategoria() {
        $sql = "SELECT 
                c.Categoria,
                COUNT(DISTINCT CASE WHEN p.acertada = 1 THEN p.ID END) AS TotalPreguntasCorrectas
            FROM 
                Categoria c
            JOIN 
                Pregunta p ON c.ID = p.Categoria_id
            GROUP BY 
                c.Categoria";

        $result = $this->database->execute($sql, []);
        $data = [];
        $categoriasOrdenadas = ['Arte', 'Cine', 'Historia', 'Deporte', 'Ciencia', 'Geografía'];

        foreach ($categoriasOrdenadas as $categoria) {
            $data[$categoria] = 0; // Inicializar con 0 por si no hay registros
        }

        foreach ($result as $row) {
            $data[$row['Categoria']] = $row['TotalPreguntasCorrectas'];
        }

        return $data;
    }

    public function cantidadDePreguntaIncorrectaPorCategoria()
    {

        $sql = "SELECT * FROM Pregunta ";

        $result = $this->database->execute($sql, []);

        $preguntaArte = [];
        $preguntaCine = [];
        $preguntaDeporte = [];
        $preguntaHistoria = [];
        $preguntaCiencia = [];
        $preguntaGeografia = [];
        foreach ($result as $respuestas) {
            switch ($respuestas['Categoria_id']) {
                case 1:
                    array_push($preguntaArte,$respuestas) ;
                    break;
                case 2:
                    array_push($preguntaCine,$respuestas) ;
                    break;
                case 3:
                    array_push($preguntaDeporte,$respuestas) ;
                    break;
                case 4:
                    array_push($preguntaHistoria,$respuestas) ;
                    break;
                case 5:
                    array_push($preguntaCiencia,$respuestas) ;
                    break;
                case 6:
                    array_push($preguntaGeografia,$respuestas) ;
                    break;
            }
        }

        $artePorcentajeIncorrecto = $this->porcentajeDePreguntaIncorrectaCategoria($preguntaArte);
        $cinePorcentajeIncorrecto = $this->porcentajeDePreguntaIncorrectaCategoria($preguntaCine);
        $deportePorcentajeIncorrecto = $this->porcentajeDePreguntaIncorrectaCategoria($preguntaDeporte);
        $historiaPorcentajeIncorrecto = $this->porcentajeDePreguntaIncorrectaCategoria($preguntaHistoria);
        $cienciaPorcentajeIncorrecto = $this->porcentajeDePreguntaIncorrectaCategoria($preguntaCiencia);
        $geografiaPorcentajeIncorrecto = $this->porcentajeDePreguntaIncorrectaCategoria($preguntaGeografia);
        $totalPorcentajeIncorrectoCategoria = [$artePorcentajeIncorrecto, $cinePorcentajeIncorrecto, $deportePorcentajeIncorrecto, $historiaPorcentajeIncorrecto, $cienciaPorcentajeIncorrecto, $geografiaPorcentajeIncorrecto];
        return $totalPorcentajeIncorrectoCategoria;

        /* $sql = "SELECT
                c.Categoria,
                COUNT(DISTINCT CASE WHEN p.acertada = 0 THEN p.ID END) AS TotalPreguntasIncorrectas
            FROM
                Categoria c
            JOIN
                Pregunta p ON c.ID = p.Categoria_id
            GROUP BY
                c.Categoria";

        $result = $this->database->execute($sql, []);
        $data = [];
        $categoriasOrdenadas = ['Arte', 'Cine', 'Historia', 'Deporte', 'Ciencia', 'Geografía'];

        foreach ($categoriasOrdenadas as $categoria) {
            $data[$categoria] = 0; // Inicializar con 0 por si no hay registros
        }

        foreach ($result as $row) {
            $data[$row['Categoria']] = $row['TotalPreguntasIncorrectas'];
        }

        return $data;*/
    }
    private function porcentajeDePreguntaIncorrectaCategoria($listaPreguntaCategoria)
    {
        $correctas=0;
        $incorrectas=0;
        foreach ($listaPreguntaCategoria as $respuestas){
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

    public function cantidadDePreguntasPorDificultadYCategoria() {
        $sql = "SELECT 
                c.Categoria,
                p.Dificultad,
                COUNT(*) AS TotalPreguntas
            FROM 
                Pregunta p
            JOIN 
                Categoria c ON p.Categoria_id = c.ID
            WHERE 
                p.mostrada = 1
            GROUP BY 
                c.Categoria, p.Dificultad";

        $result = $this->database->execute($sql, []);
        $data = [];

        // Inicializar el array para cada categoría y dificultad
        $categoriasOrdenadas = ['Arte', 'Cine', 'Historia', 'Deporte', 'Ciencia', 'Geografía'];
        foreach ($categoriasOrdenadas as $categoria) {
            $data[$categoria] = [
                1 => 0, // Dificultad fácil
                2 => 0, // Dificultad normal
                3 => 0  // Dificultad difícil
            ];
        }

        // Llenar el array con los datos de la consulta
        foreach ($result as $row) {
            $categoria = $row['Categoria'];
            $dificultad = $row['Dificultad'];
            $data[$categoria][$dificultad] = $row['TotalPreguntas'];
        }

        return $data;
    }



}