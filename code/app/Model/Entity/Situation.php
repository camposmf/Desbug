<?php
  namespace App\Model\Entity;

  use \PDO;
  use App\Db\Database;

  Class Situation {
    public $id_situacao;
    public $tp_situacao;

    // método responsável por inserir depoimentos no banco
    public function insertNewSituation(){
      
      // insere as situações no banco de dados
      $this->id_situacao = (new Database('tb_situacao'))->insert([
        'tp_situacao' => $this->tp_situacao
      ]);

      // retornar sucesso
      return true;
    }

    // método responsável por atualizar depoimentos no banco
    public function updateSituation(){
      return(new Database('tb_situacao'))->update('id_situacao = '.$this->id_situacao, [
        'tp_situacao' => $this->tp_situacao
      ]);
    }

    // método responsável por obter as situações das atividades do banco pelo id
    public static function getSituationById($id){
      return (new Database('tb_situacao'))->select('id_situacao = "'.$id.'"')->fetchObject(self::class);
    }

    // método responsável por obter as situações das atividades do banco pelo tipo da situação
    public static function getSituationByType($typeSituation){
      return (new Database('tb_situacao'))->select('tp_situacao = "'.$typeSituation.'"')->fetchObject(self::class);
    }
    
  }
?>