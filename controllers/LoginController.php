<?php

namespace Controller;

use Classes\Email;
use MVC\Router;
use Model\User;

class LoginController{
    public static function login(Router $router){
        $user = new User();//Instancia vacia

        $alertas = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //Crea una nueva instancia y llena correo y password en auth
            $auth = new User($_POST); 

            //Valida correo y password
            $alertas = $auth->validarLogin();        

            //Si ingreso correo y password
            if(empty($alertas)){
                //buscamos si email existe y guardamos en user (se llena la instancia)
                $verificacion = $auth->comprobarPasswordVerificacion($auth->password, $auth->email);
                if ($verificacion) {
                    session_start();
                    $user = $auth->where('email', $auth->email);
                    $_SESSION['id'] = $user->id;
                    $_SESSION['nombre'] = $user->nombre . ' ' . $user->apellido;
                    $_SESSION['email'] = $user->email;
                    $_SESSION['login'] = true;
                    
                    
                    if ($user->admin === '1') {
                        $_SESSION['admin'] = $user->admin ?? null;
                        header('Location: /admin');
                    
                    } else {
                        header('Location: /cita');
                    }
                }

            } 
        }

        $alertas = User::getAlertas();
        $router->render('auth/login',[
            'auth' => $auth,
            'alertas' => $alertas
        ]);
    }
    public static function logout(Router $router){
        session_start();
        $_SESSION = [];
        header('Location: /');
    }
    
    public static function forgot(Router $router){
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = new User($_POST);
            $alertas = $user->validarEmail();

            if (empty($alertas)) {
                $auth = $user->where('email', $user->email);

                if ($auth && $auth->confirmado === '1') {
                    $auth->crearToken();
                    $auth->guardar();

                    //Enviar Email
                    $email = new Email($auth->email, $auth->nombre, $auth->token);
                    $email->forgotPassword();

                    User::setAlerta('exito', 'Revisa tu correro electronico');

                } else{
                    $user->setAlerta('error', 'Usuario no encontrado o Usuario no verificado');
                }
            }

            // $email = new Email($user->email, $user->nombre, $user->token);
            // $email->enviarConfirmacion();

            // debuguear($user);
        }

        $alertas = User::getAlertas();
        $router->render('auth/forgot', [
            'alertas' => $alertas
        ]);
    }
    public static function recover(Router $router){
        $token = s($_GET['token']);
        $auth = User::where('token', $token);

        $alertas = [];
        $error = false;


        if (empty($auth)) {
            $alertas = User::setAlerta('error', 'Token no valido');
            $error = true;
        }
      
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = new User($_POST);
            $alertas = $password->validarPassword();

            if (empty($alertas)) {
                $auth->password = null;

                $auth->password = $password->password;
                $auth->hashPassword();
                $auth->token = null;

                $resultado = $auth->guardar();
                if ($resultado) {
                    header('Location: /');
                }

                debuguear($auth);
            }


            
            // $find = $user->where('token', $token);
            
        }


        $alertas = User::getAlertas();
        $router->render('auth/recover', [
            'alertas' => $alertas,
            'error' => $error
        ]);
    }
    public static function create(Router $router){
        $user = new User();
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user->sincronizar($_POST);
            $alertas = $user->validarNuevaCuenta();

            if (empty($alertas)) {
                $resultado = $user->existeUser();
                if ($resultado->num_rows) {
                    $alertas = User::getAlertas();
                } else {
                    //Hashear el password
                    $user->hashPassword();

                    //Generar un token unico
                    $user->crearToken();

                    //Enviar el Email
                    $email = new Email($user->email, $user->nombre, $user->token);
                    $email->enviarConfirmacion();

                    //Crear el User
                    $resultado = $user->guardar();
                    if ($resultado) {
                        header('Location: /message');
                    }
                }

            }
        }
        $router->render('auth/create',[
            'user' => $user,
            'alertas' => $alertas
        ]);
    }

    public static function message(Router $router){
        $router->render('auth/message', []);
    }

    public static function confirm(Router $router){
        $alertas = [];
        $token = s($_GET['token']);
        $user = User::where('token', $token);

        if (empty($user)) {
            User::setAlerta('error', 'Token no valido');
        } else {
            $user->confirmado = '1';
            $user->token = null;
            $user->guardar();

            User::setAlerta('exito', 'Su cuenta ha sido verificada correctamente');
        }

        $alertas = User::getAlertas();
        $router->render('auth/token',[
            'alertas' => $alertas
        ]);
    }
}

