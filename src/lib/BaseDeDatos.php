<?php

namespace lib;
use PDO;
class BaseDeDatos {
    private  $conexion;
    private mixed $resultado;

    private string $servidor ;
    private string $usuario ;
    private string $pass ;
    private string $base_datos;
    function __construct()
    {
        $this->servidor = $_ENV['DB_HOST'];
        $this->usuario = $_ENV['DB_USER'];
        $this->pass = $_ENV['DB_PASS'];
        $this->base_datos = $_ENV['DB_DATABASE'];
        $this->conexion=$this->conectar();
    }
    function conectar() : PDO {
        try {
            $opciones = array(
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4",
                PDO::MYSQL_ATTR_FOUND_ROWS => true
            );
            $conexion = new PDO("mysql:host={$this->servidor};dbname={$this->base_datos}",$this->usuario,$this->pass,$opciones);
            return $conexion;
        } catch (PDOException $e) {
            echo "Ha surgido un error y no se puede conectar con la base de datos".$e->getMessage();
            exit;
        }
    }

    /**
     * ejecuta una consulta SQL
     * @param string $consultaSQL
     * @return void
     */
    public function consulta(string $consultaSQL): void{
        $this->resultado=$this->conexion->query($consultaSQL);
    }

    /**
     * extrae todos los registros de la consulta SQL
     * @return mixed
     */
    public function extraer_todos(): mixed{
        return $this->resultado->fetchAll(PDO::FETCH_ASSOC);

    }

    /**
     * extrae un registro de la consulta SQL
     * @return mixed
     */
    public function extraer_registro(): mixed{
        return ($fila=$this->resultado->fetch(PDO::FETCH_ASSOC))? $fila:false;
    }

    /**
     * hace un prepare de la consulta SQL
     * @param string $querySQL
     * @return false|\PDOStatement
     */
    public function prepara(string $querySQL) {
        return $this->conexion->prepare($querySQL);
    }

    /**
     * devuelve la cantidad de filas afectadas por la última sentencia SQL
     * @return int
     */
    public function filasAfectadas(): int{
        return $this->resultado->rowCount();
    }

    public function cierraConexion(){
        $this->conexion=null;
    }

    /**
     * Inicia una transacción en la base de datos.
     */
    public function beginTransaction() {
        $this->conexion->beginTransaction();
    }

    /**
     * Confirma una transacción en la base de datos, haciendo permanentes los cambios.
     */
    public function commit() {
        $this->conexion->commit();
    }

    /**
     * Revierte una transacción en la base de datos, deshaciendo los cambios.
     */
    public function rollBack() {
        $this->conexion->rollBack();
    }
    public function query(string $sql,array $parametros=[]): void{
        $this->resultado=$this->conexion->prepare($sql);
        $this->resultado->execute($parametros);
    }
}