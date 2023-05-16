<!doctype html>
<html lang="en">
<?php
include ('conexion.php');
?>
<head>
  <title>Title</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>
<style>
  .fondo {
    background-image: url(fondo.jpg);
    height: 900px;


  }
</style>

<body>
  <div class="fondo">
    <div class="d-flex justify-content-center">
      <div class="container mt-5">
        <div class="row">
          <div class="col-md-5">

            <h1>CONTACTO</h1>
            <br>
            <?php 
   
?>
<?php  include ('conexion.php') ;?>
<div class="container mt-5">
                    <div class="row"> 
                  
                        <div class="col-md-8">
                            
                          
                                <form action="configuracion.php" method="POST">
                                     
                                     <input type="text" class="form-control mb-3" name="nombre" placeholder="nombre"> 
                                     <input type="text" class="form-control mb-3" name="asunto" placeholder="asunto">
                                     <input type="text" class="form-control mb-3" name="telefono" placeholder="telefono">      
                                     <input type="text" class="form-control mb-3" name="mensaje" placeholder="mensaje">                                  
                                     <input type="submit" class="btn btn-primary">
                                </form>
                        </div>
          </div>
        </div>
      </div>
</body>

</html>