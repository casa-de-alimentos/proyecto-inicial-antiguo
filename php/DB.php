<?php
class DB
{
  private $db;
  
  public function conectar()
  {
    $this->db = new mysqli('localhost', 'root', '', 'casa_de_alimentacion') or die 
    ('No conectado');

    return $this->db;
  }
}
?>