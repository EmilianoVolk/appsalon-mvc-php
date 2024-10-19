<h1 class="nombre-pagina">Recupera tu contraseña</h1>
<p class="descripcion-pagina">Ingresa tu nueva contraseña</p>

<?php include_once __DIR__ . '/../templates/alertas.php' ?>

<?php if ($error) { 
    return;
} ?>
<form method="post" class="formulario">
    <div class="campo">
        <label for="password">Contraseña</label>
        <input type="password" id="password" placeholder="Ingresa la nueva contraseña" name="password">
    </div>
    <input type="submit" class="boton" value="Cambiar contraseña">
</form>

<div class="acciones">
    <a href="/">Ya tienes una cuenta?</a>
</div>