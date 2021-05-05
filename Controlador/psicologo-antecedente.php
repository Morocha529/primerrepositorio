<?php
$caunro = isset($_POST['caunro']) ? $_POST['caunro']: '';
$cauanio = isset($_POST['cauanio'])? $_POST['cauanio'] : '';
$tcc_codigo = isset($_POST['tcc_codigo'])? $_POST['tcc_codigo']: '';
$orgcodigo = isset($_POST['orgcodigo']) ? $_POST['orgcodigo']: '';
$opcion = isset($_POST['opcion'])? $_POST['opcion']: '';

if ( !empty($caunro) && !empty($caunro) && !empty($tcc_codigo)) {
    include_once "../BaseDatos/conectar.php";
    if ($opcion == 'antecedente_psico'){
$sql="select  psico.psicodigo, psico.psinombre, psico.fuecodigo, psico.cargo, psico.distrito, ped.pednro, ped.pedanio, ped.pedfechaini, ped.pedestado ";
$sql.="from (select ped.pednro, ped.pedanio, ped.pedfechaini, ped.caunro, ped.cauanio, ped.tcc_codigo, ped.pedestado, cau.caucaratula from pedidos ped ";
$sql.="inner join causas cau on(cau.caunro = ped.caunro and cau.cauanio = ped.cauanio and ped.tcc_codigo = cau.tcc_codigo and cau.orgcodigo = ped.orgcodigo) ";
$sql.="where ped.caunro = '$caunro' and ped.cauanio = '$cauanio' and ped.tcc_codigo = '$tcc_codigo' and ped.orgcodigo = '$orgcodigo' LIMIT 1) as ped ";
$sql.="inner join pedidospsicologos pedpsico on (ped.pednro = pedpsico.pednro and ped.pedanio = pedpsico.pedanio) ";
$sql.="inner join psicologos psico on (psico.psicodigo = pedpsico.psicodigo)";
//echo $sql;
} else{}
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
}
 ?>
