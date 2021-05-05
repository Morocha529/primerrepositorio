<?php
//sleep(1);
$dbname = 'psicologia';
$user = 'root';
$password = '';
  try {
  $dsn = "mysql:host=localhost;dbname=$dbname";
  $dbh = new PDO($dsn, $user, $password);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $dbh->exec("set names utf8mb4");
  }
  catch (PDOException $e) {
      print "    <p class=\"aviso\">Error: " . $e->getMessage() . "</p>\n";
  }

$sql ="select ped.pednro, ped.pedanio, ped.pedestado, ped.pedobservacion, ped.pedfechaini, ";
$sql .="cau.caunro, cau.cauanio, cau.tcc_codigo, cau.orgcodigo, cau.caucaratula ";
$sql .="from pedidos ped ";
$sql .="join causas cau on (ped.caunro = cau.caunro and ped.cauanio = cau.cauanio and ped.tcc_codigo = cau.tcc_codigo and ped.orgcodigo = cau.orgcodigo) ";
$sql .="order by ped.pednro desc limit 100";
//echo $sql;

try{
    $resultado = $dbh->prepare($sql);
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
