<?php
require '../config/config.php';
require '../db/conexion.php';

if(isset($_POST['action'])){
    $action = $_POST['action'];
    $id = isset($_POST['id']) ? $_POST['id'] : 0;

    if($action == 'agregar'){
        $cantidad = isset($_POST['cantidad']) ? $_POST['cantidad'] : 0;
        $respuesta = agregar($id, $cantidad);
        if($respuesta > 0){
            $datos['ok'] = true;
        } else {
            $datos['ok'] = false;
        }
        $datos['sub'] = '$' . number_format($respuesta, 0, '.', '.');
    } else {
        $datos['ok'] = false;
    }
} else {
    $datos['ok'] = false;
}

echo json_encode($datos);

function agregar($id, $cantidad){
    $res = 0;
    if($id > 0 && $cantidad > 0 && is_numeric(($cantidad))){
        if(isset($_SESSION['carrito']['productos'][$id])){
            $_SESSION['carrito']['productos'][$id] = $cantidad;

            $pdo = new conexion();
            $sql = $pdo->prepare("SELECT price FROM product WHERE idProduct=?");
            $sql->execute([$id]);
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            $precio = $row['price'];
            if($cantidad >= 5){
                $res = ($cantidad * $precio)-(($cantidad * $precio)*0.1);
            } else {
                $res = $cantidad * $precio;
            }

            return $res;
        }
    } else {
        return $res;
    }
}
