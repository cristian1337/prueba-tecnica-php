<?php

class conexion extends PDO {
    private $host = 'localhost';
    private $dbName = 'prueba-tecnica';
    private $username = 'root';
    private $pass = '';

    public function __construct() {
        try {
            parent::__construct(
                'mysql:host='.$this->host.';dbname='.$this->dbName.';charset=utf8',
                $this->username,
                $this->pass,
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
            );
        } catch (PDOException $error) {
            echo 'Error: '.$error->getMessage();
            exit; 
        }
    }
}