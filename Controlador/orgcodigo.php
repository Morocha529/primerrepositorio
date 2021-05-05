<?php
include '../basedatos/Conectar.php';
$data = array();
$orgcodigo = $_POST['searchTerm'];
$sql = "SELECT orgcodigo, orgnombre FROM organismos WHERE orgnombre like '%".$orgcodigo."%' order by orgnombre ASC limit 10";

$Statement = $conn->prepare($sql);
if($Statement->execute())
  {
    while($row = $Statement->fetch(PDO::FETCH_ASSOC))
      {
         $data[] = array('id'=>$row['orgcodigo'], 'text'=>$row['orgnombre']);
      }
     echo json_encode($data);
   }
   else
   {
     echo('Error');
    }
exit();
?>
