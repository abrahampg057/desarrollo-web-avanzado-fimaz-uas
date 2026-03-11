<?php

require_once "Usuario.php";
require_once "Admin.php";
require_once "Alumno.php";

$objusuarios = [];

try {
  
    $objadmin = new Admin("Carlos Lopez", "carlos@email.com");
    $objusuarios[] = $objadmin;

    $objalumno = new Alumno("Ana Torres", "ana@email.com", "A12345");
    $objusuarios[] = $objalumno;

    $objlumnoInvalido = new Alumno("Pedro Ruiz", "correo_invalido", "A54321");
    $objusuarios[] = $objalumnoInvalido;

} catch (Exception $e) {
    echo "<p style='color:red;'>Error: " . $e->getMessage() . "</p>";
}

?>