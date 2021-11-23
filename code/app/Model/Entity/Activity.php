<?php

  namespace App\Model\Entity;

  use \App\Db\Database;
  use \App\Model\Entity\User as EntityUser;
  use \App\Model\Entity\Category as EntityCategory;
  use \App\Model\Entity\Situation as EntitySituation;

  Class Activity {

    public $id_atividade;
    public $id_categoria;
    public $id_situacao;
    public $img_atividade;
    public $ds_atividade;

    // método responsável por inserir uma nova atividade no banco
    public function insertNewActivity(){

      // insere uma atividade no banco de dados
      $this->id_atividade = (new Database('tb_atividade'))->insert([
        'id_categoria'  => $this->id_categoria,
        'id_situacao'   => $this->id_situacao,
        'img_atividade' => $this->img_atividade,
        'ds_atividade'  => $this->ds_atividade
      ]);

      // retornar sucesso
      return true;

    }

    // método responsável por atualizar registros no banco de dados
    public function updateActivity(){
      return (new Database('tb_atividade'))->update('id_atividade = '.$this->id_atividade, [
        'id_categoria'  => $this->id_categoria,
        'id_situacao'   => $this->id_situacao,
        'img_atividade' => $this->img_atividade,
        'ds_atividade'  => $this->ds_atividade
      ]);
    }

    // método responsável por deletar uma atividade no banco de dados
    public function deleteActivity(){
      return (new Database('tb_atividade'))->delete('id_atividade = '.$this->id_atividade);
    }

    // método responsável por obter os atividades do banco 
    public static function getActivities($where = null, $order = null, $limit = null, $fields = '*'){
      return (new Database('tb_atividade'))->select($where, $order, $limit, $fields);
    }

    // método responsável por obter uma atividade filtrados por id
    public static function getActivityById($id){
      return (new Database('tb_atividade'))->select('id_atividade = "'.$id.'"')->fetchObject(self::class);
    }

    // método responsável por obter uma atividade filtrados pela descrição da atividade
    public static function getActivityByDescription($description){
      return (new Database('tb_atividade'))->select('ds_atividade = "'.$description.'"')->fetchObject(self::class);
    }

    // método responsável por retornar um objeto da entidade atividade
    public static function loadActivity($activityId){

      // obter objeto de atividade
      $objAtividade = self::getActivityById($activityId);

      // obter objeto de categoria
      $objCategory = EntityCategory::loadCategory($objAtividade->id_atividade);

      // obter objeto de situação
      $objSituation = EntitySituation::loadSituation($objAtividade->id_situacao);

      // retornar objeto
      return [
        'id_atividade'  => (int)$objAtividade->id_atividade,
        'categoria'     => $objCategory,
        'situacao'      => $objSituation,
        'img_atividade' => $objAtividade->img_atividade,
        'ds_atividade'  => $objAtividade->ds_atividade
      ];
    }
  }
?>