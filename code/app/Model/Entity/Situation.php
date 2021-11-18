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
    public function updateSituation(){
      $objDatabase = new Database('tb_situacao');
      $objDatabase->update('id = '.$this->id, [
        'tp_situacao' => $this->typeSituation
      ]);
    }

    // método responsável por obter as situações das atividades do banco 
    public static function getSituations($where = null, $order = null, $limit = null){
      $objDatabase = new Database('tb_situacao');
      return $objDatabase->select($where, $order, $limit)
                         ->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    // método responsável por obter as situações das atividades do banco 
    public static function getCountConclusion($where = null, $order = null, $limit = null, $fields){
      // config select
      $fields = 'COUT(tp_situacao)';
      $where = 'tp_situacao = C';

      $objDatabase = new Database('tb_situacao');
      return $objDatabase->select($where, $order, $limit, $fields)
                         ->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    // método responsável por obter as situações das atividades do banco 
    public static function getRecentConclusion($where = null, $order = null, $limit = null){
      // config select
      $limit = 4;
      $where = 'tp_situacao = C';

      $objDatabase = new Database('tb_situacao');
      return $objDatabase->select($where, $order, $limit)
                         ->fetchAll(PDO::FETCH_CLASS, self::class);
    }
  }
?>