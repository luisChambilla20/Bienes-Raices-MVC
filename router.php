<?php

namespace MVC;

class Router
{

    public $rutasGET = [];
    public $rutasPOST = [];

    public function get($url, $fn)
    {
        $this->rutasGET[$url] = $fn;
    }

    public function post($url, $fn)
    {
        $this->rutasPOST[$url] = $fn;
    }

    public function comprobarRutas()
    {
        session_start();
        $auth = $_SESSION['login'] ?? null;
        $rutasProtegidas = ['/admin', '/vendedores/crear', '/vendedores/actualizar', '/vendedores/eliminar', '/propiedades/crear', '/propiedades/actualizar', '/propiedades/eliminar'];

        $urlActual = $_SERVER['REQUEST_URI'] ?? '/';
        if (strpos($urlActual, '?')) { // tuve que crear este if para que cuando sea un get, tome el redirect y no el request
            $urlActual = $_SERVER['REDIRECT_URL'];
        }

        $metodo = $_SERVER['REQUEST_METHOD'];

        // Obtiene la URL actual y la busca en el arreglo de RutasGET
        // Si no existe le asigna un valor NULL
        if ($metodo === 'GET') {
            $fn = $this->rutasGET[$urlActual] ?? null;
        } else if ($metodo === 'POST') {
            $fn = $this->rutasPOST[$urlActual] ?? null;
        }



        if (in_array($urlActual, $rutasProtegidas) && !$auth) {
            header('Location: /');
        }




        if ($fn) {
            // Si la URL si existe y tiene una función asociada entonces ejecuta la función
            call_user_func($fn, $this);   // Permite ejecutar una función 
        } else {
            header('Location: /');
        }
    }

    public function render($view, $arr = [])
    {
        foreach ($arr as $key => $value) {
            $$key = $value;
        }
        ob_start();
        include __DIR__ . "/Views/$view.php";

        $contenido = ob_get_clean();

        include __DIR__ . "/Views/layout.php";
    }
}
