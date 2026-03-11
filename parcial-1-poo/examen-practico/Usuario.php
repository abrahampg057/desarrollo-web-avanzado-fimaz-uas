<?php
class Usuario{
    private $nombre;
    private $correo;

    public function __construct($nombre, $correo) {
        $this->nombre = $nombre;
        $this->correo = $correo;

        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("El correo no tiene un formato valido");
        }

    }
}