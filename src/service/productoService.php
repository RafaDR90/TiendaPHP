<?php
namespace service;
use repository\productoRepository;
class productoService{
    private $productoRepository;
    public function __construct()
    {
        $this->productoRepository=new productoRepository();
    }

    public function addProducto($producto){
        return $this->productoRepository->addProducto($producto);
    }
    public function productosPorCategoria($id){
        return $this->productoRepository->productosPorCategoria($id);
    }
    public function productosPorCategoriaNotDeleted($id){
        return $this->productoRepository->productosPorCategoriaNotDeleted($id);
    }

    public function eliminarProducto($id){
        return $this->productoRepository->eliminarProducto($id);
    }
    public function obtenerNombreImagen($id){
        return $this->productoRepository->obtenerNombreImagen($id);
    }

    public function getProductoByIdProducto($id){
        return $this->productoRepository->getProductoByIdProducto($id);
    }
    public function editarProducto($id,$producto){
        return $this->productoRepository->editarProducto($id,$producto);
    }

    public function editarImagenProducto($id,$imagen){
        return $this->productoRepository->editarImagenProducto($id,$imagen);
    }
    public function restarStock($id,$unidades){
        return $this->productoRepository->restarStock($id,$unidades);
    }

    public function productosDescatalogados(){
        return $this->productoRepository->productosDescatalogados();
    }
    public function productosEliminados(){
        return $this->productoRepository->productosEliminados();
    }
}