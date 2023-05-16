<?php
/**
 * Nombre del archivo: cerrar.php
 * Autor: Alex Antonio Suárez Sánchez
 * Fecha de creación: martes 25 de abril del 2023
 */
session_start();
session_destroy();
header("location:home.php");

?>
