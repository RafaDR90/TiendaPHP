<?php
namespace routes;
use controllers\usuarioController;
use controllers\categoriaController;
use controllers\productoController;
use controllers\carritoController;
class routes{
    const PATH="/TiendaPHP";

    public static function getRoutes(){


    // CREO CONTROLADORES
    $productoController=new productoController();
    $usuarioController=new usuarioController();
    $categoriaController=new categoriaController();
    $carritoController=new carritoController();
    // PAGINA PRINCIPAL
            get(self::PATH, function () use ($productoController){
                $productoController->showIndex();
            });
    // CREAR CUENTA
            get(self::PATH.'/CreateAccount', function () use ($usuarioController){
                $usuarioController->registro();
            });
            post(self::PATH.'/CreateAccount', function () use ($usuarioController){
                $usuarioController->registro();
            });
    // LOGIN
            get(self::PATH.'/Login', function () use ($usuarioController){
                $usuarioController->login();
            });
            post(self::PATH.'/Login', function () use ($usuarioController){
                $usuarioController->login();
            });
            get(self::PATH.'/CierraSesion', function () use ($usuarioController){
                $usuarioController->logout();
            });

    //                                                    CATEGORIAS
    // GESTIONAR CATEGORIAS
            get(self::PATH.'/gestionarCategorias', function () use ($categoriaController){
                $categoriaController->gestionarCategorias();
            });
            get(self::PATH.'/gestionarCategorias/$page', function ($page) use ($categoriaController){
                $categoriaController->gestionarCategorias($page);
            });

    // EDITAR CATEGORIA
            get(self::PATH.'/editarCategoria/$id', function ($id) use ($categoriaController){
                $categoriaController->editarCategoria($id);
            });
            post(self::PATH.'/editarCategoria/$id', function ($id) use ($categoriaController){
                $categoriaController->editarCategoria($id);
            });
            get(self::PATH.'/eliminarCategoria/$id', function ($id) use ($categoriaController){
                $categoriaController->eliminarCategoriaPorId($id);
            });

            post(self::PATH.'/NuevaCategoria', function () use ($categoriaController){
                $categoriaController->crearCategoria();
            });
            get(self::PATH.'/obtenerProductosPorId/$id', function ($id) use ($productoController){
                $productoController->obtenerProductosPorId($id);
            });

    //                                                      PRODUCTOS

    // GESTIONAR PRODUCTOS
            get(self::PATH.'/gestion-productos',function () use ($productoController){
                $productoController->muestraGestionProductos();
            });
            post(self::PATH.'/gestion-productos',function () use ($productoController){
                $productoController->muestraGestionProductos();
            });
    // AÑADIR PRODUCTO
            get(self::PATH.'/add-producto', function () use ($productoController){
                $productoController->addProducto();
            });
            post(self::PATH.'/add-producto', function () use ($productoController){
                $productoController->addProducto();
            });
    // ELIMINAR PRODUCTO
            get(self::PATH.'/eliminar-producto/$id', function ($id) use ($productoController){
                $productoController->eliminarProducto($id);
                });
    // EDITAR PRODUCTO
            get(self::PATH.'/editar-producto/$id', function ($id) use ($productoController){
                $productoController->editarProducto($id);
            });
            post(self::PATH.'/editar-producto', function () use ($productoController){
                $productoController->confirmaEdicion($_POST['id'],$_POST["edit"]);
            });

    // VER PRODUCTOS
            get(self::PATH.'/productos/$id', function ($id) use ($productoController){
                $productoController->obtenerProductosPorId($id);
            });

    // AÑADIR PRODUCTO A LA CESTA
            get(self::PATH.'/AddCesta/$id', function ($id) use ($carritoController){
                $carritoController->addProducto($id);
            });
    // VER CARRITO
            get(self::PATH.'/mostrarCarrito', function () use ($carritoController){
                $carritoController->mostrarCarrito();
            });

    // RESTAR PRODUCTO
            get(self::PATH.'/restar-producto/$id', function ($id) use ($carritoController){
                $carritoController->restarProducto($id);
            });
    // AUMENTAR PRODUCTO
            get(self::PATH.'/aumentar-producto/$id', function ($id) use ($carritoController){
                $carritoController->aumentarProducto($id);
            });
    // ELIMINAR PRODUCTO
            get(self::PATH.'/eliminarProducto/$id', function ($id) use ($carritoController){
                $carritoController->eliminarProducto($id);
            });
    // VACIAR CARRITO
            get(self::PATH.'/vaciar-carrito', function () use ($carritoController){
                $carritoController->vaciarCarrito();
            });
    // COMPRAR
            get(self::PATH.'/comprar', function () use ($carritoController){
                $carritoController->comprar();
            });
    //                                               USUARIOS
    // GESTIONAR USUARIOS
            get(self::PATH.'/gestion-usuarios', function () use ($usuarioController){
                $usuarioController->muestraGestionUsuarios();
            });
            post(self::PATH.'/rolUsuarios', function () use ($usuarioController){
                $usuarioController->muestraGestionUsuarios($_POST['tipoUsuario']);
            });
    // CAMBIAR ROL
            post(self::PATH.'/cambiarRol', function () use ($usuarioController){
                $usuarioController->cambiarRol($_POST['id'],$_POST['rol'],$_POST['nombre']);
            });


    // LA PAGINA NO SE ENCUENTRA
            any('/404', function (){
                $productoController=new productoController();
                $productoController->showIndex();
            });
        }
}

?>