<?php
include '../basedatos/Conectar.php';
$data = array();
$search = isset($_POST['searchTerm'])? $_POST['searchTerm']: '';
$sql = "SELECT matcodigo, matnombre FROM materias WHERE matnombre like '%".$search."%' order by matnombre ASC limit 10";

$Statement = $conn->prepare($sql);
if($Statement->execute()){
  while($row = $Statement->fetch(PDO::FETCH_ASSOC)){
       $data[] = array('id'=>$row['matcodigo'], 'text'=>$row['matnombre']);
     }
     /*$data = $Statement->fetchAll(PDO::FETCH_ASSOC);*/
     echo json_encode($data);

}else{
  echo('Error');
}
exit();
?>
