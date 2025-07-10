<?php


/* Esta clase a priori estas mal ya que mesclamos multiples funcionalidades para dicha clase, 
   lo ideal es separar las responsabilidades, tener clases didtintas para cada método.
   Debemos separar la lógica de las consultas
*/
class CodeNew
{

  protected $db;


  public function __construct($db)
  {
    $this->db = $db;
  }

  /* Este método se encarga de ejecutar  traerDatos(el método  principal)*/
  public function funct_traerDatos_module()
  {
    $data = $this->traerDatos();
    return $data;
  }

  //devuelve un arreglo asociativo
  public function traerDatos()
  {
    //Aquí hacemos 2 querys
    // los métodos select retornan arreglos indexados de objetos
    $terminales = $this->db->select("SELECT ter_id, ter_nombre, ter_ubigeo FROM emp_terminal where ter_nombre !='Miraflores'");
    //debuguear($terminales, true);

    $distritos = $this->db->select(
      "SELECT DISTINCT ubi_departamento, ubi_provincia, ubi_distrito, ubi_id
        FROM emp_ciudad_ubigeo
        WHERE (ubi_distrito != '' AND ubi_distid IN ( SELECT DISTINCT ta_id_distrito FROM `emp_tarifario_grupos` ))"
    );

    $count_terminales = count($terminales);
    // más o menos así sería este arreglo
    $datos = [
      '123abc' => ['name' => 'dsc', 'distritos' => 'sdc'],
      '215sdd' => ['name' => 'sdc', 'distritos' => 'sdc']
    ];
    //debuguear($terminales, true);
    // recorremos el arreglo de terminales
    for ($i = 0; $i < $count_terminales; $i++) {
      $datos[$terminales[$i]->ter_id] = [
        "name" => $terminales[$i]->ter_nombre,
        // este campo se llenara dinamicamente con el ter_id del objeto que se este recorriendo actualmente
        "distritos" => $this->traerDist($terminales[$i]->ter_id)
      ];
    }
    return $datos;
  }

  // este método devuelve un arreglo indexado de arreglos
  public function traerDist($id)
  {
    // los métodos select retornan arreglos indexados de objetos
    // hacemos 3 querys una de ellas con el id(ter_id) que se recibe com parametro

    $ubigeo = $this->db->select("SELECT ter_ubigeo FROM emp_terminal where ter_id = $id")[0]->ter_ubigeo;

    //debuguear($ubigeo, true);

    // aquí hacemos 2 querys a la misma base de datos, podriamos hacer una sóla query y seleccionar los campos
    // que necesitamos


    $twoFields = $this->db->select("SELECT ubi_depid, ubi_provid FROM emp_ciudad_ubigeo WHERE ubi_id = $ubigeo")[0];
    //debuguear($twoFields, true);

    $dep_id = $twoFields->ubi_depid;
    $prov_id = $twoFields->ubi_provid;
    //$dep_id = $this->db->select("SELECT ubi_depid FROM emp_ciudad_ubigeo WHERE ubi_id = $ubigeo")[0]->ubi_depid;
    //$prov_id = $this->db->select("SELECT ubi_provid FROM emp_ciudad_ubigeo WHERE ubi_id = $ubigeo")[0]->ubi_provid;

    $distritos = $this->db->select(
      " SELECT DISTINCT ubi_distrito, ubi_id
        FROM emp_ciudad_ubigeo
        WHERE (
        ubi_depid = $dep_id
        AND ubi_provid = $prov_id AND ubi_distrito != ''
        AND ubi_distid IN (
        SELECT DISTINCT ta_id_distrito
        FROM `emp_tarifario_grupos`
        WHERE ta_id_departamento = $dep_id AND ta_id_provincia = $prov_id
        )
        )"
    );

    //debuguear($distritos, true);
    /* data será un arreglo indexado que tendra arreglo asosciativos como elementos
       algo así =>
       $data =[
            [
              "ubi_distrito" => $distritos[$i]->ubi_distrito,
              "ubi_id" => $distritos[$i]->ubi_id,
              "tarifa_recojo" => $this->traerTarifa($distritos[$i]->ubi_id, 'recojo'),
              "tarifa_reparto" => $this->traerTarifa($distritos[$i]->ubi_id, 'reparto')
            ],
            [
            "ubi_distrito" => $distritos[$i]->ubi_distrito,
            "ubi_id" => $distritos[$i]->ubi_id,
            "tarifa_recojo" => $this->traerTarifa($distritos[$i]->ubi_id, 'recojo'),
            "tarifa_reparto" => $this->traerTarifa($distritos[$i]->ubi_id, 'reparto')
          ]
       ]  
    */

    $data = [];
    $count_distritos = count($distritos);
    // recorremos el arreglo de distritos
    for ($i = 0; $i < $count_distritos; $i++) {
      $data[] = [
        "ubi_distrito" => $distritos[$i]->ubi_distrito,
        "ubi_id" => $distritos[$i]->ubi_id,
        // estos 2 campos se llenaran dinamicamente con lo que devuelva el método traerTarifa
        "tarifa_recojo" => $this->traerTarifa($distritos[$i]->ubi_id, 'recojo'),
        "tarifa_reparto" => $this->traerTarifa($distritos[$i]->ubi_id, 'reparto')
      ];
    }
    //debuguear($data, true);
    return $data;
  }

  public function traerTarifa($ubi_id, $tipo)
  {
    //$ubi_id_int = gettype($ubi_id);
    // devuelve la posicion de una subcadena dentro de otra cadena => holaMundoComoEstas , buscar subcadena 'Mundo'=> posicion 4
    //ejemplo de como sería => $ubi_id = hvbhdsf1501fdv
    $pos = strpos($ubi_id, '1501');
    $msj = '';
    // si se encuentra dicha subcadena en la principal, nos da a entender que el recpjo/reparto es para la ciudad de lima
    if ($pos !== false) {
      // evaluamos el tipo, dependiendo de eso ejecutamos una u otra query
      if ($tipo == 'recojo') {
        $gt_id = $this->db->select("SELECT ta_id_tarifa FROM emp_tarifario_grupos WHERE ta_ubigeo = $ubi_id")[0]->ta_id_tarifa;
        $msj = 'lima-recojo';
        debuguear($gt_id, true);
      } elseif ($tipo == 'reparto') {
        $gt_id = $this->db->select("SELECT ta_id_tarifa_reparto FROM emp_tarifario_grupos WHERE ta_ubigeo = $ubi_id")[0]->ta_id_tarifa_reparto;
        $msj = 'lima-reparto';
        debuguear($gt_id, true);
      }
    }

    // $gt_id esto será un id, independientemente de donde halla entrado
    //$gt_id = $this->db->select("SELECT ta_id_tarifa FROM emp_tarifario_grupos WHERE ta_ubigeo = $ubi_id")[0]->ta_id_tarifa;

    // le quitamos los espacion y hacemos una conversion de tipos
    $gt_id = (int)(trim($gt_id));
    $tarifas = $this->db->select("SELECT gt_tarifas FROM emp_tarifario_grupo_tarifa WHERE gt_id = " . $gt_id)[0]->gt_tarifas;

    // convertimos un json en arreglo sociativo
    return json_decode($tarifas, true);
  }
}
