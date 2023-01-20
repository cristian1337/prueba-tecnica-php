<?php

include '../db/conexion.php';

$pdo = new conexion();

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    if(isset($_GET['id'])){
        $sql = $pdo->prepare("SELECT * FROM product WHERE idProduct=:id");
        $sql->bindValue(':id', $_GET['id']);
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        header("HTTP/1.1 200 registros listados correctamente");
        echo json_encode($sql->fetchAll());
        exit;
    } else {
        $sql = $pdo->prepare("SELECT * FROM product");
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        header("HTTP/1.1 200 registros listados correctamente");
        echo json_encode($sql->fetchAll());
        exit;
    }
}