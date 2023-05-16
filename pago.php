<?php

require 'config/config.php';
require 'config/database.php';
$db = new Database();/*Instancia de esta clase*/
$conn = $db->conectar();

$productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos']: null;
/*print_r($_SESSION);*/

$lista_carrito = array();
if($productos != null)
{
    foreach($productos as $clave => $cantidad)
    {
        $sql = $conn->prepare("SELECT id_pintura, nombre, precio ,descuento, $cantidad AS cantidad FROM productos WHERE id_pintura=? AND activo=1");
        $sql->execute([$clave]);
        $lista_carrito[] = $sql->fetch(PDO::FETCH_ASSOC);
    }
}else
{
    header("Location: index1.php");
    exit;
}




/*session_destroy();*/
/*print_r($_SESSION);/*arreglo de sesion en php*/

?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
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
		<a href="carrito.php" class="btn btn-primary">Carrito
        <span id="num_cart" class="badge bg-secondary"><?php  echo $num_cart; ?></span>
        </a>
	</div>
    </div>
  </div>
</header>

	<main>
	<div class="container">
	
    <div class="row">
        <div class="col-6">
            <h4> Detalles de pago</h4>
            <div id="paypal-button-container"></div>
        </div>

        <div class="col-6">
	<div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if($lista_carrito == null)
                {
                    echo '<tr><td colspan="5" class="text-center"><b>Lista Vacia</b></td></tr>';
                }else
                {
                    $total = 0;
                    foreach($lista_carrito as $producto)
                    {
                       $_id = $producto['id_pintura'];
                        $nombre = $producto['nombre'];
                        $precio = $producto['precio'];
                        $descuento = $producto['descuento'];
                        $cantidad = $producto['cantidad'];
                        $precio_desc = $precio -(($precio * $descuento) / 100);
                        $subtotal = $cantidad * $precio_desc;
                        $total += $subtotal;
                    ?>
                
                <tr>
                    <td><?php echo $nombre; ?></td>
 
                    
                    <td>
                        <div id="subtotal_ <?php echo $_id;?>" name="subtotal[]"><?php echo MONEDA .number_format($subtotal,2,'.',','); ?>
                        </div>
                    </td>
                    
                </tr>
                <?php } ?>

                <tr>
                   
                    <td colspan="2"></td>
                    <p class="h3 text-end" id="total"><?php echo MONEDA .number_format($total,2, '.', ',');?>
                    </p>
                    </td>
                </tr>
            </tbody>
            <?php } ?>

        </table> 

	</div>

                       
                    </div>
                    </div>
                    </div>
                    
	</main>

   

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

	<script src="https://www.paypal.com/sdk/js?client-id=<?php echo CLIENT_ID; ?>&currency=<?php echo CURRENCY; ?>  "></script>

    <script>
        paypal.Buttons(
            {
                style:
                {
                    color:'blue',
                    shape:'pill',
                    label:'pay'
                },
                createOrder:function(data,actions)
                {
                    return actions.order.create(
                        {
                            purchase_units:
                            [
                                {
                                    amount:
                                    {
                                        value: <?php echo $total;?>
                                    }
                                }
                            ]
                        });
                },
                onApprove:function(data, actions)
                {
                    let URL ='clases/captura.php'
                    actions.order.capture().then(function(detalles)
                    {
                       console.log(detalles);
                       window.location.href="completado.html"

                       return fetch(URL, 
                       {
                        method: 'POST',
                        headers: 
                        {
                            'content-type':'application/json'
                        },
                        body: JSON.stringify(
                            {
                                detalles:detalles
                            }
                        )
                       })
                       
                      
                    });
                    
                },
                onCancel:function(data)
                {
                    alert("Pago cancelado")
                    console.log(data);
                }
            }
        ).render('#paypal-button-container');
    </script>

</body>
</html>