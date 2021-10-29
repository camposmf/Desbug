<?php
  namespace App\Model\Entity;

  Class DataCollect {
    public $id;
    public $Activity;
    public $beforeFeeling;
    public $afterFeeling;
  }

  public function __construct(){
    $this->Activity = new Activity();
  }

  // método responsável por inserir registros no banco
  public function insert(){

    // insere usuário no banco de dados
    $this->id = (new Database('tb_coleta_dado'))->insert([
      'id_atividade'        => $this->Activity->id,
      'vl_sentimento_ant'   => $this->beforeFeeling,
      'vl_sentimento_prox'  => $this->afterFeeling
    ]);

    // retornar sucesso
    return true;
  }

  // método responsável por buscar os sentimentos
  public function getFeeling($feeling, $fields){
    $objDatabase = new Database('tb_coleta_dado');
      return $objDatabase->select('vl_sentimento_prox = '.$feeling, null, null, 'COUNT(*)')
                         ->fetchAll(PDO::FETCH_CLASS, self::class);
  }
?>