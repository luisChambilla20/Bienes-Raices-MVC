<?php

namespace Model;

class Admin extends ActiveRecord
{
    protected static $tabla = 'usuarios';
    protected static $columnaDB = ['idusuarios', 'email', 'password'];

    public $idusuarios;
    public $email;
    public $password;

    public function __construct($arg = [])
    {
        $this->idusuarios = $arg['id'] ?? null;
        $this->email = $arg['email'] ?? '';
        $this->password = $arg['password'] ?? '';
    }

    public function validar()
    {
        if (!$this->email) {
            self::$errores[] = 'Email es obligatorio';
        }
        if (!$this->password) {
            self::$errores[] = 'Password es obligatorio';
        }
        return self::$errores;
    }

    public function exiteUsuario()
    {
        $query = "SELECT * FROM usuarios WHERE email ='" . $this->email . "'";
        $resultado = self::$db->query($query);

        if (!$resultado->num_rows) {
            self::$errores[] = 'EL usuario no existe';
            return;
        }

        return $resultado;
    }

    public function validarPassword($resultado)
    {
        $usuario = $resultado->fetch_object();
        $autenticado = password_verify($this->password, $usuario->password);

        if (!$autenticado) {
            self::$errores[] = 'La contraseña es incorrecta';
        }

        return $autenticado;
    }

    public function session()
    {
        session_start();
        $_SESSION['usuario'] = $this->email;
        $_SESSION['login'] = true;

        header('Location: /admin');
    }
}
