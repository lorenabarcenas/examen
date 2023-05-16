
<?php

require 'config/config.php';
require 'config/database.php';
$db = new Database();/*Instancia de esta clase*/
$conn = $db->conectar();/*id_pintura>0 */ 
$sql = $conn->prepare("SELECT id_pintura, nombre, autor, precio FROM productos WHERE activo=1");
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

/*session_destroy();*/
//print_r($_SESSION);/*arreglo de sesion en php*/

?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>PPCDSALVC</title>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
	<link href="css/estilos.css" rel="stylesheet">
</head>
<body>
<header data-bs-theme="dark">
      
  <div class="navbar navbar-expand-lg navbar-dark bg-danger">
    <div class="container">
      <a href="#" class="navbar-brand">
        <strong>Pinturas</strong>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
	<div class="collapse navbar-collapse" id="navbarHeader">
		<ul class="navbar-nav me-auto mb-2 mb-lg-0">
			<li class="nav-item">
				<a href="#" class="nav-link active">Catalogo</a>
			</li>
			<li class="nav-item">
				<a href="home.php" class="nav-link">Home</a>
			</li>
		</ul>
		<a href="verificar2.php" class="btn btn-success">Carrito
        <span id="num_cart" class="badge bg-secondary"><?php  echo $num_cart; ?></span>
        </a>
	</div>
    </div>
  </div>
</header>

	<main>
	<div class="container">
	<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
		<?php
		foreach($resultado as $row)
		{?>

		
	<div class="col">
	<div class="card shadow-sm">
		<?php
		$id = $row['id_pintura'];
		$imagen = "imagenes/producto/$id/1.jpg";
		if(!file_exists($imagen))
		{
			$imagen = "img/sinFoto.jpg";
		}
		?>
            <img src="<?php echo $imagen;?>" >
            <div class="card-body">
			<h5 class="card-title"><?php echo $row['nombre'];?></h5>
              <p class="card-text">$<?php echo number_format($row['precio'],2,'.',',');?></p>
			  <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                <?php echo KEY_TOKEN ?>
                  <a href="detalles.php?id=<?php echo $row['id_pintura'];?>&token=<?php echo hash_hmac('sha1',$row['id_pintura'],KEY_TOKEN);?>" class="btn btn-primary">Detalles</a>
				  
                </div>

                <button class="btn btn-outline-success" type="button" onclick="addProducto(<?php echo $row['id_pintura']; ?>, '<?php echo hash_hmac('sha1',$row['id_pintura'],KEY_TOKEN);?>')">Agregar al carrito</button>
              </div>
            </div>
			</div>
			
            </div>
			<?php }?>
	</div>
	</div>
	</main>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<?php


error_reporting(0);
$msj = $_SESSION['session'];
if ($msj == null) {
    echo"Error sin iniciar sesion";
    Header("Location: home.php");
    exit();
    
}else{
?>

<script>
        function addProducto(id, token)
        {
            let url = 'clases/carrito.php'
            let formData = new FormData()
            formData.append('id', id)
            formData.append('token', token)

            fetch(url,
            {
                method:'POST',
                body: formData,
                mode: 'cors'
            }).then(response => response.json()).then(data => 
            {
                if(data.OK)
                {
                    let elemento = document.getElementById("num_cart")
                    elemento.innerHTML = data.numero
                }
            })
        }
    </script>
<?php

}
?>


</body>
</html>