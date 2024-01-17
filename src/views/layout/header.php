<?php
use controllers\CategoriaController,
    controllers\ProductoController;?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tienda</title>
    <link rel="stylesheet" href="<?=BASE_URL?>public/styles/Header.css">
    <link rel="stylesheet" href="<?=BASE_URL?>public/styles/main.css">
    <link rel="stylesheet" href="<?=BASE_URL?>public/styles/normalize.css">
    <link rel="stylesheet" href="<?=BASE_URL?>public/styles/usuario/registro.css">
    <link rel="stylesheet" href="<?=BASE_URL?>public/styles/usuario/login.css">
    <link rel="stylesheet" href="<?=BASE_URL?>public/styles/categoria/gestionCategoria.css">
</head>
<body>
    <header>
        <h1><a href="<?=BASE_URL?>">PRIMALK</a></h1>
        <ul>
        <?php
        if (isset($_SESSION['identity'])): ?>
            <li><a href="<?= BASE_URL ?>CierraSesion">Cerrar sesion</a></li>
            <li><a href="<?= BASE_URL ?>misPedidos">Mis pedidos</a></li>
            <?php if ($_SESSION['identity']['rol']=='admin'): ?>
            <li><a href="<?= BASE_URL ?>gestionarCategorias">Gestionar categorias</a></li>
            <li><a href="<?= BASE_URL ?>gestion-productos">Gestionar productos</a></li>
            <li><a href="<?=BASE_URL?>gestion-usuarios">Gestionar usuarios</a></li>
            <li><a href="<?=BASE_URL?>gestion-pedidos">Gestionar pedidos</a></li>
            <li><a href="<?=BASE_URL?>CreateAccount">Crear Administrador</a></li>
            <?php endif;?>
        <?php else: ?>
            <li><a href="<?= BASE_URL ?>CreateAccount">Crear cuenta</a></li>
            <li><a href="<?= BASE_URL ?>Login">Identificate</a></li>
            <?php endif; ?>
            <li><a href="<?=BASE_URL?>mostrarCarrito">Ver Carrito</a></li>
        </ul>
        <?php $categorias= CategoriaController::obtenerCategorias();?>
        <nav class="navPrincipal">
            <ul style="display: flex; gap: 15px">
                <?php foreach ($categorias as $categoria):
                    // Compruebo si hay productos en stock para mostrar la categoria
                    $hProductos=ProductoController::productosPorCategoria($categoria->getId());
                    $disponible=false;
                    if (isset($hProductos) and !empty($hProductos)){
                        foreach ($hProductos as $producto){
                            if ($producto->getStock()>0 and !$producto->isDeleted()){
                                $disponible=true;
                            }
                        }
                    }
                    if ($disponible): ?>
                    <li>
                        <a href="<?=BASE_URL?>productos/<?= $categoria->getId() ?>"><?php echo $categoria->getNombre(); ?></a>
                    </li>
                <?php
                    endif;
                endforeach;?>
            </ul>
        </nav>
        <div class="mensajesError">
        <?php if (isset($exito)): ?>
            <strong class="exito"><?=$exito?></strong>
        <?php elseif (isset($error)): ?>
            <strong class="error"><?=$error?></strong>
        <?php endif; ?>
        </div>
    </header>
<main>
