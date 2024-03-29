<?php use controllers\PedidoController; ?>

<div class="gestion-pedidos-container">
    <form action="<?= BASE_URL ?>gestion-pedidos" method="POST">
        <label for="estado">Estado</label>
        <select name="estado" id="estado">
            <option value="pendiente" <?php echo (isset($pedidos[0]) && $pedidos[0]->getEstado() == 'pendiente') ? 'selected' : ''; ?>>Pendiente</option>
            <option value="preparacion" <?php echo (isset($pedidos[0]) && $pedidos[0]->getEstado() == 'preparacion') ? 'selected' : ''; ?>>Preparacion</option>
            <option value="enviado" <?php echo (isset($pedidos[0]) && $pedidos[0]->getEstado() == 'enviado') ? 'selected' : ''; ?>>Enviado</option>
            <option value="entregado" <?php echo (isset($pedidos[0]) && $pedidos[0]->getEstado() == 'entregado') ? 'selected' : ''; ?>>Entregado</option>
        </select>
        <input type="submit" value="Mostrar">
    </form>

    <?php if (isset($pedidos)):
        if (count($pedidos)>0):?>
        <table class="gestion-pedidos-table">
            <tr>
                <th>Usuario</th>
                <th>Estado</th>
                <th>Fecha</th>
                <th>Producto</th>
                <th>Unidades</th>
                <th>Provincia</th>
                <th>Localidad</th>
                <th>Direccion</th>
                <th>Cambiar Estado</th>
            </tr>
            <?php foreach ($pedidos as $pedido): ?>
                <tr>
                    <td><?= $pedido->getUsuarioId() ?></td>
                    <td><?= $pedido->getEstado() ?></td>
                    <td><?= $pedido->getFecha() ?></td>
                    <td colspan="2">
                        <?php $items = PedidoController::getItems($pedido->getId()); ?>
                        <?php foreach ($items as $item): ?>
                            <?php $producto = PedidoController::getDatosItem($item->getProductoId()); ?>
                            <div class="producto-info">
                                <strong><?= $producto[0]->getNombre() ?></strong>
                                <?= $item->getUnidades() ?>
                            </div>
                        <?php endforeach; ?>
                    </td>
                    <td><?= $pedido->getProvincia() ?></td>
                    <td><?= $pedido->getLocalidad() ?></td>
                    <td><?= $pedido->getDireccion() ?></td>
                    <td>
                        <form action="<?= BASE_URL ?>cambiar-estado-pedido" method="POST">
                            <input type="hidden" name="pedido_id" value="<?= $pedido->getId() ?>">
                            <select name="nuevo_estado">
                                <option value="pendiente" <?=($pedido->getEstado()=='pendiente')? "selected":""?>>Pendiente</option>
                                <option value="preparacion" <?=($pedido->getEstado()=='preparacion')? "selected":""?>>Preparacion</option>
                                <option value="enviado" <?=($pedido->getEstado()=='enviado')? "selected":""?>>Enviado</option>
                                <option value="entregado" <?=($pedido->getEstado()=='entregado')? "selected":""?>>Entregado</option>
                            </select>
                            <input type="submit" value="Cambiar">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <?php else:?>
            <p class="no-pedidos">No hay pedidos con ese estado</p>
        <?php endif;?>
    <?php endif; ?>
</div>
