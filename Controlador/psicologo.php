<?php
//sleep(1);
include_once "../BaseDatos/conectar.php";
$caunro = $_POST['caunro'];
$cauanio = $_POST['cauanio'];
$tcc_codigo = $_POST['tcc_codigo'];
$psicodigo =$_POST['psicodigo'];
$orgcodigo = $_POST['orgcodigo'];

$sql="select ped.pednro, ped.pedanio, ped.pedfechaini, ped.pedestado, psico.psinombre ";
$sql.="from pedidos ped ";
$sql.="inner join pedidospsicologos pedpsico on (ped.pednro = pedpsico.pednro and ped.pedanio = pedpsico.pedanio) ";
$sql.="inner join psicologos psico on (psico.psicodigo = pedpsico.psicodigo) ";
$sql.="where ped.caunro = '$caunro' and ped.cauanio = '$cauanio' and ped.tcc_codigo = '$tcc_codigo' ";
$sql.="and ped.orgcodigo = '$orgcodigo' and psico.psicodigo = '$psicodigo' order by ped.pedanio desc";
//echo $sql;
$data=array();
try {
      $stmt=$conn->prepare($sql);
      $stmt->setFetchMode(PDO::FETCH_ASSOC);
      $stmt->execute();
      $data = $stmt->fetchAll();
      echo json_encode($data, JSON_UNESCAPED_UNICODE);
      }
catch (PDOException $e)
      {echo $e->getMessage();}

 ?>
