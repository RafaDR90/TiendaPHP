<?php
namespace repository;
use lib\BaseDeDatos,
    PDO,
    PDOException;
class lineasPedidoRepository{
    private $db;
    public function __construct()
    {
        $this->db=new BaseDeDatos();
    }

    /**
     * Crea una nueva línea de pedido.
     * @param $id
     * @param $pedidoId
     * @param $unidades
     * @return string|null Devuelve null si la operación es exitosa, o un mensaje de error en caso de excepción.
     */
    public function create($id, $pedidoId, $unidades){
        $error = null;
        $this->db=new BaseDeDatos();
        try {
            $ins = $this->db->prepara("INSERT INTO lineas_pedidos (producto_id, pedido_id, unidades) VALUES (:producto_id, :pedido_id, :unidades)");
            $ins->bindValue(':producto_id', $id);
            $ins->bindValue(':pedido_id', $pedidoId);
            $ins->bindValue(':unidades', $unidades);
            $ins->execute();
        } catch (PDOException $e) {
            $error = $e->getMessage();
        } finally {
            $ins->closeCursor();
            $this->db->cierraConexion();
            return $error;
        }
    }
}