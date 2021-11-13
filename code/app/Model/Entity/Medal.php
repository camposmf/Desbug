<?php
  namespace App\Model\Entity;

  use \PDO;
  use App\Db\Database;

  Class Medal {
    public $id_medalha;
    public $ds_medalha;
    public $img_medalha;
    public $vl_medalha_total;

    // método responsável por obter as medalhas no banco
    public static function getMedals($where = null, $order = null, $limit = null, $fields = '*'){
      return (new Database('tb_medalha'))->select($where, $order, $limit, $fields);
    }

    // método responsável por buscar uma medalha atráves do id
    public static function getMedalById($id){
      return(new Database('tb_medalha'))->select('id_medalha = "'.$id.'"')->fetchObject(self::class);
    }
  }
?>