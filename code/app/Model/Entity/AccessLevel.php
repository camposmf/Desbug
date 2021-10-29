<?php
  namespace App\Model\Entity;

  Class AccessLevel {
    public $id;
    public $User;
    public $blTypeAccess;

    // método responsável por instânciar a classe
    public function __construct(){
      $this->user = new User();
    }

    // método responsável por inserir registros no banco de dados
    public function insert(){
      $this->id = (new Database('tb_nivel_acesso'))->insert([
        'id_usuario'       => $this->User->id,
        'tp_nivel_acesso'  => $this->blTypeAccess
      ]);

      // retornar sucesso
      return true;
    }

    // método responsável por atualizar registros no banco de dados
    public function update(){
      $objDatabase = new Database('tb_nivel_acesso');
      $objDatabase->update('id = '.$this->id, [
        'id_usuario'       => $this->User->id,
        'tp_nivel_acesso'  => $this->blTypeAccess
      ]);
    }
  }
?>