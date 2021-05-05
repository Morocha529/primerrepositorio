<?php
include_once '../basedatos/conectar.php';
$fuecodigo = isset($_POST['fuecodigo'])? $_POST['fuecodigo']: '';

$sql = "select pedpsi.psicodigo, psi.psinombre, psi.fuecodigo, psi.cargo, psi.distrito, count(*) as acumulado ";
$sql .= "from psicologos psi ";
$sql .= "inner join pedidospsicologos pedpsi on(psi.psicodigo = pedpsi.psicodigo) ";
$sql .= "where trim(psi.fuecodigo) = '$fuecodigo' ";
$sql .= "group by pedpsi.psicodigo";

try{
  $stmt=$conn->prepare($sql);
  $stmt->setFetchMode(PDO::FETCH_ASSOC);
  $stmt->execute();
  $data = $stmt->fetchAll();
  echo json_encode($data, JSON_UNESCAPED_UNICODE);
  $conn = NULL;
  exit();
    }
  catch (PDOException $e){
      echo $e->getMessage();
      }
?>
