<?php
//USAREMOS LA SESION 


use Model\Propiedad;


$propiedades = Propiedad::all();
// $vendedores = Vendedor::all();


if ($_POST) {

    $id = $_POST['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    //VERIFICA QUE EL TIPO SEA VALIDO Y ELIMINA SEGUN PROPIEDAD O VENDEDOR
    if (verificarTipoEliminar($_POST['tipo'])) {
        if ($_POST['tipo'] === "propiedad") {
            $propiedad = Propiedad::forId($id);
            $propiedad->eliminarBD();
        } elseif ($_POST['tipo'] === "vendedor") {
            // $vendedor = Vendedor::forId($id);
            // $vendedor->eliminarBD();
        }
    } else {
        // header('Location: ./');
    }
}

?>
<main class="contenedor seccion">
    <h1>Administrar registros</h1>
    <?php $resultado =  enviarMensaje(intval($mensaje)) ?>


    <!-- -------------------------------------------------------------------- -->
    <!-- RETORNA EL ESTADO DEL GET -->
    <!-- -------------------------------------------------------------------- -->
    <?php if ($mensaje) : ?>
        <p class="alerta exito"><?= $resultado ?></p>
    <?php endif; ?>





    <!-- -------------------------------------------------------------------- -->
    <!-- SECCION DE PROPIEDADES -->
    <!-- -------------------------------------------------------------------- -->

    <h2>Propiedades</h2>
    <a href="/propiedades/crear" class="boton boton-verde">Nueva propiedad</a>
    <a href="/propiedades/actualizar" class="boton boton-amarillo">Registrar Vendedor(a)</a>

    <table class="propiedades">
        <thead>
            <tr>
                <th>ID</th>
                <th>Titulo</th>
                <th>Imagen</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <!-- IMPORTAMOS LAS PROPIEDADES DE LA BD -->
            <?php foreach ($propiedades as $propiedad) : ?>
                <tr>
                    <td><?php echo $propiedad->id; ?></td>
                    <td><?php echo $propiedad->titulo; ?></td>
                    <td><img class="imagen-tabla" src="../imagenes/<?php echo $propiedad->imagen; ?>" alt="Imagen"></td>
                    <td><?php echo $propiedad->precio; ?></td>
                    <td>
                        <form method="POST" action="/propiedades/eliminar">
                            <input type="hidden" name="id" value="<?php echo $propiedad->id; ?>">
                            <input type="hidden" name="tipo" value="propiedad">
                            <input type="submit" class="boton-rojo-block" value="Eliminar">
                        </form>
                        <a href="propiedades/actualizar?id=<?php echo $propiedad->id; ?>" class="boton-amarillo-block">Actualizar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</main>