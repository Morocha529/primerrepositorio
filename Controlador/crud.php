<?php
function conecta()
  {
    $dbname = 'psicologia';
    $user = 'root';
    $password = '';
      try {
        $dsn = "mysql:host=localhost;dbname=$dbname";
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $dbh->exec("set names utf8mb4");
        return $dbh;
        } catch (PDOException $e) {
            print " <p class=\"aviso\">Error: No puede conectarse con la base de datos.</p>\n";
            print "\n";
            print "    <p class=\"aviso\">Error: " . $e->getMessage() . "</p>\n";
            exit();
        }
    }
function AltaPedido_Persona_Psicologo_Materia(){
    global
    $caunro,
    $cauanio,
    $tcc_codigo,
    $orgcodigo,
    $caucaratula,
    $pednro,
    $pedanio,
    $pedfechaini,
    $pedestado,
    $pedobservacion,
    $persona_array,
    $psicologo_array,
    $materia_array,
    $fuecodigo;

    $pdo= conecta();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    try{
        $pdo->beginTransaction();
        /*$sql = "INSERT IGNORE INTO causas (caunro, cauanio, tcc_codigo, orgcodigo, caucaratula) ";
        $sql .= "VALUES (:caunro, :cauanio, :tcc_codigo, :orgcodigo, :caucaratula)";
        $stmt= $pdo->prepare($sql);

        $stmt->bindParam(":caunro", $caunro, PDO::PARAM_INT);
        $stmt->bindParam(":cauanio", $cauanio, PDO::PARAM_INT);
        $stmt->bindParam(":tcc_codigo", $tcc_codigo, PDO::PARAM_STR);
        $stmt->bindParam(":orgcodigo", $orgcodigo, PDO::PARAM_STR);
        $stmt->bindParam(":caucaratula", $caucaratula, PDO::PARAM_STR);
        $res1 = $stmt->execute();*/
        foreach($materia_array as $value) {
            $sql = "INSERT IGNORE INTO materiascausas (matcodigo, fuecodigo, caunro, cauanio, tcc_codigo, orgcodigo) ";
            $sql .= "VALUES (:matcodigo, :fuecodigo, :caunro, :cauanio, :tcc_codigo, :orgcodigo)";
            $stmt= $pdo->prepare($sql);

            $stmt->bindParam(":matcodigo", $value, PDO::PARAM_STR);
            $stmt->bindParam(":fuecodigo", $fuecodigo, PDO::PARAM_STR);
            $stmt->bindParam(":caunro", $caunro, PDO::PARAM_INT);
            $stmt->bindParam(":cauanio", $cauanio, PDO::PARAM_INT);
            $stmt->bindParam(":tcc_codigo", $tcc_codigo, PDO::PARAM_STR);
            $stmt->bindParam(":orgcodigo", $orgcodigo, PDO::PARAM_STR);
            $res1 = $stmt->execute();
        }

        $sql = "INSERT INTO pedidos (pedanio, caunro, cauanio, tcc_codigo, orgcodigo, pedfechaini, pedestado, pedobservacion) ";
        $sql .= "VALUES (:pedanio, :caunro, :cauanio, :tcc_codigo, :orgcodigo, :pedfechaini, :pedestado, :pedobservacion)";
        $stmt= $pdo->prepare($sql);

        $stmt->bindParam(":pedanio", $pedanio, PDO::PARAM_INT);
        $stmt->bindParam(":caunro", $caunro, PDO::PARAM_INT);
        $stmt->bindParam(":cauanio", $cauanio, PDO::PARAM_INT);
        $stmt->bindParam(":tcc_codigo", $tcc_codigo, PDO::PARAM_STR);
        $stmt->bindParam(":orgcodigo", $orgcodigo, PDO::PARAM_STR);
        $stmt->bindParam(":pedfechaini", $pedfechaini, PDO::PARAM_STR);
        $stmt->bindParam(":pedestado", $pedestado, PDO::PARAM_STR);
        $stmt->bindParam(":pedobservacion", $pedobservacion, PDO::PARAM_STR);
        $res1 = $stmt->execute();

        $pednro = $pdo->lastInsertId();
        $vinculo="actor";
        $pedper= 1;
        foreach($persona_array as $value) {
            $sql = "INSERT INTO pedidospersonas (perid, pednro, pedanio, vinculo, pedper_orden) ";
            $sql .= "VALUES (:perid, :pednro, :pedanio, :vinculo, :pedper)";
            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(":perid", $value, PDO::PARAM_INT);
            $stmt->bindParam(":pednro", $pednro, PDO::PARAM_INT);
            $stmt->bindParam(":pedanio", $pedanio, PDO::PARAM_INT);
            $stmt->bindParam(":vinculo", $vinculo, PDO::PARAM_STR);
            $stmt->bindParam(":pedper", $pedper, PDO::PARAM_INT);
            $res2 = $stmt->execute();
        }

        foreach($psicologo_array as $value) {
            $sql = "INSERT INTO pedidospsicologos (pednro, pedanio, psicodigo) ";
            $sql .= "VALUES (:pednro, :pedanio, :psicodigo)";
            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(":psicodigo", $value, PDO::PARAM_STR);
            $stmt->bindParam(":pednro", $pednro, PDO::PARAM_INT);
            $stmt->bindParam(":pedanio", $pedanio, PDO::PARAM_INT);
            $res3 = $stmt->execute();
        }

        $pdo->commit();
        if($res1&&$res2&&$res3){
          return array("actualizado MATERIASCAUSAS, PEDIDOS, PEDIDOSPERSONAS, PEDIDOSPSICOLOGOS");
        }else{
          return array("error", $e);
        }
      }
      catch(PDOException $e){
        $pdo->rollBack();
        echo($e);
      }
    unset($stmt);
    unset($pdo);
  //  return array($res?"actualizado CAUSAS Y PEDIDOS":"error", $e);
  }
  // Recepción de los datos enviados mediante POST desde el JS(vamo a ver)
  $caunro = (isset($_POST['caunro'])) ? $_POST['caunro'] : '';
  $cauanio = (isset($_POST['cauanio'])) ? $_POST['cauanio'] : '';
  $tcc_codigo = (isset($_POST['tcc_codigo'])) ? $_POST['tcc_codigo'] : '';
  $orgcodigo = (isset($_POST['orgcodigo'])) ? $_POST['orgcodigo'] : '';
  $caucaratula = (isset($_POST['caucaratula'])) ? $_POST['caucaratula'] : '';
  /*formato de la fecha.*/
  $pedfechaini_0 =(isset($_POST['pedfechaini'])) ? $_POST['pedfechaini'] : '';
  $pedfechaini_1 = str_replace('/', '-', $pedfechaini_0);
  $pedfechaini = date('Y-m-d', strtotime($pedfechaini_1));
  $pednro = 0;
  $pedanio = 2020;

  $pedestado = (isset($_POST['pedestado'])) ? $_POST['pedestado'] : '';
  $pedobservacion = (isset($_POST['pedobservacion'])) ? $_POST['pedobservacion'] : '';
  $persona_array = (isset($_POST['persona_array'])) ? $_POST['persona_array'] : '';
  $psicologo_array = (isset($_POST['psicologo_array'])) ? $_POST['psicologo_array'] : '';
  $materia_array = (isset($_POST['materia_array'])) ? $_POST['materia_array'] : '';
  /*foreach($materia_array as $value) {
    echo $value."<br>";
  }*/
  $fuecodigo = (isset($_POST['fuecodigo'])) ? $_POST['fuecodigo'] : '';
  //echo $fuecodigo;
  //$llama = AltaPedido_Persona_Psicologo_Materia();
  $llama = "Exitos";
  print_r($llama)

?>
