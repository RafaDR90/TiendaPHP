<div class="registroContainer">
    <h3>Registrate</h3>
    <?php if (isset($_SESSION['identity']['rol']) && $_SESSION['identity']['rol']=='admin'): ?>
        <p style="color: red">Esta cuenta se creará con rol de administrador</p>
    <?php endif; ?>
    <form action="<?=BASE_URL?>CreateAccount" method="post">
        <p>
        <label for="nombre">Nombre</label>
        <input id="nombre" type="text" name="data[nombre]" required>
        </p>
        <p>
        <label for="apellidos">Apellidos</label>
        <input id="apellidos" type="text" name="data[apellidos]" required>
        </p>
        <p>
        <label for="email">Email</label>
        <input id="email" type="text" name="data[email]" required>
        </p>
        <p>
        <label for="password">Contraseña</label>
        <input id="password" type="password" name="data[password]" required>
        </p>
        <?php if (isset($_SESSION['identity']['rol']) && $_SESSION['identity']['rol']=='admin'): ?>
        <input type="hidden" name="data[rol]" value="admin">
        <?php endif; ?>
        <p>
        <input type="submit" value="Registrarse">
        </p>
    </form>
</div>