<?php

require_once __DIR__ . "/../interfaces/DbInterfaces.php";

class Mysql implements DbInterface
{
  public $db;
  public function __construct()
  {
    $this->db = new mysqli(HOSTNAME, USERNAME, PASSWORD, DATABASE);
  }
  public function select($fn, ...$params)
  {
    $query = call_user_func([$this, $fn], $params);
    $response = $this->executeQuery($query);
    //debuguear($response);
    return $response;
  }

  private function executeQuery($query)
  {
    $result = $this->db->query($query);
    //debuguear($result);
    return $this->transformData($result);
  }

  public function transformData($data)
  {
    $obj = null;
    $array = [];
    while ($obj = $data->fetch_object()) {
      //debuguear($obj);
      $array[] = $obj;
    }
    return $array;
  }

  public function terminales()
  {
    $query = "SELECT ter_id, ter_nombre, ter_ubigeo FROM emp_terminal where ter_nombre !='Miraflores'";
    return $query;
  }

  public function ubigeo($id)
  {
    // esta query se ejecuta despues del metodo terminales y hace la consulta a la misma tabla, pero donde solo retorna los registros del campo ter_ubigeo, siempre y cuando coincida con lo que se le pase como parametro al metodo ubigeo y lo que se le pasa será el ter_id de cada uno de los registros obtenidos de la consulta anterior es decir dle metodo 'terminales'
    $query = "SELECT ter_ubigeo FROM emp_terminal where ter_id = " . $id[0];
    return $query;
  }

  public function twoFields($ubigeo)
  {
    $query = "SELECT ubi_depid, ubi_provid FROM emp_ciudad_ubigeo WHERE ubi_id =" . $ubigeo[0];
    return $query;
  }

  public function distritos($data)
  {
    //debuguear($data);
    [$ubi_depid, $ubi_provid] = $data;
    $query = " SELECT DISTINCT ubi_distrito, ubi_id
      FROM emp_ciudad_ubigeo
        WHERE 
          ubi_depid = $ubi_depid
            AND ubi_provid = $ubi_provid  AND ubi_distrito != ''
      ";
    //debuguear($query);
    return $query;
  }

  public function tarifaRecojo($ubi_id)
  {
    //debuguear($ubi_id);
    $query = "SELECT ta_id_tarifa FROM emp_tarifario_grupos WHERE ta_ubigeo =" . $ubi_id[0];
    return $query;
  }

  public function tarifaReparto($ubi_id)
  {
    $query = "SELECT ta_id_tarifa_reparto FROM emp_tarifario_grupos WHERE ta_ubigeo = " . $ubi_id[0];
    return $query;
  }

  public function tarifarioGrupo($gt_id)
  {
    $query = "SELECT gt_tarifas FROM emp_tarifario_grupo_tarifa WHERE gt_id = " . $gt_id[0];
    return $query;
  }
}
