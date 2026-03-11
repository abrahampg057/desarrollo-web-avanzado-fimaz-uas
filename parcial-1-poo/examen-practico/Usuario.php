<?php
class Usuario{
    private $vnombre;
    private $vcorreo;

    public function __construct($vnombre, $vcorreo) {
        $this->nombre = $vnombre;
        $this->correo = $vcorreo;

        if (!filter_var($vcorreo, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("El correo no tiene un formato valido");
        }

    }

    public function getNombre() {
        return $this->nombre;
    }
    public function getCorreo() {
        return $this->correo;
    }
}
?>