<?php
  namespace App\Model\Entity;

  use \PDO;
  use App\Db\Database;

  Class Medals {
    public $id;
    public $image;
    public $totalValue;
    public $description;

    // método responsável por obter as medalhas no banco 
    public static function get($where = null, $order = null, $limit = null){
      $objDatabase = new Database('tb_medalha');
      return $objDatabase->select($where, $order, $limit)
                         ->fetchAll(PDO::FETCH_CLASS, self::class);
    }
  }
?>