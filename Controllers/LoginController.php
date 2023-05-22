<?php

namespace Controllers;

use MVC\Router;
use Model\Admin;

class LoginController
{
    public static function login(Router $router)
    {
        $errores = [];

        if ($_POST) {
            $auth = new Admin($_POST);
            $errores = $auth->validar();

            if (!$errores) {
                //VERIFICAR SI EL USUARIO EXISTE
                $resultado = $auth->exiteUsuario();

                if (!$resultado) {
                    $errores = Admin::getErrores();
                } else {
                    //EXITE USUARIO
                    $autenticado = $auth->validarPassword($resultado);
                    if (!$autenticado) {
                        $errores = Admin::getErrores();
                    } else {
                        //CONTRASEÑÁ CORRECTA
                        $auth->session();
                    }
                }
            }
        }

        $router->render('auth/login', [
            'errores' => $errores
        ]);
    }
    public static function logout()
    {
        session_start();
        $auth = $_SESSION['login'];

        if ($auth) {
            $_SESSION = [];
            header('Location: /');
        }
    }
}
