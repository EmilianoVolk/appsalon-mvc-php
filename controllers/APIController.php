<?php 
namespace Controller;

use Model\Cita;
use Model\CitaServicio;
use Model\Servicio;

class APIController{
    public static function index(){
        $servicios = Servicio::all();
        echo(json_encode($servicios));
    }

    public static function guardar(){
        
        //Almacena la cita y devuelve el ID
        $cita = new Cita($_POST);
        $resultado = $cita->guardar(); 

        $id = $resultado['id'];

        //Almacena las citas y el servicio

        $idServicios = explode(",", $_POST['servicios']);

        foreach ($idServicios as $idServicio) {
            $args = [
                'citasId' => $id,
                'serviciosId' => $idServicio
            ];
            
            $citaServicio = new CitaServicio($args);

            $citaServicio->guardar();
        }
 
        //Retonamos una respuesta
        $respuesta = [
            'resultado' => $resultado
        ];

        echo json_encode($respuesta);
    }

    public static function eliminar(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $cita = Cita::find($id);
            $cita->eliminar();

            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
    }
}