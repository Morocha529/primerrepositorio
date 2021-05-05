<?php
include_once '../basedatos/conectar.php';
$orgcodigo = $_POST['orgcodigo'];

$sql ="SELECT fuecodigo FROM organismos WHERE orgcodigo = '$orgcodigo'";
//echo $sql;
try{
    $resultado = $conn->prepare($sql);
    $resultado->execute();
    $data=array();
    $data=$resultado->fetchall(PDO::FETCH_ASSOC);
    /*while($row = $resultado->fetch(PDO::FETCH_ASSOC)){
      $data[]=array(
        "perid"=>$row["perid"],
        "dptocodigo"=>$row["dptocodigo"],
        "pernombre"=>$row["pernombre"],
        "dptodescripcion"=>$row["dptodescripcion"]
      );
    }*/
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    $conexion = NULL;
    exit();
    }
  catch (PDOException $e){
      echo $e->getMessage();
      }
?>
