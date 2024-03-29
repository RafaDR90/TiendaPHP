<?php
namespace models;
use utils\ValidationUtils;

class Producto{
    private ?int $id;
    private ?int $categoria_id;
    private string $nombre;
    private string $descripcion;
    private float $precio;
    private int $stock;
    private bool $oferta;
    private string $fecha;
    private string $imagen;
    private bool $deleted;



    public function __construct(?int $id=null, int $categoria_id=null, string $nombre='', string $descripcion='', float $precio=0, int $stock=0, bool $oferta=false, string $fecha='', string $imagen='',bool $deleted=false)
    {
        $this->id=$id;
        $this->categoria_id=$categoria_id;
        $this->nombre=$nombre;
        $this->descripcion=$descripcion;
        $this->precio=$precio;
        $this->stock=$stock;
        $this->oferta=$oferta;
        $this->fecha=$fecha;
        $this->imagen=$imagen;
        $this->deleted=$deleted;
    }

    /**
     * Transforma un array en un array de objetos producto
     * @param array $array array con los datos a transformar
     * @return array
     */
    public static function fromArray(array $array): array
    {
        $productos=[];
        foreach ($array as $producto){
            $productos[]=new producto(
                $producto['id']??null,
                $producto['categoria_id']??null,
                $producto['nombre']??'',
                $producto['descripcion']??'',
                $producto['precio']??0,
                $producto['stock']??0,
                $producto['oferta']??false,
                $producto['fecha']??'',
                $producto['imagen']??'',
                $producto['deleted']??false);
        }
        return $productos;
    }

    /**
     * Sanea y valida los datos de un producto
     * @param array $producto array con los datos a sanear y validar
     * @return array|string con los datos saneados y validados o un mensaje de error
     */
    public function saneaYvalidaProducto(array $producto): array|string{

        $nombre=ValidationUtils::sanidarStringFiltro($producto['nombre']);
        $descripcion=ValidationUtils::sanidarStringFiltro($producto['descripcion']);
        $precio=ValidationUtils::SVNumeroFloat($producto['precio']);
        $stock=ValidationUtils::SVNumero($producto['stock']);
        if(!ValidationUtils::noEstaVacio($nombre)){
            return "El nombre no puede estar vacío";
        }
        if (!ValidationUtils::TextoNoEsMayorQue($nombre,50)){
            return "El nombre no puede tener más de 50 caracteres";
        }
        if (!ValidationUtils::son_letras($nombre)){
            return "El nombre solo puede contener letras";
        }
        if(!ValidationUtils::noEstaVacio($descripcion)){
            return "La descripción no puede estar vacía";
        }
        if (!ValidationUtils::TextoNoEsMayorQue($descripcion,255)){
            return "La descripción no puede tener más de 255 caracteres";
        }
        if (!ValidationUtils::son_letras_y_numeros($descripcion)){
            return "La descripción solo puede contener letras y números";
        }
        return array(
            "nombre"=>$nombre,
            "descripcion"=>$descripcion,
            "precio"=>$precio,
            "stock"=>$stock);
    }

    /**
     * Sanea y valida los datos de un producto completo
     * @param array $producto array con los datos a sanear y validar
     * @return array|string con los datos saneados y validados o un mensaje de error
     */
    public function saneaYvalidaProductoCompleto(array $producto): array|string{

        $nombre=ValidationUtils::sanidarStringFiltro($producto['nombre']);
        $descripcion=ValidationUtils::sanidarStringFiltro($producto['descripcion']);
        $precio=ValidationUtils::SVNumeroFloat($producto['precio']);
        $stock=ValidationUtils::SVNumero($producto['stock']);
        $oferta=ValidationUtils::SBoolean($producto['oferta']);
        $fecha=ValidationUtils::sanitizeAndValidateDate($producto['fecha']);
        if ($producto['categoria_id']!="NA"){
            $categoriaId=ValidationUtils::SVNumero($producto['categoria_id']);
        }else{
            $categoriaId="NA";
        }
        if(!ValidationUtils::noEstaVacio($nombre)){
            return "El nombre no puede estar vacío";
        }
        if (!ValidationUtils::TextoNoEsMayorQue($nombre,50)){
            return "El nombre no puede tener más de 50 caracteres";
        }
        if (!ValidationUtils::son_letras($nombre)){
            return "El nombre solo puede contener letras";
        }
        if(!ValidationUtils::noEstaVacio($descripcion)){
            return "La descripción no puede estar vacía";
        }
        if (!ValidationUtils::TextoNoEsMayorQue($descripcion,255)){
            return "La descripción no puede tener más de 255 caracteres";
        }
        if (!ValidationUtils::son_letras_y_numeros($descripcion)){
            return "La descripción solo puede contener letras y números";
        }
        if(!isset($fecha)){
            return "La fecha no es valida";
        }
        if (!isset($categoriaId)){
            return "La categoria no es valida";
        }

        return array(
            "nombre"=>$nombre,
            "descripcion"=>$descripcion,
            "precio"=>$precio,
            "stock"=>$stock,
            "oferta"=>$oferta,
            "fecha"=>$fecha,
            "categoria"=>$categoriaId
        );
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getCategoriaId(): ?int
    {
        return $this->categoria_id;
    }

    public function setCategoriaId(?int $categoria_id): void
    {
        $this->categoria_id = $categoria_id;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    public function getDescripcion(): string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): void
    {
        $this->descripcion = $descripcion;
    }

    public function getPrecio(): float
    {
        return $this->precio;
    }

    public function setPrecio(float $precio): void
    {
        $this->precio = $precio;
    }

    public function getStock(): int
    {
        return $this->stock;
    }

    public function setStock(int $stock): void
    {
        $this->stock = $stock;
    }

    public function getOferta(): bool
    {
        return $this->oferta;
    }

    public function setOferta(string $oferta): void
    {
        $this->oferta = $oferta;
    }

    public function getFecha(): string
    {
        return $this->fecha;
    }

    public function setFecha(string $fecha): void
    {
        $this->fecha = $fecha;
    }

    public function getImagen(): string
    {
        return $this->imagen;
    }

    public function setImagen(string $imagen): void
    {
        $this->imagen = $imagen;
    }

    public function isDeleted(): bool
    {
        return $this->deleted;
    }

    public function setDeleted(bool $deleted): void
    {
        $this->deleted = $deleted;
    }


}
