<?php

namespace Controllers;

use MVC\Router;
use Model\Propiedad;
use PHPMailer\PHPMailer\PHPMailer;

class PaginasController
{
    public static function index(Router $router)
    {
        $propiedades = Propiedad::get(3);
        $inicio = true;
        $router->render('paginas/index', [
            'propiedades' => $propiedades,
            'inicio' => $inicio
        ]);
    }
    public static function nosotros(Router $router)
    {
        $router->render('paginas/nosotros');
    }
    public static function propiedades(Router $router)
    {
        $propiedades = Propiedad::get(10);
        $router->render('paginas/propiedades', [
            'propiedades' => $propiedades
        ]);
    }
    public static function propiedad(Router $router)
    {
        $id = ValidaroRedireccionar('/propiedades');
        $propiedad = Propiedad::forId($id);

        if (!$propiedad) {
            header("Location: /propiedades");
        }

        $router->render('paginas/propiedad', [
            'propiedad' => $propiedad
        ]);
    }
    public static function blog(Router $router)
    {
        $router->render('paginas/blog');
    }
    public static function entrada(Router $router)
    {
        $router->render('paginas/entrada');
    }
    public static function contacto(Router $router)
    {
        $mensaje = '';
        if ($_POST) {

            $resultado = $_POST['contacto'];
            //create a new object
            $mail = new PHPMailer();
            // configure an SMTP
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Username = '058377574be09c';
            $mail->Password = 'f195cf41e23a7d';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 2525;

            $mail->setFrom('admin@bienesraices.com');
            $mail->addAddress('admin@bienesraices.com', 'BienesRaices.com');
            $mail->Subject = 'Tienes un Nuevo Email';

            // Set HTML 
            $mail->isHTML(TRUE);
            $mail->CharSet = 'UTF-8';


            $contenido = '<html>';
            $contenido .= '<p>Tienes un nuevo mensaje</p>';
            $contenido .= '<p>Nombre: ' . $resultado['nombre'] . '</p>';

            if ($resultado['metodo'] === 'telefono') {
                $contenido .= '<p>Telefono: ' . $resultado['telefono'] . '</p>';
                $contenido .= '<p>Fecha: ' . $resultado['fecha'] . '</p>';
                $contenido .= '<p>Hora: ' . $resultado['hora'] . '</p>';
            } elseif ($resultado['metodo'] === 'email') {
                $contenido .= '<p>Email: ' . $resultado['email'] . '</p>';
            }

            $contenido .= '<p>Mensaje: ' . $resultado['mensaje'] . '</p>';
            $contenido .= '<p>Vende o compra: ' . $resultado['tipo'] . '</p>';
            $contenido .= '<p>Precio o presupuesto: $' . $resultado['presupuesto'] . '</p>';
            $contenido .= '<p>Prefiere ser contactado por: ' . $resultado['metodo'] . '</p>';


            $contenido .= '</html>';

            $mail->Body = $contenido;
            $mail->AltBody = 'Esto es texto alternativo';

            if (!$mail->send()) {
                $mensaje = 'Hubo un Error... intente de nuevo';
            } else {
                $mensaje = 'Email enviado Correctamente';
            }
        }
        $router->render('paginas/contacto', [
            "mensaje" => $mensaje
        ]);
    }
}
