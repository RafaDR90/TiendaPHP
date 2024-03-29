<?php
namespace controllers;

use lib\Pages,
    service\PedidoService,
    service\ProductoService,
    models\Pedido,
    models\Lineas_pedidos,
    models\Producto,
    utils\ValidationUtils;
class PedidoController{
    private Pages $pages;
    public function __construct()
    {
        $this->pages=new Pages();
    }

    /**
     * Funcion que muestra la vista de pedidos
     * @return void
     */
    public function verPedidos():void{
        if (session_status() == PHP_SESSION_NONE){
            $this->pages->render('producto/muestraInicio',['error'=>'Tienes que iniciar sesion para acceder a esta pagina']);
        }
        $this->pages->render("pedidos/pedidosView");
    }

    /**
     * Funcion que devuelve los pedidos de un usuario
     * @param $id int id del usuario
     * @return array|void
     */
    public static function getPedidos($id):array{
        $pedidoService=new PedidoService();
        $pedidos=$pedidoService->getPedidosPorId($id);
        if (is_string($pedidos)){
            $pages=new Pages();
            $pages->render('producto/muestraInicio',['error'=>"Ha ocurrido un error: ".$pedidos]);
            exit();
        }
        return Pedido::fromArray($pedidos);
    }

    /**
     * Funcion que devuelve las lineas de un pedido (IDproducto, cantidad, precio de un pedido)
     * @param $id int id del pedido
     * @return array|void
     */
    public static function getItems(int $id):array{
        $pedidoService=new PedidoService();
        $items=$pedidoService->getItemsPorId($id);
        if (is_string($items)){
            $pages=new Pages();
            $pages->render('producto/muestraInicio',['error'=>"Ha ocurrido un error: ".$items]);
            exit();
        }
        return Lineas_pedidos::fromArray($items);
    }

    /**
     * Funcion que devuelve los datos de un producto
     * @param $id int id del producto
     * @return array|void
     */
    public static function getDatosItem(int $id):array{
        $productoService=new ProductoService();
        $producto=$productoService->getProductoByIdProducto($id);
        if (is_string($producto)){
            $pages=new Pages();
            $pages->render('producto/muestraInicio',['error'=>"Ha ocurrido un error: ".$producto]);
            exit();
        }
        return Producto::fromArray([$producto]);
    }

    /**
     * Muestra la vista de gestion de pedidos, si se recibe un POST se muestran los pedidos con el estado indicado
     * @return void
     */
    public function gestionarPedidos()
    {
        if (!isset($_SESSION['identity']) or $_SESSION['identity']['rol'] != 'admin') {
            $this->pages->render('pedidos/muestraInicio', ['error' => 'Debes identificarte como administrador para poder administrar productos']);
            exit();
        }
        if ($_SERVER['REQUEST_METHOD'] != "POST") {
            $this->pages->render('pedidos/gestionPedidos');
        } else {
            $estado = $_POST['estado'];
            if (!Pedido::validaEstado($estado)) {
                $this->pages->render('pedidos/gestionPedidos', ['error' => 'El estado no es valido']);
                exit();
            }
            $pedidoService = new PedidoService();
            $pedidos = $pedidoService->getPedidosPorEstado($estado);
            $pedidos = Pedido::fromArray($pedidos);
            $this->pages->render('pedidos/gestionPedidos', ['pedidos' => $pedidos]);
        }
    }

    /**
     * Funcion que cambia el estado de un pedido
     * @param $id int id del pedido
     * @param $estado string estado del pedido
     * @return void
     */
    public function cambiarEstadoPedido(int $id, string $estado)
    {
        if (!isset($_SESSION['identity']) or $_SESSION['identity']['rol'] != 'admin') {
            $this->pages->render('pedidos/muestraInicio', ['error' => 'Debes identificarte como administrador para poder administrar productos']);
            exit();
        }
        if (!Pedido::validaEstado($estado)) {
            $this->pages->render('pedidos/gestionPedidos', ['error' => 'El estado no es valido']);
            exit();
        }
        $id=ValidationUtils::SVNumero($id);
        if (!isset($id)){
            $this->pages->render('pedidos/gestionPedidos', ['error' => 'El id no es valido']);
        }
        $pedidoService = new PedidoService();
        $error=$pedidoService->cambiarEstadoPedido($id,$estado);
        if (isset($error)){
            $this->pages->render('pedidos/gestionPedidos', ['error' => 'Ha ocurrido un error: '.$error]);
            exit();
        }
        $this->pages->render('pedidos/gestionPedidos', ['exito' => 'El estado del pedido se ha actualizado correctamente']);
    }

}