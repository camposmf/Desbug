<?php
  namespace App\Model\Entity;

  Class Category {
    public $id;
    public $User;
    public $image;
    public $description;

    // método responsável por instânciar a classe
    public function __construct(){
      $this->user = new User();
    }

    // método responsável por listar os registros do banco de dados
    public static function get($where = null, $order = null, $limit = null){
      $objDatabase = new Database('tb_categoria');
      return $objDatabase->select($where, $order, $limit)
                         ->fetchAll(PDO::FETCH_CLASS, self::class);
    }
  }
?>