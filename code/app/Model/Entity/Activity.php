<?php

  namespace App\Model\Entity;

  use \App\Db\Database;
  use \App\Model\Entity\Category;
  use \App\Model\Entity\Situation;
  use \App\Model\Entity\User as EntityUser;

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

    // método responsável por retornar um objeto da entidade categoria
    public static function loadCategory($objParamCategory){
      $objCategory = new Category();
      $objCategory->id_categoria  = (int)$objParamCategory->id_categoria;
      $objCategory->ds_categoria  = $objParamCategory->ds_categoria;
      $objCategory->img_categoria = $objParamCategory->img_categoria;

      return $objCategory;
    }

    // método responsável por retornar um objeto da entidade situação
    public static function loadSituation($objParamSituation){
      $objSituation = new Situation();
      $objSituation->id_situacao  = (int)$objParamSituation->id_situacao;
      $objSituation->tp_situacao  = $objParamSituation->tp_situacao;

      return $objSituation;
    }
  }
?>