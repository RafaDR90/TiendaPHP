<?php
use JasonGrimes\Paginator;

// Assuming $entradas is your array of entries
if (isset($gProductos)){
    $totalItems = count($gProductos);
    $itemsPerPage = 9; // Set the number of items per page
    $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $urlPattern = BASE_URL.'gestion-productos/?page=(:num)';

    $paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);

// Get the subset of entries for the current page
    $start = ($currentPage - 1) * $itemsPerPage;
    $end = $start + $itemsPerPage;
    $currentPageEntries = array_slice($gProductos, $start, $itemsPerPage);

    $classActive='';
}

?>

<div class="gestionaProductosContainer">
    <div class="formSeleccionCategoria">
        <label for="categoria">Selecciona una categoria</label>
        <div class="select-submit-container">
        <form action="<?=BASE_URL?>gestion-productos" method="POST">
            <select name="categoriaId" id="categoria">
                <?php if(!isset($_SESSION['editandoProducto'])):?>
                <option value="NA" selected>Seleccione categoria</option>
                <?php endif?>
                <option value="none" <?= (isset($_SESSION['editandoProducto']) && $_SESSION['editandoProducto'] == 'none') ? 'selected' : '' ?>>Descatalogados</option>
                <option value="deleted" <?= (isset($_SESSION['editandoProducto']) && $_SESSION['editandoProducto'] == 'deleted') ? 'selected' : '' ?>>Eliminados</option>
                <?php
foreach ($categorias as $categoria):
    if ($categoria->getId()==$_SESSION['editandoProducto']):?>
                <option value="<?= $categoria->getId() ?>" selected><?= $categoria->getNombre() ?></option>
<?php else:?>
                <option value="<?= $categoria->getId() ?>"><?= $categoria->getNombre() ?></option>
<?php endif;
endforeach;?>
            </select>
            <input type="submit" value="Ver productos">
        </form>
        </div>
    </div>
<?php
if (isset($currentPageEntries)):?>
    <div class="modificaProductosContainer">
        <?php
        if (isset($_SESSION['editandoProducto']) && $_SESSION['editandoProducto'] != 'none' && $_SESSION['editandoProducto'] != 'deleted'):
        ?>
        <div class="addProductoContainer"><a href="<?=BASE_URL?>add-producto">Nuevo producto</a></div>
        <?php
        endif;
        ?>
        <?php foreach ($currentPageEntries as $producto):?>
        <div class="cardModificaProducto">
            <div class="columnaDatos">
                <span class="modifyProductId"><small>Producto ID:</small> <?=$producto->getId()?>&nbsp;&nbsp;</span>
                <div class="imgModifyProduct__container"><img src="<?=BASE_URL?>public/img/productos/<?=$producto->getImagen()?>"></div>
                <p class="modifyProductNombre"><?=$producto->getNombre()?></p>
            </div>
            <div class="columnaButtons">
                <?php
                if ($producto->getStock() <= 0):?>
                    <span class="sinStock" style="color: red"> Sin stock &nbsp;</span>
                <?php endif;?>

                <a href="<?=BASE_URL?>editar-producto/<?=$producto->getId()?>">Editar</a>
                <?php if ($producto->isDeleted()):?>
                    <span>Eliminado</span>
                <?php else:?>
                <a href="<?=BASE_URL?>eliminar-producto/<?=$producto->getId()?>">Eliminar</a>
                <?php endif;?>
            </div>
        </div>
        <?php endforeach;?>
    </div>

<?php endif;
if (isset($currentPageEntries)):?>
    <div class="paginationLinksContainer">
        <?php if ($paginator->getNumPages() > 1): ?>
            <ul class="pagination">
                <?php if ($paginator->getPrevUrl()): ?>
                    <li class="pagination__previous--li"><a href="<?php echo $paginator->getPrevUrl(); ?>">&laquo; Previous</a></li>
                <?php endif; ?>
                <?php foreach ($paginator->getPages() as $page): ?>
                    <?php if ($page['url']): ?>
                        <li class="pagination__li<?php echo $page['isCurrent'] ? 'active' : ''; ?>">
                            <a href="<?php echo $page['url']; ?>"><?php echo $page['num']; ?></a>
                        </li>
                    <?php else: ?>
                        <li class="disabled"><span><?php echo $page['num']; ?></span></li>
                    <?php endif; ?>
                <?php endforeach; ?>
                <?php if ($paginator->getNextUrl()):; ?>
                    <li><a class="pagination__next--li" href="<?php echo $paginator->getNextUrl(); ?>">Next &raquo;</a></li>
                <?php endif; ?>
            </ul>
        <?php endif; ?>
    </div>
    <?php endif;?>
</div>
