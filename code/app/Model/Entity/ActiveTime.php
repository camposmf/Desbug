<?php
  namespace App\Model\Entity;

  use App\Db\Database;
  use App\Model\Entity\User;

  Class ActiveTime {
    public $id_tempo;
    public $id_usuario;
    public $dt_entrada;
    public $dt_saida;
    public $dt_tempo_total;
    public $dt_dia_atual;

    // método responsável por inserir registros no banco de dados
    public function insertNewActiveTime(){
      
      // insere tempo de atividade no banco de dados
      $this->id_tempo = (new Database('tb_tempo_ativo'))->insert([
        'id_usuario'    => $this->id_usuario,
        'dt_entrada'    => $this->dt_entrada,
        'dt_saida'      => $this->dt_saida
      ]);

      // retornar sucesso
      return true;
    }

    // método responsável por atualizar registros no banco de dados
    public function updateActiveTime(){
      return (new Database('tb_tempo_ativo'))->update('id_tempo = '.$this->id_tempo, [
        'id_usuario'    => $this->id_usuario,
        'dt_entrada'    => $this->dt_entrada,
        'dt_saida'      => $this->dt_saida
      ]);
    }

    // método responsável por obter os usuários do banco 
    public static function getActiveTimeByDay($id){
      return (new Database('vw_tempo_diario'))->select('id_tempo = "'.$id.'"')->fetchObject(self::class);
    }

    // método responsável por obter registro do banco de dados 
    public static function getActiveTimeById($id){
      return (new Database('tb_tempo_ativo'))->select('id_tempo = "'.$id.'"')->fetchObject(self::class);
    }

    // método responsável por obter registro do banco de dados 
    public static function getTotalTimeById($id){
      return (new Database('vw_tempo_total'))->select('id_usuario = "'.$id.'"')->fetchObject(self::class);
    }
  }  
?>