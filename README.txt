COMO FUNCIONA LA APLICACIÓN

En este README se explica cómo funcionan cosas internas de la aplicación; no se explican muchas cosas de las que se ven
a simple vista.

--INTRO
    Nada más entrar a la página aparecerán 4 productos de cada categoría, si esta tiene al menos 4. En caso de no tener
    ningún producto, esta no aparecerá.

    -SIN INICIO DE SESIÓN
            Antes de iniciar sesión tendremos la opción de navegar por las categorías, añadir productos al carrito
            (pero no comprar), crear cuenta, identificarnos y ver carrito.

    -SESIÓN DE USUARIO ESTÁNDAR
        Añadimos la opción de comprar, de ver Mis pedidos y de cerrar sesión.

    -SESIÓN DE ADMIN
        Además de lo de usuario estándar añadimos, gestión de usuarios, productos y categorías.

--GESTIÓN DE USUARIOS
    -CREAR CUENTA
        Se envía el formulario por POST, se valida (valida string y que no esté repetido el correo), encripta la
        contraseña y crea cuenta en la Base de datos.
    -IDENTIFICARSE
        Comprueba usuario y contraseña y crea una sesión.

    -GESTIONAR USUARIOS
        Ves todos los usuarios en una tabla, junto con su rol de Administrador/Usuario. Se puede filtrar por rol.
        El usuario Admin puede cambiar el rol de todos los usuarios excepto el suyo.

--GESTIÓN CATEGORÍAS
    -Muestra todas las categorías junto con la opción de Editar, Eliminar y Añadir.
    -Paginado cada 6 categorías.
    -Si se elimina una categoría con productos, estos pasarán a estar descatalogados y marcados como eliminados, la
    categoría se borrará de la BD.

--GESTIÓN PRODUCTOS
    -Paginado cada 9 productos.
    -Debemos seleccionar la categoría de los productos o si queremos ver descatalogados o eliminados.
    -CREAR PRODUCTO
        Si creamos un producto, este se creará con ajustes estándar; si queremos cambiar algo como, por ejemplo, si
        está o no en oferta, esto debemos hacerlo desde la edición.
        Tienen que estar todos los campos rellenos.
    -Si al editar cambiamos la foto, se borrará la antigua y creará la nueva.
    -No está permitido descatalogar un producto, pero sí darle una categoría a un producto descatalogado por la
    eliminación de su categoría.
    -Si eliminamos un producto, no se eliminará de la BD, pero se le marcará como eliminado en la BD.
    -Desde la edición, si está eliminado, tendremos la opción de deshacer la marca.

--VER CARRITO
    -ESTÁ VACÍO
        Si está vacío o no existe la sesión de carrito, te crea un link que te devuelve a la página principal.
    -CON ARTÍCULOS
        Si añades más productos de los que hay en stock, te saltará un mensaje y no te lo permitirá.
        Si restas productos cuando tienes 1, este se eliminará.
        -COMPRAR
            Si una vez pulsas en comprar, alguien ha comprado ya el producto y no queda stock, te devolverá al carrito
            y te dirá de qué producto no queda stock para hacer el pedido.
            Te enviará un correo electrónico y creará un pedido nuevo en estado "preparación" y restará el stock del
            producto.

            (La función de correo electrónico está en utils/utils.php. Para comprobar que funciona, debes cambiar
            el correo del destinatario actual, "rafa18220delgado@gmail.com", por el que desees enviar el correo, ya que
            los correos de los usuarios actuales son falsos.)

--MIS PEDIDOS
    Veremos todos los pedidos junto con su estado.
