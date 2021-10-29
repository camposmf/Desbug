<?php
  namespace App\Model\Entity;

  Class Points {
    public $id;
    public $User;
    public $Medals;
    public $value;

    // método responsável por instânciar a classe
    public function __construct(){
      $this->User   = new User();
      $this->Medals = new Medals();
    }

    // método responsável por inserir registros no banco de dados
    public function insert(){

      // insere tempo de atividade no banco de dados
      $this->id = (new Database('tb_pontuacao'))->insert([
        'id_usuario'    => $this->User->id,
        'id_medalha'    => $this->Medals->id,
        'vl_pontuacao'  => $this->value
      ]);

      // retornar sucesso
      return true;

    }

    // método responsável por atualizar registros no banco de dados
    public function update(){
      $objDatabase = new Database('tb_pontuacao');
      $objDatabase->update('id_pontuacao = '.$this->id, [
        'id_usuario'    => $this->User->id,
        'id_medalha'    => $this->Medals->id,
        'vl_pontuacao'  => $this->value
      ]);
    }

    // método responsável por obter as pontuações do banco 
    public static function get($where = null, $order = null, $limit = null){
      $objDatabase = new Database('tb_pontuacao');
      return $objDatabase->select($where, $order, $limit)
                         ->fetchAll(PDO::FETCH_CLASS, self::class);
    }
    
  }
?>