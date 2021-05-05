<?php
include_once '../basedatos/conectar.php';
if(isset($_POST['persona']))
{
	$persona=$_POST['persona'];
  $sql = "SELECT per.perid, per.pernombre, dptos.dptodescripcion, per.perdomicilio, per.perfchnac, per.perdocnro ";
  $sql.= "FROM personas per ";
  $sql.= "INNER JOIN dptos ON (per.dptocodigo = dptos.dptocodigo) ";
	$sql.= "WHERE per.pernombre LIKE "."'%".$persona."%'";
}
try{
    $resultado = $conn->prepare($sql);
    $resultado->execute();
    $data = array();
    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    $conexion = NULL;
    exit();
    }
  catch (PDOException $e)
	{
  echo $e->getMessage();
  }
?>
