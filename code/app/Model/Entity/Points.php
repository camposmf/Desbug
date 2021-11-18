<?php
  namespace App\Model\Entity;

  use \App\Db\Database;
  use \App\Model\Entity\User;
  use \App\Model\Entity\Medal;

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

    // metódo responsável por obter medalhas
    public static function getItemsById($id){
      return (new Database('vw_pontuacao'))->select('id_usuario = "'.$id.'"');
    }

    // método responsável por carregar os dados da medalha
    public static function loadPointsMedalViewValues($objParamMedal){

      // array de medalhas
      $itens = [];

      while($objMedalItem = $objParamMedal->fetchObject(self::class)){
        
        $itens[] = [
          'id_medalha'        =>  (int)$objMedalItem->id_medalha,
          'ds_medalha'        =>  $objMedalItem->ds_medalha,
          'img_medalha'       =>  $objMedalItem->img_medalha,
          'vl_medalha_total'  =>  (float)$objMedalItem->vl_medalha_total
        ];
      }

      // retornar valor
      return $itens;
    }

    // método responsável por carrega os dados do usuário
    public static function loadPointsUserViewValues($objParamUser){

      // mapear os campos
      $objUser = new User();
      $objUser->id_usuario    = (int)$objParamUser->id_usuario;
      $objUser->nm_nickname   = $objParamUser->nm_nickname;
      $objUser->nm_usuario    = $objParamUser->nm_usuario;
      $objUser->ds_email      = $objParamUser->ds_email;
      $objUser->dt_nascimento = $objParamUser->dt_nascimento;
      $objUser->img_usuario   = $objParamUser->img_usuario;
      unset($objUser->ds_senha);

      // retornar valor
      return $objUser;
    }
  }
?>