<?php


define('TEMPLATES_URL', __DIR__ . '/templates');
define('FUNCIONES_URL', __DIR__ . 'funciones.php');
define('CARPETA_IMAGEN', $_SERVER['DOCUMENT_ROOT'] . 'imagenes/');


function incluirTemplate(string  $nombre, bool $inicio = false)
{
    include TEMPLATES_URL . "/{$nombre}.php";
}

function autenticado()
{
    session_start();
    if (!$_SESSION['login']) {
        header('Location: ./../');
    }
}

function debug($variable)
{
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

function s($html): string
{
    $s = htmlspecialchars($html);
    return $s;
}

function verificarTipoEliminar($tipo)
{
    $todo = ['propiedad', 'vendedor'];
    return in_array($tipo, $todo);
}

function enviarMensaje($caso)
{
    $mensaje = '';
    switch ($caso) {
        case 1:
            $mensaje = 'Creado correctamente';
            break;
        case 2:
            $mensaje = 'Actualizado correctamente';
            break;
        case 3:
            $mensaje = 'Eliminado correctamente';
            break;
        default:
            $mensaje = false;
            break;
    }

    return $mensaje;
}

function ValidaroRedireccionar(String $url)
{
    $id = $_GET['id'] ;
    $id = filter_var($id, FILTER_VALIDATE_INT); //VERIFICAR FORMATO DE LAS CONSULTAS

    if (!$id) {
        header("Location: {$url}");
    }
    return $id;
}
