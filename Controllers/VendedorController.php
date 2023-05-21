<?php

namespace Controllers;

use MVC\Router;
use Model\Vendedor;

class VendedorController
{
    public static function crear(Router $router)
    {
        $vendedor = new Vendedor();
        $errores = Vendedor::getErrores();

        if ($_POST) {
            $vendedor = new Vendedor($_POST['vendedor']);

            $errores = $vendedor->validar();

            if (empty($errores)) {
                $vendedor->guardar();
            }
        }

        $router->render('vendedores/crear', [
            "vendedor" => $vendedor,
            "errores" => $errores
        ]);
    }
    public static function actualizar(Router $router)
    {
        $id = validarORedireccionar('/admin');
        $errores = Vendedor::getErrores();
        $vendedor = Vendedor::forId($id);

        if ($_POST) {
            $arg = $_POST['vendedor'];
            $vendedor->sincronizar($arg);

            $errores = $vendedor->validar();

            if (empty($errores)) {
                $vendedor->guardar();
            }
        }

        $router->render('vendedores/actualizar', [
            "errores" => $errores,
            "vendedor" => $vendedor,
        ]);
    }
    public static function eliminar()
    {
        $id = $_POST['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        //VERIFICA QUE EL TIPO SEA VALIDO Y ELIMINA SEGUN PROPIEDAD O VENDEDOR
        if (verificarTipoEliminar($_POST['tipo'])) {
            if ($_POST['tipo'] === "vendedor") {
                $vendedor = Vendedor::forId($id);
                $vendedor->eliminarBD();
            }
        } else {
            header('Location: /admin');
        }
    }
}
