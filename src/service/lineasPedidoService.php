<?php
namespace service;
use repository\lineasPedidoRepository;

class lineasPedidoService{
    private $lineasPedidoRepository;
    public function __construct()
    {
        $this->lineasPedidoRepository=new lineasPedidoRepository();
    }
    public function create($id,$pedidoId,$unidades){
        return $this->lineasPedidoRepository->create($id,$pedidoId,$unidades);
    }
}