<?php

namespace Controllers;

use MVC\Router;
use Model\Propiedad;
use Model\Vendedor;
use Intervention\Image\ImageManagerStatic as Image;

class PropiedadController
{
    public static function index(Router $router)
    {
        $propiedad = Propiedad::all();
        $vendedor = Vendedor::all();

        $mensaje = $_GET['mensaje'] ?? null;

        $router->render('propiedades/admin', [
            "propiedades" => $propiedad,
            "vendedores" => $vendedor,
            "mensaje" => $mensaje
        ]);
    }
    public static function crear(Router $router)
    {
        $propiedad = new Propiedad();
        $vendedores = Vendedor::all();
        $errores = Propiedad::getErrores();


        if ($_POST) {
            // debug($_POST['propiedad']);
            $propiedad = new Propiedad($_POST['propiedad']);

            //Crear un nombre unico
            $nombreUnico = md5(uniqid(rand(), true)) . '.jpg';

            if ($_FILES['propiedad']['tmp_name']['imagen']) {
                //REALIZAMOS UN RESIZE
                $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800, 600);
                $propiedad->setImage($nombreUnico);
            }

            $errores = $propiedad->validar();

            //Verificar que no se tenga errores
            if (empty($errores)) {
                if (!is_dir(CARPETA_IMAGEN)) { //Verifica si existe la carpeta 
                    mkdir(CARPETA_IMAGEN);   //Crea la direccion de carpeta 
                }

                $image->save(CARPETA_IMAGEN . $nombreUnico);

                //Sube imagen al servidor
                $propiedad->guardar();
            }
        }

        $router->render('propiedades/crear', [
            "propiedad" => $propiedad,
            "vendedores" => $vendedores,
            "errores" => $errores
        ]);
    }
    public static function actualizar(Router $router)
    {
        $id = validarORedireccionar('/admin');
        $propiedad = Propiedad::forId($id);
        $errores = Propiedad::getErrores();
        $vendedores = Vendedor::all();


        if ($_POST) {

            $arg = $_POST['propiedad'];
            $propiedad->sincronizar($arg);

            $errores = $propiedad->validar();

            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

            if ($_FILES['propiedad']['tmp_name']['imagen']) {
                $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800, 600);
                $propiedad->setImage($nombreImagen);
            }


            //Verificar que no se tenga errores
            if (empty($errores)) {
                //ALAMCENRA IMAGEN
                if ($_FILES['propiedad']['tmp_name']['imagen']) {
                    $image->save(CARPETA_IMAGEN . $nombreImagen);
                }

                $propiedad->guardar();
            }
        }



        $router->render('propiedades/actualizar', [
            "propiedad" => $propiedad,
            "errores" => $errores,
            "vendedores" => $vendedores,
        ]);
    }
    public static function eliminar()
    {
        $id = $_POST['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        //VERIFICA QUE EL TIPO SEA VALIDO Y ELIMINA SEGUN PROPIEDAD O VENDEDOR
        if (verificarTipoEliminar($_POST['tipo'])) {
            if ($_POST['tipo'] === "propiedad") {
                $propiedad = Propiedad::forId($id);
                $propiedad->eliminarBD();
            } elseif ($_POST['tipo'] === "vendedor") {
                $vendedor = Vendedor::forId($id);
                $vendedor->eliminarBD();
            }
        } else {
            header('Location: /admin');
        }
    }
}
