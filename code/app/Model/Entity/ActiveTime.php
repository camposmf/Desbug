<?php
  namespace App\Model\Entity;

  use App\Db\Database;
  use App\Model\Entity\User;

  Class ActiveTime {
    public $id;
    public $User;
    public $entryDate;
    public $departureDate;

    // método responsável por instânciar a classe
    public function __construct(){
      $this->User = new User();
    }
  
    // método responsável por inserir registros no banco de dados
    public function insert(){
      // definir valores
      $this->departureDate = null;
      $this->activeDay = date('z');
      $this->data = date('Y-m-d H:i:s');

      // insere tempo de atividade no banco de dados
      $this->id = (new Database('tb_tempo_ativo'))->insert([
        'id_usuario'    => $this->User->id,
        'dt_entrada'    => $this->entryDate,
        'dt_saida'      => $this->departureDate
      ]);

      // retornar sucesso
      return true;
    }

    // método responsável por atualizar registros no banco de dados
    public function update(){
      $objDatabase = new Database('tb_tempo_ativo');
      $objDatabase->update('id_tempo = '.$this->id, [
        'id_usuario'    => $this->User->id,
        'dt_entrada'    => $this->entryDate,
        'dt_saida'      => $this->departureDate
      ]);
    }

    // método responsável por obter os usuários do banco 
    public static function get($fields){
      $objDatabase = new Database('tb_tempo_ativo');
      return $objDatabase->select()
                         ->fetchAll(PDO::FETCH_CLASS, self::class);
    }
  }  
?>