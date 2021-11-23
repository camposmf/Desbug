<?php
  namespace App\Model\Entity;

  use \PDO;
  use App\Db\Database;

  Class User {
    public $id_usuario; 
    public $nm_nickname;
    public $nm_usuario;
    public $ds_email;
    public $ds_senha;
    public $dt_nascimento;
    public $img_usuario;

    // método responsável por inserir usuários no banco
    public function insertNewUser(){

      // insere usuário no banco de dados
      $this->id_usuario = (new Database('tb_usuario'))->insert([
        'nm_nickname'     => $this->nm_nickname,
        'nm_usuario'      => $this->nm_usuario,
        'ds_email'        => $this->ds_email,
        'ds_senha'        => $this->ds_senha,
        'dt_nascimento'   => $this->dt_nascimento,
        'img_usuario'     => $this->img_usuario
      ]);

      // retornar sucesso
      return true;

    }

    // método responsável por atualizar registros no banco de dados
    public function updateUser(){
      return (new Database('tb_usuario'))->update('id_usuario = '.$this->id_usuario, [
        'nm_nickname'     => $this->nm_nickname,
        'nm_usuario'      => $this->nm_usuario,
        'ds_email'        => $this->ds_email,
        'ds_senha'        => $this->ds_senha,
        'dt_nascimento'   => $this->dt_nascimento,
        'img_usuario'     => $this->img_usuario
      ]);
    }

    // método responsável por deletar um usuário no banco de dados
    public function deleteUser(){
      return (new Database('tb_usuario'))->delete('id_usuario = '.$this->id_usuario);
    }

    // método responsável por obter os usuários do banco 
    public static function getUsers($where = null, $order = null, $limit = null, $fields = '*'){
      return (new Database('tb_usuario'))->select($where, $order, $limit, $fields);
    }

    // método responsável por obter os usuários filtrados por email
    public static function getUserByEmail($email){
      return (new Database('tb_usuario'))->select('ds_email = "'.$email.'"')->fetchObject(self::class);
    }

    // método responsável por obter os usuários filtrados por id
    public static function getUserById($id){
      return (new Database('tb_usuario'))->select('id_usuario = "'.$id.'"')->fetchObject(self::class);
    }

    // método responsável por carrega os dados do usuário
    public static function loadUser($userId){

      // buscar usuário
      $objUser = self::getUserById($userId);

      // configurar saída dos dados
      $objUser->id_usuario = (int)$objUser->id_usuario;
      unset($objUser->ds_senha);
      
      // retornar obj usuário
      return $objUser;
    }
  }
?>