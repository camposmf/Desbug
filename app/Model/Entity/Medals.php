<?php
  namespace App\Model\Entity;

  use \PDO;
  use App\Db\Database;

  Class Medals {
    public $id;
    public $User;
    public $image;
    public $description;
    public $totalValue;
    public $currentValue;

    // método responsável por instânciar a classe
    public function __construct(){
      $this->User = new User();
    }

    // método responsável por inserir registros no banco de dados
    public function insert(){

      // insere medalha no banco de dados
      $this->id = (new Database('tb_medalha'))->insert([
        'id_medalha'        => $this->User->id,
        'ds_medalha'        => $this->description,
        'vl_medalha_total'  => $this->totalValue,
        'vl_medalha_atual'  => $this->currentValue,
        'img_medalha'       => $this->image
      ]);

      // retornar sucesso
      return true;
    }

    // método responsável por obter as medalhas no banco 
    public static function get($where = null, $order = null, $limit = null){
      $objDatabase = new Database('tb_medalha');
      return $objDatabase->select($where, $order, $limit)
                         ->fetchAll(PDO::FETCH_CLASS, self::class);
    }
  }
?>