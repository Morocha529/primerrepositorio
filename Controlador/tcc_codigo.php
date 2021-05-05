<?php
include_once "../BaseDatos/conectar.php";
if (isset($_POST['searchTerm']))
  {
    $tcc_codigo = $_POST['searchTerm'];
    $sql = "select tcc_codigo, tcc_descr from tcc where tcc_descr like '%".$tcc_codigo."%' order by tcc_descr DESC limit 10";
  }
  $data=array();
  try {
        $stmt=$conn->prepare($sql);
        $stmt->execute();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC))
          {
             $data[] = array('id'=>$row['tcc_codigo'], 'text'=>$row['tcc_descr']);
          }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        /*echo json_encode($data);*/
      }
  catch (PDOException $e)
        {echo $e->getMessage();}
 ?>
