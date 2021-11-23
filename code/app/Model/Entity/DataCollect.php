<?php
  namespace App\Model\Entity;

  Use \App\Db\Database;
  use \App\Model\Entity\Activity;
  use \App\Model\Entity\User as EntityUser;
  use \App\Model\Entity\Category as EntityCategory;
  use \App\Model\Entity\Situation as EntitySituation;

  Class DataCollect {
    public $id_coleta_dado;
    public $id_atividade;
    public $vl_sentimento_ant;
    public $vl_sentimento_prox;

    // método responsável por inserir registros no banco
    public function insertNewDataCollect(){

      // insere usuário no banco de dados
      $this->id_coleta_dado = (new Database('tb_coleta_dado'))->insert([
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
        'id_atividade'        => $this->id_atividade,
        'vl_sentimento_ant'   => $this->vl_sentimento_ant,
        'vl_sentimento_prox'  => $this->vl_sentimento_prox
      ]);
    }

    // método responsável por obter o registro atráves do id
    public static function getDataCollectById($id){
      return (new Database('tb_coleta_dado'))->select('id_coleta_dado = '.$id)->fetchObject(self::class);
    }

    // método responsável por retornar um objeto categoria
    private static function getCategory($id_categoria){

      // buscar categoria
      $objCategory = EntityCategory::getCategoryById($id_categoria);

      // buscar usuário
      $objUser = EntityUser::getUserById($objCategory->id_usuario);
      $objUser->id_usuario = (int)$objUser->id_usuario;
      unset($objUser->ds_senha);
      
      // retonar objeto
      return [
        'id_categoria'  => (int)$objCategory->id_categoria,
        'usuario'       => $objUser,
        'ds_categoria'  => $objCategory->ds_categoria,
        'img_categoria' => $objCategory->img_categoria
      ];
    }

    // método responsável por retornar um objeto situação
    private static function getSituation($id_situacao){
      $objSituation = EntitySituation::getSituationById($id_situacao);
      $objSituation->id_situacao = (int)$objSituation->id_situacao;

      return $objSituation;
    }

    // método responsável por retornar um objeto da entidade atividade
    public static function loadActivity($objParamActivity){

      // obter objeto de categoria
      $objCategory = self::getCategory($objParamActivity->id_categoria);

      // obter objeto de situação
      $objSituation = self::getSituation($objParamActivity->id_situacao);

      // retornar objeto
      return [
        'id_atividade'  => (int)$objParamActivity->id_atividade,
        'categoria'     => $objCategory,
        'situacao'      => $objSituation,
        'img_atividade' => $objParamActivity->img_atividade,
        'ds_atividade'  => $objParamActivity->ds_atividade
      ];
    }
  }
?>