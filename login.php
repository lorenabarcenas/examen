<?php
session_start();

$ema = $_POST['username'];
$contra = $_POST['password'];


?>
<?php
require 'Conexion.php';
?>

<?php
$Correo=$_POST['correo'];
$Psw=$_POST['psw'];



//validaar Login
$validaLogin = mysqli_query($db, "SELECT * FROM registro WHERE email='$Correo' and psw='$Psw'");
if(mysqli_num_rows($validaLogin)>0)
{
$_SESSION['session'] = $Correo;
    Header("Location:home.php");
    ?><h2 class="success">usuario encontrado</h2>
    <?php
    
    exit();
}
else{

    ?><h2 class="success">Este Usuario no existe</h2>
    <?php
}




?>