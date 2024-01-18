<div class="addAddress__container">
    <form action="<?=BASE_URL?>comprar" method="post">
        <label for="provincia">Provincia</label>
        <input type="text" name="address[provincia]" id="provincia" required>
        <label for="localidad">Localidad</label>
        <input type="text" name="address[localidad]" id="localidad" required>
        <label for="direccion">Direccion de envio</label>
        <input type="text" name="address[direccion]" id="direccion" required>
        <input type="submit" value="Continuar">
    </form>
</div>