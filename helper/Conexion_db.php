<?php

class Database
{
    private $conn;

    public function __construct($servername, $username, $password, $dbname)
    {
        $this->conn = mysqli_connect($servername, $username, $password, $dbname);

        if (!$this -> conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
    }

    public function getConnection() {
        return $this->conn;
    }

    public function query($sql){
        $result = mysqli_query($this -> conn, $sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function queryNotAll($sql){
        return mysqli_query($this -> conn, $sql);
    }

    public function execute($sql, $params = []) {
        $stmt = mysqli_prepare($this->conn, $sql);

        if ($stmt === false) {
            throw new mysqli_sql_exception(mysqli_error($this->conn));
        }

        // Vincular los parámetros
        if (!empty($params)) {
            $types = '';
            foreach ($params as $param) {
                $types .= is_int($param) ? 'i' : 's';
            }
            mysqli_stmt_bind_param($stmt, $types, ...$params);
        }

        // Ejecutar la consulta
        $result = mysqli_stmt_execute($stmt);

        if ($result === false) {
            mysqli_stmt_close($stmt);
            throw new mysqli_sql_exception(mysqli_error($this->conn));
        }
        if (stripos($sql, 'SELECT') === 0) {
            // Obtener el resultado de la consulta
            $resultSet = mysqli_stmt_get_result($stmt);
            $data = mysqli_fetch_all($resultSet, MYSQLI_ASSOC);
            mysqli_free_result($resultSet);
            mysqli_stmt_close($stmt);
            return $data;
        } else {
            // Para consultas que no son SELECT
            $affectedRows = mysqli_stmt_affected_rows($stmt);
            $insertedId = mysqli_insert_id($this->conn);
            mysqli_stmt_close($stmt);

            return [
                'affected_rows' => $affectedRows,
                'user_id' => $insertedId
            ];
        }
    }

    public function __destruct()
    {
        mysqli_close($this -> conn);
    }

    public function rollback() {
        mysqli_rollback($this->conn);
    }
    public function print($sql)
    {
        $result = mysqli_query($this->conn, $sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

}