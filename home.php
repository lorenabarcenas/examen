<!doctype html>
<html lang="es">
  <?php
require 'config/config.php';
?>
<head>
  <title>Title</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
</head>

<body style="background-color:rgb(255, 250, 205)" ;>
  <nav class="navbar navbar-expand-sm navbar-dark bg-warning">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">
        <img src="imagenes/avatar.jpg" alt="Avatar Logo" style="width:70px;" class="rounded-pill">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="mynavbar">


        <button type="button" class="btn btn-secondary " onclick="location.href='index1.php'">Ver catalogo</button>

      </div>

      <div class="btn-group">
        <button type="button" class="btn btn-success" onclick="location.href='registro.php'">Iniciar
          sesion/registrase</button>

        
        <button type="button" class="btn btn-warning" onclick="location.href='Contacto.php'">Contacto</button>
        <button type="button" class="btn btn-warning" onclick="location.href='cerrar.php'">Cerrar sesion</button>
      </div>
    </div>
  </nav>
  <br>
  <br>
  <form class="d-flex" action="" method="GET">
    <input class="form-control me-2" type="text" name="busqueda" placeholder="busqueda">
    <button class="btn btn-danger" type="submit" name="enviar" value="Buscar">buscar</button>
  </form>
  <div class="container">
    <?php
     
        
      include ('conexion.php');
      if(isset($_GET['enviar'])){
        $busqueda=$_GET['busqueda'];
        $sql=("SELECT id_pintura, precio, nombre, id_categoria, año_creacion, autor FROM productos where nombre LIKE'%$busqueda%' AND activo=1");
        $result=mysqli_query($db,$sql);
        $mostrar=mysqli_fetch_array($result);
        foreach($result as $mostrar){
          ?>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">

      <div class="col">
        <div class="card shadow-sm">
          <?php 
      
      $id = $mostrar['id_pintura'];
      $imagen="imagenes/producto/$id/1.jpg";
      
      ?>
          <img src="<?php echo $imagen; ?>" width="300px" heigth="400px">
          <div class="card-body">

            <h4> Nombre:
              <?php  echo $mostrar['nombre']?>
            </h4>
            <p> numero de identificacion:
              <?php  echo $mostrar['id_pintura']?>
            </p>
            <p> Autor:
              <?php  echo $mostrar['autor']?>
            </p>
            <p> Precio: $
              <?php  echo $mostrar['precio']?>
            </p>
            <p> Categoria:
              <?php  echo $mostrar['id_categoria']?>
            </p>
            <div class="d-flex  align-items-center">
              <div class="btn-group ">
              <?php echo KEY_TOKEN ?>
              <a href="detalles.php?id=<?php echo $mostrar['id_pintura'];?>&token=<?php echo hash_hmac('sha1',$mostrar['id_pintura'],KEY_TOKEN);?>" class="btn btn-primary">Detalles</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php
          }

      }
      ?>

<br>
<br>
<br>
    <h4 style="text-align:center">Categoria</h4>

    <?php
     include 'conexion.php';
    ?>
    <?php
    
      $sql=$db->query("SELECT  id_categoria, Descripcion FROM  catagoria;");
      if(isset($_GET['id_categoria']))
      {
         $id_categoria=$_GET['id_categoria'];
      
       
         $cate=$db->query("SELECT * FROM productos WHERE id_categoria=$id_categoria");
      }
    ?>

    <?php 

  while($row=$sql->fetch_array())
  {
    $id_categoria=$row[0];
    $categoria=$row[1];
    ?>

    <button class="btn btn-danger" type="text" name="enviar"
      onclick="location.href='home.php?id_categoria=<?php echo $id_categoria;?>'">
      <?php echo $categoria;?>
    </button>
    <?php
  }
  ?>
  <?php 
if(isset($cate)){


while($fila=$cate->fetch_array()){
 $nombre=$fila['nombre'];
 $pintura=$fila['id_pintura'];
 $autor=$fila['autor'];
 $precio=$fila['precio'];
 $categoria=$fila['id_categoria'];
 ?>
<h4> Nombre:
              <?php  echo $nombre?>
            </h4>
            <p> numero de identificacion:
              <?php  echo $pintura?>
            </p>
            <p> Autor:
              <?php  echo $autor?>
            </p>
            <p> Precio: $
              <?php  echo $precio?>
            </p>
            <p> Categoria:
              <?php  echo $categoria?>
            </p>
 <?php
}
}
?>


  





</body>

</html>