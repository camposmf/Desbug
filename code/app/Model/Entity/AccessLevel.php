<?php

  namespace App\Model\Entity;
  use \App\Db\Database;

  Class AccessLevel {
    public $id_nivel_acesso;
    public $id_usuario;
    public $tp_nivel_acesso;

    // método responsável por inserir registros no banco de dados
    public function insertNewAccessLevel(){
      $this->id_nivel_acesso = (new Database('tb_nivel_acesso'))->insert([
        'id_usuario'       => $this->id_usuario,
        'tp_nivel_acesso'  => $this->tp_nivel_acesso
      ]);

      // retornar sucesso
      return true;
    }

    // método responsável por atualizar registros no banco de dados
    public function updateAccessLevel(){
      return (new database('tb_nivel_acesso'))->update('id_nivel_acesso = '.$this->id_nivel_acesso, [
        'id_usuario'       => $this->id_usuario,
        'tp_nivel_acesso'  => $this->tp_nivel_acesso
      ]);
    }

    // método responsável por buscar nível de acesso pelo id
    public static function getAccessLevelById($id){
      return (new Database('tb_nivel_acesso'))->select("id_nivel_acesso = '".$id."'")->fetchObject(self::class);
    }
  }
?>