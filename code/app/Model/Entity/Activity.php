<?php
  namespace App\Model\Entity;
  use App\Db\Database;

  Class Activity {

    public $id_atividade;
    public $id_usuario;
    public $id_categoria;
    public $id_situacao;
    public $img_atividade;
    public $ds_atividade;

    // método responsável por inserir uma nova atividade no banco
    public function insertNewActivity(){

      // insere uma atividade no banco de dados
      $this->id_atividade = (new Database('tb_atividade'))->insert([
        'id_usuario'    => $this->id_usuario,
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
        'id_usuario'    => $this->id_usuario,
        'id_categoria'  => $this->id_categoria,
        'id_situacao'   => $this->id_situacao,
        'img_atividade' => $this->img_atividade,
        'ds_atividade'  => $this->ds_atividade
      ]);
    }

    // método responsável por deletar uma atividade no banco de dados
    public function deleteUser(){
      return (new Database('tb_atividade'))->delete('id_atividade = '.$this->id_atividade);
    }

    // método responsável por obter os atividades do banco 
    public static function getActivities($where = null, $order = null, $limit = null, $fields = '*'){
      return (new Database('tb_atividade'))->select($where, $order, $limit, $fields);
    }

    // método responsável por obter uma atividade filtrados por id
    public static function getUserById($id){
      return (new Database('tb_atividade'))->select('id_atividade = "'.$id.'"')->fetchObject(self::class);
    }

    // método responsável por obter uma atividade filtrados pela descrição da atividade
    public static function getUserByDescription($description){
      return (new Database('tb_atividade'))->select('ds_atividade = "'.$description.'"')->fetchObject(self::class);
    }


  }
?>