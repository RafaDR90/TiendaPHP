<div class="editProductoFormContainer">
    <h3>Editar Producto</h3>
    <?php
    if ($productoEdit->isDeleted()):
?>
        <div class="error" role="alert">
            Este producto está eliminado. <a href="<?=BASE_URL?>reestablecer-producto/<?=$productoEdit->getId()?>">Click aqui</a> para reestablecer.
        </div><br>
    <?php endif;?>
    <form action="<?=BASE_URL?>editar-producto" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?=$productoEdit->getId();?>">

        <label for="nombre">Nombre:</label>
        <input type="text" id="edit" name="edit[nombre]" value="<?= $productoEdit->getNombre(); ?>"><br>

        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="edit[descripcion]"><?= $productoEdit->getDescripcion(); ?></textarea><br>

        <label for="precio">Precio:</label>
        <input type="number" id="precio" name="edit[precio]" step="0.01" value="<?= $productoEdit->getPrecio(); ?>"><br>

        <label for="stock">Stock:</label>
        <input type="number" id="stock" name="edit[stock]" value="<?= $productoEdit->getStock(); ?>"><br>

        <label for="oferta">Oferta:</label>
        <select id="oferta" name="edit[oferta]">
            <option value=1 <?=$productoEdit->getOferta() == true ? 'selected' : ''; ?>>Sí</option>
            <option value=0 <?=$productoEdit->getOferta() == false ? 'selected' : ''; ?>>No</option>
        </select><br>
        <label for="categoria">Categoría:</label>
        <select id="categoria" name="edit[categoria]">
            <option value="NA" <?=$productoEdit->getCategoriaId()==null ? 'selected' :''; ?>>Descatalogado</option>
            <?php foreach ($categorias as $categoria):?>
            <option value="<?=$categoria->getId();?>" <?=$productoEdit->getCategoriaId() == $categoria->getId() ? 'selected' : ''; ?>><?=$categoria->getNombre();?></option>
            <?php endforeach;?>
        </select>
        <label for="imagen">Imagen:</label>
        <input type="file" id="imagen" name="edit[imagen]"><br>
        <small>Imagen actual: <?=$productoEdit->getImagen(); ?></small><br>

        <input type="submit" value="Actualizar Producto">
    </form>
</div>
