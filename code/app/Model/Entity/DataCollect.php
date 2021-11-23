<?php
  namespace App\Model\Entity;

  Use \App\Db\Database;
  use \App\Model\Entity\Activity;
  use \App\Model\Entity\User as EntityUser;
  use \App\Model\Entity\Category as EntityCategory;
  use \App\Model\Entity\Situation as EntitySituation;

  Class DataCollect {
    public $id_coleta_dado;
    public $id_usuario;
    public $id_atividade;
    public $vl_sentimento_ant;
    public $vl_sentimento_prox;

    // método responsável por inserir registros no banco
    public function insertNewDataCollect(){

      // insere usuário no banco de dados
      $this->id_coleta_dado = (new Database('tb_coleta_dado'))->insert([
        'id_usuario'          => $this->id_usuario,
        'id_atividade'        => $this->id_atividade,
        'vl_sentimento_ant'   => $this->vl_sentimento_ant,
        'vl_sentimento_prox'  => $this->vl_sentimento_prox
      ]);

      // retornar sucesso
      return true;
    }

    // método responsável por atualizar registros no banco de dados
    public function updateDataCollect(){
      return (new Database('tb_coleta_dado'))->update('id_coleta_dado = "'.$this->id_coleta_dado.'"', [
        'id_usuario'          => $this->id_usuario,
        'id_atividade'        => $this->id_atividade,
        'vl_sentimento_ant'   => $this->vl_sentimento_ant,
        'vl_sentimento_prox'  => $this->vl_sentimento_prox
      ]);
    }

    // método responsável por obter o registro atráves do id
    public static function getDataCollectById($id){
      return (new Database('tb_coleta_dado'))->select('id_coleta_dado = '.$id)->fetchObject(self::class);
    }
  }
?>