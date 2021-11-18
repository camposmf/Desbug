<?php
  namespace App\Model\Entity;

  use \PDO;
  use App\Db\Database;

  Class Medal {
    public $id_medalha;
    public $ds_medalha;
    public $img_medalha;
    public $vl_medalha_total;

    
    // método responsável por inserir medalhas no banco
    public function insertNewMedal(){

      // insere nova medalha no banco de dados
      $this->id_medalha = (new Database('tb_medalha'))->insert([
        'ds_medalha'        =>  $this->ds_medalha,
        'img_medalha'       =>  $this->img_medalha,
        'vl_medalha_total'  =>  $this->vl_medalha_total
      ]);

      // retorna sucesso
      return true;
    }

    public function updateMedal(){
      return (new Database('tb_medalha'))->update('id_medalha = '.$this->id_medalha, [
        'ds_medalha'        =>  $this->ds_medalha,
        'img_medalha'       =>  $this->img_medalha,
        'vl_medalha_total'  =>  $this->vl_medalha_total
      ]);
    }

    public function deleteMedal(){
      return (new Database('tb_medalha'))->delete('id_medalha = '.$this->id_medalha);
    }

    // método responsável por obter as medalhas no banco
    public static function getMedals($where = null, $order = null, $limit = null, $fields = '*'){
      return (new Database('tb_medalha'))->select($where, $order, $limit, $fields);
    }

    // método responsável por buscar uma medalha atráves do id
    public static function getMedalById($id){
      return(new Database('tb_medalha'))->select('id_medalha = "'.$id.'"')->fetchObject(self::class);
    }

    // método responsável por buscar uma medalha atráves da descrição (nome)
    public static function getMedalByName($name){
      return(new Database('tb_medalha'))->select('ds_medalha = "'.$name.'"')->fetchObject(self::class);
    }
  }
?>