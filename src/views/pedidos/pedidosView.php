<?php
use controllers\PedidoController;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$pedidos=PedidoController::getPedidos($_SESSION['identity']['id']);
?>
<div class="tituloPedidos">
    <h3>Mis pedidos</h3>
<?php
foreach ($pedidos as $pedido):?>
<div class="pedidoContainer">
    <p>Pedido del <?= date('d/m/Y', strtotime($pedido->getFecha())) ?></p>
    <?php $items=PedidoController::getItems($pedido->getId());
    foreach ($items as $item):
        $producto=PedidoController::getDatosItem($item->getProductoId());
    ?>
        <div class="infoProductoPedido">
            <div class="pedidoImgContainer">
                <img src="<?=BASE_URL?>public/img/productos/<?= $producto[0]->getImagen() ?>" alt="<?= $producto[0]->getNombre() ?>" class="img-fluid">
            </div>
            <div class="pedidoInfoContainer">
                <p>Nombre: <?= $producto[0]->getNombre() ?></p>
                <p>Unidades: <?= $item->getUnidades() ?></p>
                <p>Precio: <?= $producto[0]->getPrecio()*$item->getUnidades() ?>€</p>
            </div>
        </div>
<?php endforeach; ?>
    <div class="infoPedido">

    </div>
    <p class="pedidoPrice">Precio del pedido: <?= $pedido->getCoste() ?></p>
    <p class="estadoPedido">Estado: <?= $pedido->getEstado() ?></p>
</div>
    <?php endforeach;?>
</div>
