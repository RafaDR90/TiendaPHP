<?php
namespace service;
use repository\PedidoRepository;
class PedidoService{
    private $pedidoRepository;
    public function __construct()
    {
        $this->pedidoRepository=new PedidoRepository();
    }
    public function create($pedido){
        return $this->pedidoRepository->create($pedido);
    }
    public function getIdUltimoPedido(){
        return $this->pedidoRepository->getIdUltimoPedido();
    }
    public function getPedidosPorId($id){
        return $this->pedidoRepository->getPedidosPorId($id);
    }
    public function getItemsPorId($id){
        return $this->pedidoRepository->getItemsPorId($id);
    }
    public function getPedidosPorEstado($estado){
        return $this->pedidoRepository->getPedidosPorEstado($estado);
    }
    public function cambiarEstadoPedido($id,$estado){
        return $this->pedidoRepository->cambiarEstadoPedido($id,$estado);
    }
}