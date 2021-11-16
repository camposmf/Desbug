<?php
  namespace App\Model\Entity;

  use \App\Db\Database;

  Class Category {
    public $id_categoria;
    public $id_usuario;
    public $ds_categoria;
    public $img_categoria;

    // método responsável por inserir categorias no banco de dados
    public function insertNewCategory(){

      // insere categoria no banco de dados
      $this->id_categoria = (new Database('tb_categoria'))->insert([
        'id_usuario'    => $this->id_usuario,
        'ds_categoria'  => $this->ds_categoria,
        'img_categoria' => $this->img_categoria
      ]);

      // sucesso
      return true;
    }

    // método responsável por atualizar categorias no banco de dados
    public function updateCategory(){

      // atualiza os dados no banco de dados
      return (new Database('tb_categoria'))->update('id_categoria = '.$this->id_categoria, [
        'id_usuario'    => $this->id_usuario,
        'ds_categoria'  => $this->ds_categoria,
        'img_categoria' => $this->img_categoria
      ]);

      // sucesso
      return true;
    }

    // método responsável por deletar uma categoria no banco de dados
    public function deleteCategory(){
      return (new Database('tb_categoria'))->delete('id_categoria = '.$this->id_categoria);
    }
    
    // método responsável por listar os registros do banco de dados
    public static function getCategories($where = null, $order = null, $limit = null, $fields = '*'){
      return (new Database('tb_categoria'))->select($where, $order, $limit, $fields);
    }

    // método responsável por listar os registros do banco de dados
    public static function getCategoryById($id){
      return (new Database('tb_categoria'))->select('id_categoria = "'.$id.'"')->fetchObject(self::class);
    }

    // método responsável por listar os registros do banco de dados
    public static function getCategoryByDescription($categoria){
      return (new Database('tb_categoria'))->select('ds_categoria = "'.$categoria.'"')->fetchObject(self::class);
    }
  }
?>