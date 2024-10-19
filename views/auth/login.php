<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Inicia sesion con tus datos</p>


<?php include_once __DIR__ . '/../templates/alertas.php'; ?>

<form class="formulario" method="post" action="/">
    <div class="campo">
        <label for="email">Email</label>
        <input type="email" id="email" placeholder="Tu email" name="email" value="<?php echo $auth->email ?>">
    </div>

    <div class="campo">
        <label for="password">Password</label>
        <input type="password" id="email" placeholder="Tu Contraseña" name="password">
    </div>
    <input type="submit" class="boton">
</form>

<div class="acciones">
    <a href="/create-account">Aun no tienes una cuenta? Crea una</a>
    <a href="/forgot">Olvidaste tu contraseña?</a>
</div>