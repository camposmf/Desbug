<?php
  namespace App\Model\Entity;

  use \App\Db\Database;
  use \App\Model\Entity\User as EntityUser;
  use \App\Model\Entity\Medal as EntityMedal;

  Class Points {
    public $id_pontuacao;
    public $id_medalha;
    public $id_usuario;
    public $vl_pontuacao;

    // método responsável por inserir registros no banco de dados
    public function insertNewPoints(){

      // insere tempo de atividade no banco de dados
      $this->id_pontuacao = (new Database('tb_pontuacao'))->insert([
        'id_usuario'    => $this->id_usuario,
        'id_medalha'    => $this->id_medalha,
        'vl_pontuacao'  => $this->vl_pontuacao
      ]);

      // retornar sucesso
      return true;

    }

    // método responsável por atualizar registros no banco de dados
    public function updatePoints(){
      return (new Database('tb_pontuacao'))->update('id_pontuacao = '.$this->id_pontuacao, [
        'id_usuario'    => $this->id_usuario,
        'id_medalha'    => $this->id_medalha,
        'vl_pontuacao'  => $this->vl_pontuacao
      ]);
    }

    // método responsável por listar os dados da view de categoria
    public static function getPointsByView($where = null, $order = null, $limit = null, $fields = '*'){
      return (new Database('tb_pontuacao'))->select($where, $order, $limit, $fields);
    }

    // método responsável por obter pontos filtrados por id
    public static function getPointsById($id){
      return (new Database('tb_pontuacao'))->select('id_pontuacao = "'.$id.'"')->fetchObject(self::class);
    }
  }
?>