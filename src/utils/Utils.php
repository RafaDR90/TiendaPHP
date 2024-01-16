<?php
namespace utils;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
class Utils{
    /**
     * Comprueba si existe una sesión con el nombre indicado y la borra
     * @param $nombreSession
     * @return void
     */
    public static function deleteSession($nombreSession): void{
        if (isset($_SESSION[$nombreSession])){
            $_SESSION[$nombreSession]=null;
            unset($_SESSION[$nombreSession]);
        }
    }

    /**
     * Crea un html con los productos del carrito
     * @param $productosCarrito
     * @return string
     */
    public static function createHtmlContent(array $productosCarrito): string{
        $htmlContent = "<!DOCTYPE html>
<html>
<head>
    <style>
        .carritoContainer {
            font-family: Arial, sans-serif;
            color: #333333;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .carritoCard {
            background: #ffffff;
            border: 1px solid #dddddd;
            margin-bottom: 10px;
            padding: 10px;
        }
        .carritoCardImg img {
            max-width: 100px;
            max-height: 100px;
        }
        .cantidad, .precio {
            font-size: 14px;
            color: #555555;
        }
        .total {
            font-size: 16px;
            font-weight: bold;
            margin-top: 20px;
        }
        .gracias {
            font-size: 18px;
            color: #333333;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class='carritoContainer'>
        <div class='gracias'>
            <p>Gracias por su compra. Recibirá el pedido lo antes posible.</p>
        </div>
        <h1>Resumen de su compra</h1>
        <div class='productosCarrito'>";

        $totalUnidades = 0;
        $totalPrecio = 0;
        foreach ($_SESSION['carrito'] as $id => $unidades) {
            $totalUnidades += $unidades;
        }

        foreach ($productosCarrito as $producto) {
            $precioTotalProducto = $producto['precio'] * $producto['unidades'];

            $htmlContent .= "
            <div class='carritoCard'>
                
                <h4>{$producto['nombre']}</h4>
                <p class='cantidad'>Cantidad: <span>{$producto['unidades']}</span></p>
                <p class='precio'>Precio: <span>$precioTotalProducto €</span></p>
            </div>";
            $totalPrecio += ($producto["precio"] * $producto['unidades']);
        }

        $htmlContent .= "
        </div>
        <div class='total'>
            <p>Total unidades: <span>$totalUnidades</span></p>
            <p>Total precio: <span>$totalPrecio €</span></p>
        </div>
    </div>
</body>
</html>";
        return $htmlContent;
    }

    /**
     * Envía un correo con el html indicado
     * @param $htmlContent string html con el contenido del correo
     * @return string[] Mensaje de éxito o error
     */
    public static function enviarCorreoCompra(string $htmlContent): array {
        $mail = new PHPMailer(true);

        try {
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'rafapruebasdaw@gmail.com';
            $mail->Password = 'qvhl kmae gxgc vyik';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Remitentes y destinatarios
            $mail->setFrom('rafapruebasdaw@gmail.com', 'Nombre del remitente');
            $mail->addAddress('rafa18220delgado@gmail.com', 'Rafa');


            $mail->isHTML(true);
            $mail->Subject = 'Su compra se ha realizado correctamente';
            $mail->Body = $htmlContent;

            // Envío del correo
            $mail->send();

            // Mensaje de éxito
            return ['tipo' => 'exito', 'mensaje' => 'Ha recibido un correo con la confirmación de su compra'];

        } catch (Exception $e) {
            // Mensaje de error
            return ['tipo' => 'error', 'mensaje' => "El mensaje no pudo ser enviado. Mailer Error: {$mail->ErrorInfo}, porfavor, contacte con asistencia para comprobar el estado del pedido"];
        }
    }


}
