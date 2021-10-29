<?php 
  namespace App\Model\Entity;

  use App\Db\Database;
  use \PDO;

  class Testimony{
    public $id;
    public $username;
    public $message;
    public $data;

    // método responsável por inserir depoimentos no banco
    public function insert(){
      // definir data
      $this->data = date('Y-m-d H:i:s');
      
      // insere depoimento no banco de dados
      $this->id = (new Database('depoimento'))->insert([
        'username'        => $this->username,
        'message'         => $this->message,
        'data_testimony'  => $this->data
      ]);

      // retornar sucesso
      return true;
    }

    // método responsável por atualizar depoimentos no banco
    public function update(){
      $objDatabase = new Database('depoimento');
      $objDatabase->update('id = '.$this->id, [
        'username' => $this->username,
        'message' => $this->message,
        'data' => $this->data
      ]);
    }

    // método responsável por deleter um depoimento no banco 
    public function delete(){
      $objDatabase = new Database('depoimento');
      $objDatabase->delete('id = '.$this->id);
    }

    // método responsável por obter os depoimentos do banco 
    public static function get($where = null, $order = null, $limit = null){
      $objDatabase = new Database('depoimento');
      return $objDatabase->select($where, $order, $limit)
                         ->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    // método responsável por obter os depoimentos com base no id
    public static function getById($id){
      $objDatabase = new Database('depoimento');
      return $objDatabase->select('id = '.$id)
                         ->fetchObject(self::class);
    }

    // método responsável por obter a quantidade de depoimentos do banco de dados
    public static function getQuantidadeDepoimentos($where = null){
      $objDatabase = new Database('depoimento', null, null, 'COUT(*) as qtd');
      return $objDatabase->select($where)
                         ->fetchObject()
                         ->qtd;
    }
  }
?>