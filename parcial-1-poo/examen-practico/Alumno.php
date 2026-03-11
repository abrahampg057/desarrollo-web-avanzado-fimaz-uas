<?php
require_once "Usuario.php";

class Alumno extends Usuario {

    private $vmatricula;

    public function __construct($vnombre, $vcorreo, $vmatricula) {
        parent::__construct($vnombre, $vcorreo);
        $this->matricula = $vmatricula;
    }

}