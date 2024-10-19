<?php 

namespace Controller;

use Model\AdminCita;
use MVC\Router;

class AdminController {
    public static function index(Router $router){
        session_start();

        isAdmin();

        $fecha = $_GET['fecha'] ?? date('Y-m-d');
        $fechas = explode('-', $fecha);
        
        $dateCheck = checkdate($fechas[1], $fechas[2], $fechas[0]);
        $dateCheck ? $fecha : $fecha = date('Y-m-d');

        

        //Consultar la base de datos
        $consulta = "SELECT citas.id,  citas.hora, concat(usuarios.nombre, ' ', usuarios.apellido) as cliente, ";
        $consulta .= "usuarios.email, usuarios.telefono, servicios.nombre as servicio, servicios.precio ";
        $consulta .= "FROM citas ";
        $consulta .= "INNER JOIN usuarios ";
        $consulta .= "ON citas.usuarioId=usuarios.id ";
        $consulta .= "INNER JOIN citasservicios ";
        $consulta .= "ON citasServicios.citasId=citas.id ";
        $consulta .= "INNER JOIN servicios ";
        $consulta .= "ON servicios.id=citasservicios.serviciosId ";
        $consulta .= " WHERE fecha = '$fecha' ";

        $citas = AdminCita::SQL($consulta);


        $id = new AdminCita();
        

        $router->render('/admin/index', [
            'nombre' => $_SESSION['nombre'],
            'citas' => $citas,
            'fecha' => $fecha
        ]);
    }
}