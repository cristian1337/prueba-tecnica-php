<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <title>Prueba técnica</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Prueba</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav">
        <li class="nav-item active">
            <a class="nav-link" href="#">Productos</span></a>
        </li>
        <li class="nav-item active">
            <a class="nav-link" href="buscar-producto.php">Buscar Producto</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Informes</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Carrito</a>
        </li>
        </ul>
    </div>
    </nav>
    <div class="container row mt-4 ml-4">
        
            <?php 
                $data=json_decode(file_get_contents('http://localhost/prueba-tecnica/api/'));
                
                foreach ($data as $product) {
                    ?>
                    <div class="col-4 mb-3">
                        <div class="card" style="width: 20rem;">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $product->productName; ?></h5>
                                <h6 class="card-subtitle mb-2 text-muted"><?php echo $product->price; ?></h6>
                                <p class="card-text"><?php echo $product->productDescription; ?></p>
                                <a href="#" class="btn btn-primary card-link">Agregar al carito</a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            ?>
        
    </div>
    
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
</body>
</html>