<?php
//USAREMOS LA SESION 

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
    <a href="/vendedores/crear" class="boton boton-amarillo">Registrar Vendedor(a)</a>

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


    <!-- -------------------------------------------------------------------- -->
    <!-- SECCION DE VENDEDORES -->
    <!-- -------------------------------------------------------------------- -->
    <h2>Vendedores</h2>
    <table class="propiedades">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Telefono</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <!-- IMPORTAMOS LAS PROPIEDADES DE LA BD -->
            <?php foreach ($vendedores as $vendedor) : ?>
                <tr>
                    <td><?php echo $vendedor->id; ?></td>
                    <td><?php echo $vendedor->nombre . " " . $vendedor->apellido; ?></td>
                    <td><?php echo $vendedor->telefono; ?></td>
                    <td>
                        <form method="POST" action="/vendedores/eliminar">
                            <input type="hidden" name="id" value="<?php echo $vendedor->id; ?>">
                            <input type="hidden" name="tipo" value="vendedor">
                            <input type="submit" class="boton-rojo-block" value="Eliminar">
                        </form>
                        <a href="vendedores/actualizar?id=<?php echo $vendedor->id; ?>" class="boton-amarillo-block">Actualizar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</main>