<?php
  namespace App\Model\Entity;

  Class Activity {
    public $id;
    public $image;
    public $description;

    // entities
    public $User;
    public $Category;
    public $Situation;

    // método responsável por instânciar a classe
    public function __construct(){
      $this->User      = new User();
      $this->Category  = new Category();
      $this->Situation = new Situation();
    }

    // método responsável por atualizar registros no banco de dados
    public function update(){
      $objDatabase = new Database('tb_atividade');
      $objDatabase->update('id_atividade = '.$this->id, [
        'id_usuario'     => $this->User->id,
        'id_categoria'   => $this->Category->id,
        'id_situacao'    => $this->Situation->id,
        'ds_senha'       => $this->password,
        'img_atividade'  => $this->image,
        'ds_atividade'   => $this->description
      ]);
    }

  }
?>