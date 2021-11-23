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
    public $qtd_sentimento;

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

    // método responsável por obter um array de registros do banco de dados 
    public static function getDataCollectByViewId($id){

      // array vázio
      $itens = [];

      // recuperar query do banco de dados
      $getView = (new Database('vw_quantidade_sentimento'))->select('id_usuario = '.$id);

      // popular array com os valores vindos do banco de dados
      while($item = $getView->fetchObject(self::class)){
        $itens[] = [
          "vl_sentimento_prox"  => $item->vl_sentimento_prox,
          "qtd_sentimento"      => (int)$item->qtd_sentimento
        ];
      }

      // retornar array
      return $itens;
    }

    // método responsável por obter o registro atráves do id
    public static function getDataCollectById($id){
      return (new Database('tb_coleta_dado'))->select('id_coleta_dado = '.$id)->fetchObject(self::class);
    }
  }
?>