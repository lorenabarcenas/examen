<?php
$nombre=$_POST['nombre'];
$asunto=$_POST['asunto'];
$telefono=$_POST['telefono'];
$mensaje=$_POST['mensaje'];


include ('conexion.php');
$consulta="INSERT INTO contacto values('', '$nombre', '$asunto', '$telefono','$mensaje')";
$resultado=mysqli_query($db, $consulta);
if($resultado){
    echo "datos enviados correctamente";
}