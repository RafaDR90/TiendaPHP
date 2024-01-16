<?php
namespace controllers;
use lib\Pages;

use service\LineasPedidoService;
use service\PedidoService;
use service\ProductoService;
use utils\ValidationUtils;
use utils\Utils;

class CarritoController
{
    private Pages $pages;
    public function __construct()
    {
        $this->pages = new Pages();
    }

    /**
     * Funcion para añadir un producto al carrito y si ya esta añadido aumentar las unidades en 1 hasta el stock maximo
     * @param $id int id del producto a añadir
     * @return void redirige a la vista del carrito
     */
    public function addProducto(int $id): void
    {
        $id=ValidationUtils::SVNumero($id);
        if (!isset($id)){
            $this->pages->render("producto/muestraInicio",["error"=>"Ha habido un problema al añadir el producto a la cesta, si el problema persiste contacte con el Belén"]);
        }
        if (!session_status() == PHP_SESSION_ACTIVE) {
            session_start();
        }
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = array();
        }
        if (!isset($_SESSION['carrito'][$id])) {
            $_SESSION['carrito'][$id] = 1;
        } else {
            $productoService=new productoService();
            $producto=$productoService->getProductoByIdProducto($id);
            if ($_SESSION['carrito'][$id] >= $producto['stock']) {
                $this->pages->render("carrito/vistaCarrito",["error"=>"No hay mas stock del producto"]);
                exit();
            }
            $_SESSION['carrito'][$id]++;
        }
        $this->pages->render("carrito/vistaCarrito",["exito"=>"Producto añadido a la cesta"]);
    }

    /**
     * Funcion estatica para obtener los productos del carrito
     * @return array con los productos del carrito
     */
    public static function obtenerProductosCarrito() : array
    {
        if (!session_status() == PHP_SESSION_ACTIVE) {
            session_start();
        }
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = array();
        }
        $productos = array();
        foreach ($_SESSION['carrito'] as $id => $unidades) {
            $productoService=new productoService();
            $producto = $productoService->getProductoByIdProducto($id);
            $producto['unidades'] = $unidades;
            $productos[] = $producto;
        }
        return $productos;
    }

    /**
     * Funcion para mostrar la vista del carrito
     * @return void redirige a la vista del carrito
     */
    public function mostrarCarrito() : void
    {

        $this->pages->render('carrito/vistaCarrito');
    }

    /**
     * Funcion para restar un producto del carrito, si solo hay una unidad se elimina del carrito
     * @param $id int id del producto a restar
     * @return void redirige a la vista del carrito
     */
    public function restarProducto(int $id): void{
        $id=ValidationUtils::SVNumero($id);
        if (!isset($id)){
            $this->pages->render("producto/muestraInicio",["error"=>"Ha habido un problema al restar el producto a la cesta, si el problema persiste contacte con soporte tecnico"]);
        }
        if (!session_status() == PHP_SESSION_ACTIVE) {
            session_start();
        }
        if (!isset($_SESSION['carrito'][$id])) {
            $this->pages->render("producto/muestraInicio",["error"=>"No se encuentra el producto en la cesta"]);
        }
        if ($_SESSION['carrito'][$id] == 1) {
            unset($_SESSION['carrito'][$id]);
        } else {
            $_SESSION['carrito'][$id]--;
        }
        $this->pages->render("carrito/vistaCarrito",["exito"=>"Producto eliminado a la cesta"]);
    }

    /**
     * Funcion para aumentar un producto del carrito
     * @param $id int id del producto a aumentar
     * @return void redirige a la vista del carrito
     */
    public function aumentarProducto(int $id): void{
        $id=ValidationUtils::SVNumero($id);
        if (!isset($id)){
            $this->pages->render("producto/muestraInicio",["error"=>"Ha habido un problema al aumentar el producto a la cesta, si el problema persiste contacte con soporte tecnico"]);
        }
        if (!session_status() == PHP_SESSION_ACTIVE) {
            session_start();
        }
        if (!isset($_SESSION['carrito'][$id])) {
            $this->pages->render("producto/muestraInicio",["error"=>"No se encuentra el producto en la cesta"]);
        }
        $productoService=new productoService();
        $producto=$productoService->getProductoByIdProducto($id);
        if ($_SESSION['carrito'][$id] >= $producto['stock']) {
            $this->pages->render("carrito/vistaCarrito",["error"=>"No hay mas stock del producto"]);
            exit();
        }
        $_SESSION['carrito'][$id]++;
        $this->pages->render("carrito/vistaCarrito",["exito"=>"Producto añadido a la cesta"]);
    }

    /**
     * Funcion para eliminar un producto del carrito
     * @param $id int id del producto a eliminar
     * @return void redirige a la vista del carrito
     */
    public function eliminarProducto(int $id): void{
        $id=ValidationUtils::SVNumero($id);
        if (!isset($id)){
            $this->pages->render("producto/muestraInicio",["error"=>"Ha habido un problema al eliminar el producto a la cesta, si el problema persiste contacte con soporte tecnico"]);
        }
        if (!session_status() == PHP_SESSION_ACTIVE) {
            session_start();
        }
        if (!isset($_SESSION['carrito'][$id])) {
            $this->pages->render("carrito/vistaCarrito",["error"=>"No se encuentra el producto en la cesta"]);
        }
        unset($_SESSION['carrito'][$id]);
        $this->pages->render("carrito/vistaCarrito",["exito"=>"Producto eliminado a la cesta"]);
    }

    /**
     * Funcion para vaciar el carrito
     * @return void redirige a la vista del carrito
     */
    public function vaciarCarrito(): void{
        if (!session_status() == PHP_SESSION_ACTIVE) {
            session_start();
        }
        unset($_SESSION['carrito']);
        $this->pages->render("carrito/vistaCarrito",["exito"=>"Carrito vaciado"]);
    }

    /**
     * Funcion para comprar los productos del carrito y restar el stock de los productos comprados
     * @return void redirige a la vista de compra realizada
     */
    public function comprar(): void{
        if (!session_status() == PHP_SESSION_ACTIVE) {
            session_start();
        }
        if (!isset($_SESSION['identity'])){
            $this->pages->render("carrito/vistaCarrito",["error"=>"Debes iniciar sesion para comprar"]);
            exit();
        }
        $pedidoService=new pedidoService();
        $lineasPedidoService=new lineasPedidoService();


        if (!isset($_SESSION['carrito']) or empty($_SESSION['carrito'])){
            $this->pages->render("carrito/vistaCarrito",["error"=>"No hay productos en el carrito"]);
        }
        $productosCarrito=carritoController::obtenerProductosCarrito();

        //Comprueba que haya suficiente stock de los productos
        foreach ($productosCarrito as $producto){
            if ($producto['stock'] < $producto['unidades']){
                $this->pages->render("carrito/vistaCarrito",["error"=>"No hay suficiente stock del producto ".$producto['nombre']]);
                exit();
            }
        }
        $productoService=new productoService();
        //crear pedido
        $precioTotal=0;
        foreach ($productosCarrito as $producto){
            $precioTotal+=($producto["precio"] * $producto['unidades']);
        }
        $datos=array("idUsuario"=>$_SESSION['identity']['id'],"fecha"=>date("Y-m-d H:i:s"),"coste"=>$precioTotal,"estado"=>"preparacion");

        // restar stock de los productos comprados
        foreach ($productosCarrito as $producto){
            $error=$productoService->restarStock($producto['id'],$producto['unidades']);
            if (isset($error)){
                $this->pages->render("carrito/vistaCarrito",["error"=>"Ha habido un problema al comprar los productos, si el problema persiste contacte con soporte tecnico"]);
            }
        }

        $pedidoService->create($datos);
        $pedidoId=$pedidoService->getIdUltimoPedido();
        foreach ($_SESSION['carrito'] as $id => $unidades) {
            $lineasPedidoService->create($id,$pedidoId['MAX(id)'],$unidades);
        }



            // Crea el contenido del correo
            $htmlContent =utils::createHtmlContent($productosCarrito);
            // Envía el correo
            $mensaje=utils::enviarCorreoCompra($htmlContent);
            if ($mensaje['tipo'] == 'exito') {
                unset($_SESSION['carrito']);
                $this->pages->render("carrito/compra-realizada",["exito"=>$mensaje['mensaje'],'htmlContent'=>$htmlContent]);
            } else {
                $this->pages->render("carrito/vistaCarrito",["error"=>$mensaje['mensaje']]);
            }

    }
}
