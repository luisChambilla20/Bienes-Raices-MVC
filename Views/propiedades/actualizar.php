<main class="contenedor seccion">
    <h1>Actualizar</h1>

    <a href="/admin" class="boton boton-verde">volver</a>

    <?php foreach ($errores as $error) : ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>

    <form method="POST" class="formulario" enctype="multipart/form-data">

        <?php include __DIR__ . '/formulario.php' ?>

        <input type="submit" value="Actualizar propiedad" class="boton boton-verde">
    </form>
</main>