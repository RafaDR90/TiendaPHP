<?php
namespace service;
use repository\CategoriaRepository;

class CategoriaService{
    private $categoriaRepository;
    public function __construct()
    {
        $this->categoriaRepository=new CategoriaRepository();
    }

    public function getAll(){
        return $this->categoriaRepository->getAll();
    }
    public function borrarCategoriaPorId(int $id){
        $this->categoriaRepository->borrarCategoriaPorId($id);
    }
    public function obtenerCategoriaPorID(int $id){
        return $this->categoriaRepository->obtenerCategoriaPorID($id);
    }
    public function update($categoria){
        return $this->categoriaRepository->update($categoria);
    }
    public function create($categoria){
        return $this->categoriaRepository->create($categoria);
    }
}