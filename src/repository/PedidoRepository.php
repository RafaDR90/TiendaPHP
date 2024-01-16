<?php
namespace repository;
use lib\BaseDeDatos,
    PDO,
    PDOException;
class PedidoRepository{
    private $db;
    public function __construct()
    {
        $this->db=new BaseDeDatos();
    }

    /**
     * Crea un nuevo pedido.
     * @param $datos
     * @return string|null Devuelve null si la operación es exitosa, o un mensaje de error en caso de excepción.
     */
    public function create($datos):?string{
        $error = null;

        $fechaHora = explode(" ", $datos['fecha']);
        $fecha = $fechaHora[0];
        $hora = $fechaHora[1];

        try {
            $ins = $this->db->prepara("INSERT INTO pedidos (usuario_id, coste, estado, fecha, hora) VALUES (:usuario_id, :coste, :estado, :fecha, :hora)");
            $ins->bindValue(':usuario_id', $datos['idUsuario']);
            $ins->bindValue(':coste', $datos['coste']);
            $ins->bindValue(':estado', $datos['estado']);
            $ins->bindValue(':fecha', $fecha);
            $ins->bindValue(':hora', $hora);
            $ins->execute();
        } catch (PDOException $e) {
            $error = $e->getMessage();
        } finally {
            $ins->closeCursor();
            $this->db->cierraConexion();
            return $error;
        }
    }

    /**
     * Obtiene el ID del último pedido.
     * @return mixed|string|null Devuelve el ID del último pedido, o un mensaje de error en caso de excepción.
     */
    public function getIdUltimoPedido():mixed{
        $id = null;
        $this->db=new BaseDeDatos();
        try {
            $sel = $this->db->prepara("SELECT MAX(id) FROM pedidos");
            $sel->execute();
            $id = $sel->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $error = $e->getMessage();
        } finally {
            $sel->closeCursor();
            $this->db->cierraConexion();
            if (isset($error))
                return $error;
            return $id;
        }
    }

    /**
     * Obtiene todos los pedidos de un usuario por su id.
     * @param $id
     * @return array|false|string
     */
    public function getPedidosPorId($id){
        $pedidos = null;
        $this->db=new BaseDeDatos();
        try {
            $sel = $this->db->prepara("SELECT * FROM pedidos WHERE usuario_id = :id");
            $sel->bindValue(':id', $id);
            $sel->execute();
            $pedidos = $sel->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $pedidos = $e->getMessage();
        } finally {
            $sel->closeCursor();
            $this->db->cierraConexion();
            return $pedidos;
        }
    }

    /**
     * Obtiene todos los items de un pedido por su id.
     * @param $id
     * @return array|false|string
     */
    public function getItemsPorId($id){
        $items = null;
        $this->db=new BaseDeDatos();
        try {
            $sel = $this->db->prepara("SELECT * FROM lineas_pedidos WHERE pedido_id = :id");
            $sel->bindValue(':id', $id);
            $sel->execute();
            $items = $sel->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $items = $e->getMessage();
        } finally {
            $sel->closeCursor();
            $this->db->cierraConexion();

            return $items;
        }
    }
}