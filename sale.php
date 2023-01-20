<?php 
require'./config/config.php';
require'./db/conexion.php';

$pdo = new conexion();

$productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;
$listaProducts = array();

if($productos != null){
    foreach($productos as $clave => $cantidad){
        $sql = $pdo->prepare("SELECT idProduct, productName, price, $cantidad AS cantidad FROM product WHERE idProduct=?");
        $sql->execute([$clave]);
        $listaProducts[] = $sql->fetch(PDO::FETCH_ASSOC);
    }
}
?>
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
    <a class="navbar-brand" href="index.php">Prueba</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="index.php">Productos</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="buscar-producto.php">Buscar Producto</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Informes</a>
            </li>
        </ul>

        <span class="btn btn-primary">
            <a><span class="badge bg-secondary" id="cartNum"><?php echo $numCart; ?></span> Carrito</a>
        </span>
    </div>
    </nav>
    <div class="container row mt-4 ml-4">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($listaProducts == null){
                        echo '<tr><td colspan="5" class=""text-center><b>Lista vacia</b></td></tr>';
                    } else {
                        $total = 0;
                        foreach($listaProducts as $product){
                            $id = $product['idProduct'];
                            $nombre = $product['productName'];
                            $precio = $product['price'];
                            $cantidad = $product['cantidad'];
                            
                            if($cantidad >= 5){
                                $subtotal = ($cantidad * $precio)-(($cantidad * $precio)*0.1);
                                $total += $subtotal;
                            } else {
                                $subtotal = $cantidad * $precio;
                                $total += $subtotal;
                            }
                        ?>
                        <tr>
                            <td><?php echo $nombre ?></td>
                            <td><?php echo '$'.number_format($precio, 0, '.', '.'); ?></td>
                            <td>
                                <input type="number" min="1" max="20" step="1" value="<?php echo $cantidad; ?>" size="5" id="cantidad_<?php echo $id; ?>" onchange="actualizarCantidad(this.value, <?php echo $id; ?>)">
                            </td>
                            <td><div id="subtotal_<?php echo $id; ?>" name="subtotal[]"><?php echo '$'.number_format($subtotal, 0, '.', '.'); ?></div></td>
                            <td><a href="#" id="eliminar" class="btn btn-warning btn-sm" data-bs-id="<?php echo $id; ?>" data-bs-toogle="modal" data-bs-target="eliminar-modal">Eliminar</a></td>
                        </tr>
                        <?php } ?>
                    <?php } ?>
                    <tr>
                        <td colspan="3"></td>
                        <td colspan="2"><p class="h3" id="total"><?php echo'$'.number_format($total, 0, '.', '.'); ?></p></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="row">
            <a class="btn btn-success">Finalizar compra</a>
        </div>
    </div>
    
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
<script>
    function actualizarCantidad(cantidad, idProduct) {
        let url = 'clases/actualizarCarrito.php'
        let formData = new FormData()
        formData.append('id', idProduct)
        formData.append('cantidad', cantidad)
        formData.append('action', 'agregar')

        fetch(url, {
            method: 'POST',
            body: formData,
            mode: 'cors',

        }).then(response => response.json())
        .then(data => {
            if(data.ok) {
                let subtotal = document.getElementById(`subtotal_${idProduct}`)
                subtotal.innerHTML = data.sub

                let total = 0
                let listSub = document.getElementsByName('subtotal[]')

                for (let index = 0; index < listSub.length; index++) {
                    total += parseInt(listSub[index].innerHTML.replace(/[$.]/g, '')) 
                }
                console.log(total);
                /*total = new Intl.Number_format('en-US', {
                    minimumFractionDigits:
                }).format(total)*/
                document.getElementById('total').innerHTML = '$'+total
            }
        })
    }
</script>
</body>
</html>