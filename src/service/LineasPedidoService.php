<?php
namespace service;
use repository\LineasPedidoRepository;

class LineasPedidoService{
    private $lineasPedidoRepository;
    public function __construct()
    {
        $this->lineasPedidoRepository=new LineasPedidoRepository();
    }
    public function create($id,$pedidoId,$unidades){
        return $this->lineasPedidoRepository->create($id,$pedidoId,$unidades);
    }
}