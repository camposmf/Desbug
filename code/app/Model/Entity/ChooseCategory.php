<?php
  namespace App\Model\Entity;

  use \App\Db\Database;
  use \App\Model\Entity\User as EntityUser;
  use \App\Model\Entity\Category as EntityCategory;

  Class ChooseCategory {
    public $id_escolhe_categoria;
    public $id_categoria;
    public $id_usuario;

    // método responsável por inserir categorias no banco de dados
    public function insertNewChooseCategory(){

      // insere categoria no banco de dados
      $this->id_escolhe_categoria = (new Database('tb_escolhe_categoria'))->insert([
        'id_usuario'   => $this->id_usuario,
        'id_categoria' => $this->id_categoria
      ]);

      // sucesso
      return true;
    }

    // método responsável por atualizar a escolha de categorias no banco de dados
    public function updateChooseCategory(){
      return (new Database('tb_escolhe_categoria'))->update('id_escolhe_categoria = '.$this->id_escolhe_categoria, [
        'id_categoria' => $this->id_categoria,
        'id_usuario'   => $this->id_usuario,
      ]);
    }

    // método responsável por deletar uma categoria no banco de dados
    public function deleteChooseCategory(){
      return (new Database('tb_escolhe_categoria'))->delete('id_escolhe_categoria = '.$this->id_categoria);
    }
    
    // método repsonsável por listar as escolhas de categorias
    public static function getChooseCategories($where = null, $order = null, $limit = null, $fields = '*'){
      return (new Database('tb_escolhe_categoria'))->select($where, $order, $limit, $fields);
    }

    // método repsonsável por filtrar escolhas de categorias por id
    public static function getChooseCategory($id){
      return (new Database('tb_escolhe_categoria'))->select('id_escolhe_categoria = "'.$id.'"')->fetchObject(self::class);
    }

    // método responsável por listar os registros do banco de dados
    public static function getChooseCategoryById($id){
      return (new Database('tb_escolhe_categoria'))->select('id_categoria = "'.$id.'"')->fetchObject(self::class);
    }
  }
?>