<?php

require 'config/config.php';
require 'config/database.php';
$db = new Database();/*Instancia de esta clase*/
$conn = $db->conectar();

$id = isset($_GET['id']) ? $_GET['id']: '';
$token = isset($_GET['token']) ? $_GET['token']: '';
echo $id;
echo $token;
if($id == '' || $token == '')
{
    echo "Error al procesar la peticion";
    exit;
}else
{
    $token_tmp = hash_hmac('sha1',$id,KEY_TOKEN);
    if($token == $token_tmp)
    {
        $sql = $conn->prepare("SELECT count(id_pintura) FROM productos WHERE id_pintura=? AND activo=1");
        $sql->execute([$id]);
        if($sql->fetchColumn()>0)
        {
            $sql = $conn->prepare("SELECT nombre,precio,descripcion,descuento FROM productos WHERE id_pintura=? AND activo=1 LIMIT 1");
            $sql->execute([$id]);
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            $nombre = $row['nombre'];
            $precio = $row['precio'];
            $descripcion = $row['descripcion'];
            $descuento = $row['descuento'];
            $precio_desc = $precio -(($precio * $descuento) /100);
            $dir_img = 'img/pinturas/'.$id.'/';
            $rutaImg = $dir_img .'monja1.jpg';

            if(!file_exists($rutaImg))
            {
                $rutaImg = 'img/imagen.jpg';
            }

            $imagenes = array();
            if(file_exists($dir_img))
            {

            
            $dir = dir($dir_img);

            while(($archivo = $dir->read()) != false)
            {
                if($archivo != 'monja1.jpg' && (strpos($archivo,'jpg') || strpos($archivo,'jpeg')))
                {
                    $imagenes[]=$dir_img.$archivo;

                }
            }
            $dir->close();
        }
        $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        }
    }else
    {
        echo "Error al procesar la peticion";
        exit;
    }
}

/*$sql = $conn->prepare("SELECT id_pintura, nombre, autor, precio FROM productos WHERE id_pintura>0");
        $sql->execute();
        $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);*/

?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>PPCDSALVC</title>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
	<link href="css/estilos.css" rel="stylesheet">
</head>
<body>
<header data-bs-theme="dark">
      
  <div class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a href="#" class="navbar-brand">
        <strong>Tienda Online</strong>
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
				<a href="#" class="nav-link">Contacto</a>
			</li>
		</ul>
		<a href="verificar2.php" class="btn btn-primary">Carrito
        <span id="num_cart" class="badge bg-secondary"><?php  echo $num_cart; ?></span>
        </a>
	</div>
    </div>
  </div>
</header>

	<main>
	<div class="container">
        <div class="row">
            <div class="col-md-6 order-md-1">
                
            <div id="carouselImages" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
               
                <img src="<?php echo $rutaImg; ?>" class="d-block w-100">
             </div>

             <?php foreach($imagenes as $img) 
             {?>
             <div class="carousel-item">
             <img src="<?php echo $img; ?>" class="d-block w-100">
    
            </div>
            <?php } ?>

             </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselImages" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselImages" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
        </div>


              
            </div>
            <div class="col-md-6 order-md-2">
                <h2><?php echo $nombre; ?></h2>

                <?php 
                if($descuento > 0)
                {?>
                    <p><del><?php echo MONEDA .number_format($precio,2,'.',','); ?></del></p>
                    <h2>
                        <?php echo MONEDA .number_format($precio_desc,2,'.',','); ?>
                        <small class="text-success"><?php echo $descuento;?>% descuento</small>
                    </h2>
                    <?php } else
                    {?>
                        <h2>
                        <?php echo MONEDA .number_format($precio,2,'.',','); ?>
                    <?php
                    }?>
                

                
                <p class="lead">
                    <?php echo $descripcion; ?>
                </p>

                <div  class="d-grid gap-3 col-10 mx-auto">

                    <button class="btn btn-outline-primary" type="button" onclick="addProducto(<?php echo $id; ?>, '<?php echo $token_tmp; ?>')">Agregar al carrito</button>

            </div>
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