<h1 class="nombre-pagina">Crear Cuenta</h1>
<p class="descripcion-pagina">Ingresa tus datos para crear una cuenta</p>

<?php include_once __DIR__ . '/../templates/alertas.php' ?>

<form action="/create-account" class="formulario" method="post">
    <div class="campo">
        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" placeholder="Tu nombre" name="nombre" value="<?php echo s($user->nombre) ?>">
    </div>
    <div class="campo">
        <label for="apellido">Apellido</label>
        <input type="text" id="apellido" placeholder="Tu apellido" name="apellido" value="<?php echo s($user->apellido) ?>">
    </div>
    <div class="campo">
        <label for="telefono">Telefono</label>
        <input type="tel" id="telefono" placeholder="Tu telefono" name="telefono" value="<?php echo s($user->telefono) ?>">
    </div>
    <div class="campo">
        <label for="correo">Correo</label>
        <input type="email" id="correo" placeholder="Tu correo" name="email" value="<?php echo s($user->email) ?>">
    </div>
    <div class="campo">
        <label for="password">Password</label>
        <input type="password" id="password" placeholder="Crea una contraseña" name="password">
    </div>
    <input type="submit" class="boton" value="Crear cuenta">
</form>

<div class="acciones">
    <a href="/">Ya tienes una cuenta?</a>
    <a href="/forgot">Olvidaste tu contraseña?</a>
</div>