<h1 class="nombre-pagina">Panel de Administracion</h1>

<?php include_once __DIR__ . '/../templates/barra.php' ?>

<h2>Buscar Citas</h2>
<div class="busqueda">
    <form class="formulario">
        <div class="campo">
            <label for="fecha">Fecha</label>
            <input type="date" id="fecha" name="fecha" value="<?php echo $fecha ?>">
        </div>
    </form>
</div>

<?php 
    if (count($citas) == 0) {
        echo '<h2 class="titulo-fecha">No hay citas</h2>';
    } else{
        echo '<h2 class="titulo-fecha">Citas del dia ' . $fecha . '</h2>';
    }
?>

<div id="citas-admin">
    <ul class="citas">
        <?php
        $idCita = '';
        foreach ($citas as $key => $cita) :

            if ($idCita !== $cita->id) { 
                $total = 0; ?>
                <li>
                    <p>ID: <span><?php echo $cita->id ?></span></p>
                    <p>Hora: <span><?php echo $cita->hora ?></span></p>
                    <p>Cliente: <span><?php echo $cita->cliente ?></span></p>
                    <p>Email: <span><?php echo $cita->email ?></span></p>
                    <p>telefono: <span><?php echo $cita->telefono ?></span></p>

                    <h3>Servicios</h3>
                <?php
                    $idCita = $cita->id;
                } //Fin del if 
                    $total += $cita->precio;
                ?>
                    <p class="servicio"><?php echo $cita->servicio . ' ' . $cita->precio ?></p>
                    <?php 
                        $actual = $cita->id;
                        $proximo = $citas[$key + 1]->id ?? 0;
                        
                        if (last($actual, $proximo)) { ?>
                            <p class="total">Total: <span> <?php echo '$' . $total ?> </span></p>
                            <form action="/api/eliminar" method="post">
                                <input type="hidden" name="id" value="<?php echo $cita->id ?>">
                                <input type="submit" value="Eliminar" class="boton-eliminar">
                            </form>
                       <?php } ?>
                    <?php endforeach;
            ?>
            </li>
    </ul>
</div>

<?php 
    $script = '<script src="build/js/buscador.js"></script>'
?>