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
    public function insertNewPoint(){

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
    public function updatePoint(){
      return (new Database('tb_pontuacao'))->update('id_pontuacao = '.$this->id_pontuacao, [
        'id_usuario'    => $this->id_usuario,
        'id_medalha'    => $this->id_medalha,
        'vl_pontuacao'  => $this->vl_pontuacao
      ]);
    }

    // método responsável por obter pontos filtrados pelo id do usuário
    public static function getPointsByViewId($id = null, $order = null, $limit = null, $fields = '*'){
      return (new Database('vw_pontuacao'))->select('id_usuario = "'.$id.'"', $order, $limit, $fields);
    }

    public static function getPointByViewUserId($id){
      return (new Database('vw_pontuacao'))->select('id_usuario = "'.$id.'"')->fetchObject(self::class);
    }

    // método responsável por obter pontos filtrados por id
    public static function getPointById($id){
      return (new Database('vw_pontuacao'))->select('id_pontuacao = "'.$id.'"')->fetchObject(self::class);
    }

    
  }
?>