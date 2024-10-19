<?php

require_once __DIR__ . '/../includes/app.php';

use Controller\AdminController;
use Controller\APIController;
use Controller\CitaController;
use Controller\LoginController;
use Controller\ServicioController;
use MVC\Router;


$router = new Router();

//Login
$router->get('/', [LoginController::class, 'login']);
$router->get('/forgot', [LoginController::class, 'forgot']);
$router->get('/recover', [LoginController::class, 'recover']);
$router->get('/create-account', [LoginController::class, 'create']);
$router->get('/confirm', [LoginController::class, 'confirm']);
$router->get('/message', [LoginController::class, 'message']);
$router->post('/', [LoginController::class, 'login']);
$router->post('/forgot', [LoginController::class, 'forgot']);
$router->post('/recover', [LoginController::class, 'recover']);
$router->post('/create-account', [LoginController::class, 'create']);
$router->post('/confirm', [LoginController::class, 'confirm']);
$router->post('/logout', [LoginController::class, 'logout']);


//Area Privada
$router->get('/cita', [CitaController::class, 'index']);
$router->get('/admin', [AdminController::class, 'index']);

//APIS
$router->get('/api/servicios', [APIController::class, 'index']);
$router->post('/api/citas', [APIController::class, 'guardar']);
$router->post('/api/eliminar', [APIController::class, 'eliminar']);

//CRUD de Servicios
$router->get('/servicios',[ServicioController:: class, 'index']);
$router->get('/servicios/crear',[ServicioController:: class, 'crear']);
$router->post('/servicios/crear',[ServicioController:: class, 'crear']);
$router->get('/servicios/actualizar',[ServicioController:: class, 'actualizar']);
$router->post('/servicios/actualizar',[ServicioController:: class, 'actualizar']);
$router->post('/servicios/eliminar',[ServicioController:: class, 'eliminar']);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();