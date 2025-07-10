<?php


require_once __DIR__ . "/../interfaces/DbInterfaces.php";


class NewCode
{
  public DbInterface $db;


  public function __construct(DbInterface $db)
  {
    $this->db = $db;
  }

  public function funct_traerDatos_module()
  {
    $data = $this->traerDatos();
    return $data;
  }

  public function traerDatos()
  {
    $terminales = $this->db->select("terminales");
    //debuguear($terminales, true);
    $count_terminales = count($terminales);
    //debuguear($count_terminales);
    $datos = [];

    for ($i = 0; $i < $count_terminales; $i++) {
      $datos[$terminales[$i]->ter_id] = [
        "name" => $terminales[$i]->ter_nombre,
        "distritos" => $this->traerDist($terminales[$i]->ter_id)
      ];
    }
    //debuguear($datos, true);
    return $datos;
  }

  public function traerDist($id)
  {
    //debuguear($id);
    $ubigeo = $this->getUbigeo($id);

    if (!$ubigeo) return [];

    $fields = $this->getUbigeoFields($ubigeo);
    if (empty($fields)) return [];

    return $this->buildDistritosData($fields[0]->ubi_depid, $fields[0]->ubi_provid);
  }

  public function getUbigeo($id)
  {
    $ubigeo = $this->db->select("ubigeo", $id)[0]->ter_ubigeo;
    return $ubigeo;
  }

  public function getUbigeoFields($ubigeo)
  {

    $fields = $this->db->select("twoFields", $ubigeo);
    //debuguear($fields);
    return $fields;
  }


  public function buildDistritosData($ubi_depid, $ubi_provid)
  {
    $distritos = $this->db->select("distritos", $ubi_depid, $ubi_provid);
    //debuguear($distritos);
    $data = [];
    $count_distritos = count($distritos);
    //debuguear($count_distritos, true);
    for ($i = 0; $i < $count_distritos; $i++) {
      $data[] = [
        "ubi_distrito" => $distritos[$i]->ubi_distrito,
        "ubi_id" => $distritos[$i]->ubi_id,
        "tarifa_recojo" => $this->traerTarifa($distritos[$i]->ubi_id, 'recojo'),
        "tarifa_reparto" => $this->traerTarifa($distritos[$i]->ubi_id, 'reparto')

      ];
    }
    //debuguear($data);
    return $data;
  }


  public function traerTarifa($ubi_id, $tipo)
  {
    $gt_id = $this->getTarifaId($ubi_id, $tipo);
    if (!$gt_id) return null;
    return $this->getTarifaData($gt_id);
  }

  private function getTarifaId($ubi_id, $tipo)
  {
    $pos = strpos($ubi_id, '1501');
    if ($pos !== false) {
      $method = $tipo === 'recojo' ? 'tarifaRecojo' : 'tarifaReparto';
      $result = $this->db->select($method, $ubi_id);
      return !empty($result) ? $result[0]->{$tipo === 'recojo' ? 'ta_id_tarifa' : 'ta_id_tarifa_reparto'} : null;
    }
    return null;
  }

  private function getTarifaData($gt_id)
  {
    $gt_id = (int) trim($gt_id);
    $tarifas = $this->db->select("tarifarioGrupo", $gt_id);
    return !empty($tarifas) ? json_decode($tarifas[0]->gt_tarifas, true) : null;
  }
}
