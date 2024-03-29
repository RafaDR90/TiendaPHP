<?php
namespace models;


class Categoria{
    private ?int $id;
    private string $nombre;



    public function __construct(?int $id=null, string $nombre='')
    {
        $this->id=$id;
        $this->nombre=$nombre;

    }

    /**
     * Transforma un array en un array de objetos categoria
     * @param array $data array con los datos a transformar
     * @return array
     */
    public static function fromArray(array $data):array
    {
        $categorias=[];
        foreach ($data as $dt) {
            $categoria = new categoria(
                $dt['id'] ?? null,
                $dt['nombre'] ?? '',
            );
            $categorias[]=$categoria;
        }
        return $categorias;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param mixed $nombre
     */
    public function setNombre($nombre): void
    {
        $this->nombre = $nombre;
    }

}