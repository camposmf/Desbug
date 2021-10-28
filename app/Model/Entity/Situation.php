<?php
  namespace App\Model\Entity;

  use \PDO;
  use App\Db\Database;

  Class Situation {
    public $id;
    public $typeSituation;

    // método responsável por inserir depoimentos no banco
    public function insert(){
      
      // insere as situações no banco de dados
      $this->id = (new Database('tb_situacao'))->insert([
        'tp_situacao'        => $this->typeSituation,
      ]);

      // retornar sucesso
      return true;
    }

    // método responsável por atualizar depoimentos no banco
    public function update(){
      $objDatabase = new Database('tb_situacao');
      $objDatabase->update('id = '.$this->id, [
        'tp_situacao' => $this->typeSituation
      ]);
    }

    // método responsável por obter as situações das atividades do banco 
    public static function get($where = null, $order = null, $limit = null){
      $objDatabase = new Database('tb_situacao');
      return $objDatabase->select($where, $order, $limit)
                         ->fetchAll(PDO::FETCH_CLASS, self::class);
    }
  }
?>