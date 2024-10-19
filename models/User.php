<?php

namespace Model;

class User extends ActiveRecord{
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'password', 'telefono', 'admin', 'confirmado', 'token'];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->admin = $args['admin'] ?? 0;
        $this->confirmado = $args['confirmado'] ?? 0;
        $this->token = $args['token'] ?? '';
    }

    public function validarNuevaCuenta(){
        if (!$this->nombre) {
            self::$alertas['error'][] = 'El nombre es obligatorio';
        }
        if (!$this->apellido) {
            self::$alertas['error'][] = 'El apellido es obligatorio';
        }
        if (!$this->email) {
            self::$alertas['error'][] = 'El email es obligatorio';
        }
        if (!$this->password || strlen($this->password) < 6) {
            self::$alertas['error'][] = 'Debes agregar una contraseña de minimo 10 caracteres';
        }
        if (!$this->telefono) {
            self::$alertas['error'][] = 'Debes agregar un numero de telefono';
        } elseif(strlen($this->telefono) !== 10){
            self::$alertas['error'][] = 'El numero de telefono debe contener almenos 10 digitos';
        }
        return self::$alertas;
    }

    public function validarLogin(){
        if (!$this->email) {
            self::$alertas['error'][] = 'El email es obligatorio';
        }
        if (!$this->password) {
            self::$alertas['error'][] = 'Ingresa la contraseña';
        }
    }

    public function validarEmail(){
        if (!$this->email) {
            self::$alertas['error'][] = 'El email es obligatorio';
        }
    }

    public function validarPassword(){
        if (!$this->password) {
            self::$alertas['error'][] = 'El password es obligatorio';
        }
        if (strlen($this->password) < 6) {
            self::$alertas['error'][] = 'El password debe contender almenos 6 caracteres';
        }

        return self::$alertas;
    }

    public function existeUser(){
        $query = "SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";
        $resultado = self::$db->query($query);
        if ($resultado->num_rows) {
            self::$alertas['error'][] = 'El usuario ya existe';
        }
        return $resultado;
    }

    public function hashPassword(){
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function crearToken(){
        $this->token = uniqid();
    }

    public function comprobarPasswordVerificacion($password, $findEmail){

        $user = $this->where('email', $findEmail);

        if ($user) {
            $verificacionPassword = password_verify($password, $user->password);
            if ($verificacionPassword === true) {
                if ($user->confirmado) {
                    return true;
                } else {
                    self::setAlerta('error', 'Usuario no Confirmado');
                }

            } else {
                self::setAlerta('error', 'Contraseña incorrecta');
            }
        } else{
            self::setAlerta('error', 'Usuario no encontrado');
        }
    }
}
