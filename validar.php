<?php
require 'Conexion.php';

$id=$_POST['id'];
$Nombre=$_POST['nombre'];
$Apellidos=$_POST['apellidos'];
$Correo=$_POST['correo'];
$Telefono=$_POST['telefono'];
$Direccion=$_POST['direccion'];
$Usuario=$_POST['usuario'];
$Psw=$_POST['psw'];



$sql="INSERT INTO registro VALUES('$id ','$Nombre','$Apellidos','$Correo','$Telefono','$Direccion','$Usuario','$Psw')";

//verificar que no haya correo repetido
$verificarCorreo= mysqli_query($db, "SELECT * FROM registro WHERE email='$Correo'");
if(mysqli_num_rows($verificarCorreo) > 0)
{

    ?><h2 class="success">Este correo ya esta regisstrado</h2>
    <?php

    exit();
}
//verificar usuario repetido
$verificarUsuario= mysqli_query($db, "SELECT * FROM registro WHERE usuario='$Usuario'");
if(mysqli_num_rows($verificarUsuario) > 0)
{

    ?><h2 class="success">Este Usuario ya esta regisstrado</h2>
    <?php

    exit();
}



$query= mysqli_query($db,$sql);

if($query){
    Header("Location:home.php");
    ?><h2 class="success">Registro Éxitoso</h2>
    <?php

    
}else {
    echo "Error: ".$sql. ":". mysqli_error($conn);
}


?>

