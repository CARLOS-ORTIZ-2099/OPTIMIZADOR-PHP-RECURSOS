<?php

require_once __DIR__ . "/../interfaces/DbInterfaces.php";
class PostsGresql implements DbInterface
{
  public $db;
  public function __construct()
  {
    $this->db = "conexion con postgresql";
  }
  public  function select($query)
  {
    debuguear("seleccionando desde postgresql");
  }
}
