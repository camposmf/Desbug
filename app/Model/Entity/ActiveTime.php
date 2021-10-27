<?php
  namespace App\Model\Entity;

  use \PDO;
  use App\Db\Database;
  use App\Model\Entity\User;

  Class ActiveTime {
    public $id;
    public $User;
    public $activeDay;
    public $entryDate;
    public $departureDate;

    // método responsável por instânciar a classe
    public function __construct(){
      $this->User = new User();
    }
  
    // método responsável por inserir depoimentos no banco
    public function insert(){
      // definir valores
      $this->departureDate = null;
      $this->activeDay = date('z');
      $this->data = date('Y-m-d H:i:s');

      // insere tempo de atividade no banco de dados
      $this->id = (new Database('tb_tempo_ativo'))->insert([
        'id_usuario'    => $this->User->id,
        'nr_dia_ativo'  => $this->activeDay,
        'dt_entrada'    => $this->entryDate,
        'dt_saida'      => $this->departureDate
      ]);

      // retornar sucesso
      return true;
    }

    // método responsável por atualizar depoimentos no banco  
    public function update(){
      $objDatabase = new Database('tb_tempo_ativo');
      $objDatabase->update('id = '.$this->id, [
        'id_usuario'    => $this->User->id,
        'nr_dia_ativo'  => $this->activeDay,
        'dt_entrada'    => $this->entryDate,
        'dt_saida'      => $this->departureDate
      ]);
    }
  }  
?>