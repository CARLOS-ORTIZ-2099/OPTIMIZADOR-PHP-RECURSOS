<?php
require_once __DIR__ . "/../interfaces/DbInterfaces.php";

class Mongo implements DbInterface
{
  public  function select($query)
  {
    debuguear("seleccionando desde mongo");
  }
}
