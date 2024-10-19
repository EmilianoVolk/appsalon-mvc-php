<h1 class="nombre-pagina">Olvidase tu contraseña?</h1>
<p class="descripcion-pagina">Ingresa tu correo</p>

<?php include_once __DIR__ . '/../templates/alertas.php' ?>

<form action="/forgot" class="formulario" method="post">
    <div class="campo">
        <label for="email">Email</label>
        <input type="email" placeholder="Tu email" id="email" name="email">
    </div>
    <input type="submit" class="boton" value="Enviar instrucciones">
</form>

<div class="acciones">
    <a href="/">Ya tienes una cuenta?</a>
    <a href="/create-account">Aun no tienes una cuenta? Crea una</a>
</div>