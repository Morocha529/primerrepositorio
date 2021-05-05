<?php
$server = 'localhost';
$username = 'root';
$password = 'Octa2016';
$database = 'psicologia';
$dsn = "mysql:host=localhost;dbname=$database";
$opciones = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');

try {
  $conn = new PDO("mysql:host=$server; dbname=$database","$username","$password",$opciones);
     //cho "Conexion realizada con exito";
    }
  catch(PDOException $e){
      $this->error = $e->getMessage();
      echo "Excepcion: ".$this->error;
  }

?>
