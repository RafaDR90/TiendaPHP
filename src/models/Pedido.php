<?php
namespace models;
use utils\ValidationUtils;
class Pedido{
    private ?int $id;
    private ?int $usuario_id;
    private string $provincia;
    private string $localidad;
    private string $direccion;
    private float $coste;
    private string $estado;
    private string $fecha;
    private string $hora;
    public function __construct(?int $id=null,int $usuario_id=null,float $coste=0,string $estado='',string $fecha='',string $hora='', string $direccion='', string $provincia='', string $localidad='')
    {
        $this->id=$id;
        $this->usuario_id=$usuario_id;
        $this->coste=$coste;
        $this->estado=$estado;
        $this->fecha=$fecha;
        $this->hora=$hora;
        $this->direccion=$direccion;
        $this->provincia=$provincia;
        $this->localidad=$localidad;
    }

    /**
     * Transforma un array en un array de objetos pedido
     * @param array $data array con los datos a transformar
     * @return array
     */
    public static function fromArray(array $data):array
    {
        $pedidos=[];
        foreach ($data as $dt) {
            $pedido = new pedido(
                $dt['id'] ?? null,
                $dt['usuario_id'] ?? null,
                $dt['coste'] ?? 0,
                $dt['estado'] ?? '',
                $dt['fecha'] ?? '',
                $dt['hora'] ?? '',
                $dt['direccion'] ?? '',
                $dt['provincia'] ?? '',
                $dt['localidad'] ?? ''
            );
            $pedidos[]=$pedido;
        }
        return $pedidos;
    }

    /**
     * Valida el estado de un pedido
     * @param $estado string estado a validar
     * @return bool true si es valido, false si no lo es
     */
    public static function validaEstado($estado){
        $estadosValidos=array('pendiente','preparacion','enviado','entregado');
        return in_array($estado,$estadosValidos);
    }

    public static function validaDireccion($direccion){
        if (!isset($direccion['localidad']) or !isset($direccion['provincia']) or !isset($direccion['direccion'])){
            return false;
        }
        $direccion['localidad']=ValidationUtils::sanidarStringFiltro($direccion['localidad']);
        $direccion['provincia']=ValidationUtils::sanidarStringFiltro($direccion['provincia']);
        $direccion['direccion']=ValidationUtils::sanidarStringFiltro($direccion['direccion']);
        if (!ValidationUtils::noEstaVacio($direccion['localidad']) or !ValidationUtils::noEstaVacio($direccion['provincia']) or !ValidationUtils::noEstaVacio($direccion['direccion'])){
            return false;
        }
        if (!ValidationUtils::TextoNoEsMayorQue($direccion['localidad'],50) or !ValidationUtils::TextoNoEsMayorQue($direccion['provincia'],50) or !ValidationUtils::TextoNoEsMayorQue($direccion['direccion'],100)){
            return false;
        }
        return $direccion;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getUsuarioId(): ?int
    {
        return $this->usuario_id;
    }

    public function setUsuarioId(?int $usuario_id): void
    {
        $this->usuario_id = $usuario_id;
    }

    public function getCoste(): float
    {
        return $this->coste;
    }

    public function setCoste(float $coste): void
    {
        $this->coste = $coste;
    }

    public function getEstado(): string
    {
        return $this->estado;
    }

    public function setEstado(string $estado): void
    {
        $this->estado = $estado;
    }

    public function getFecha(): string
    {
        return $this->fecha;
    }

    public function setFecha(string $fecha): void
    {
        $this->fecha = $fecha;
    }

    public function getHora(): string
    {
        return $this->hora;
    }

    public function setHora(string $hora): void
    {
        $this->hora = $hora;
    }

    public function getProvincia(): string
    {
        return $this->provincia;
    }

    public function setProvincia(string $provincia): void
    {
        $this->provincia = $provincia;
    }

    public function getLocalidad(): string
    {
        return $this->localidad;
    }

    public function setLocalidad(string $localidad): void
    {
        $this->localidad = $localidad;
    }

    public function getDireccion(): string
    {
        return $this->direccion;
    }

    public function setDireccion(string $direccion): void
    {
        $this->direccion = $direccion;
    }



}