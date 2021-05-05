<?php
include_once "../basedatos/conectar.php";

$caunro = isset($_POST['caunro'])? $_POST['caunro']: '';
$cauanio = isset($_POST['cauanio'])? $_POST['cauanio']: '';
$tcc_codigo = isset($_POST['tcc_codigo'])? $_POST['tcc_codigo']: '';
$orgcodigo = isset($_POST['orgcodigo'])? $_POST['orgcodigo']: '' ;
$fuecodigo = isset($_POST['fuecodigo'])? $_POST['fuecodigo']:'';
$opcion = isset($_POST['opcion'])? $_POST['opcion']: '';

switch ($opcion) {
  case 'caratula':
    $sql = "SELECT caucaratula FROM causas WHERE ";
    $sql .= "caunro = $caunro and cauanio = $cauanio and tcc_codigo = '$tcc_codigo' and orgcodigo = '$orgcodigo' ";
    //echo $sql;
    break;
  case 'materias':
    $sql ="select m.matcodigo, m.matnombre ";
    $sql .="from materias m where m.fuecodigo = '$fuecodigo' and m.matcodigo in ";
    $sql .="(select mcau.matcodigo from materiascausas mcau ";
    $sql .="inner join causas cau on(cau.caunro = mcau.caunro and cau.cauanio= mcau.cauanio and cau.orgcodigo = mcau.orgcodigo and cau.tcc_codigo=mcau.tcc_codigo) ";
    $sql .="where cau.caunro = $caunro and cau.cauanio = $cauanio and cau.tcc_codigo = '$tcc_codigo' and cau.orgcodigo = '$orgcodigo')";
    //echo $sql;
    break;
  default:
    // code...
    break;
}

try{
    $resultado = $conn->prepare($sql);
    $resultado->execute();
    $data=array();
    $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    $conexion = NULL;
    exit();
    }
  catch (PDOException $e){
      echo $e->getMessage();
      }
?>
