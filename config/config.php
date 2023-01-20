<?php

session_start();

$numCart = 0;
if(isset($_SESSION['carrito']['productos'])){
    $numCart = count($_SESSION['carrito']['productos']);
}