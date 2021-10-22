<?php 
  namespace App\Db;

  use \PDO;
  use \PDOException;

  define('HOST', getenv('DB_HOST'));
  define('NAME', getenv('DB_NAME'));
  define('USER', getenv('DB_USER'));
  define('PASSWORD', getenv('DB_PASSWORD'));

  class Database {
    // nome da tabela a ser manipulada
    private $table; 

    // instância de conexão com o banco de dados
    private $connection;

    public function __construct($table = null) {
      $this->table = $table;
      $this->setConnection();
    }

    // método responsável de criar uma conexão com o banco de dados
    private function setConnection() {
      try {
        $this->connection = new PDO('mysql:host='.HOST.';dbname='.NAME,USER,PASSWORD);
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch (PDOException $e) {
        die('ERROR: '.$e->getMessage());
      }
    }

    // método responsável por executar queries dentro do db
    public function execute($query, $params = []){
      try {
        $statement = $this->connection->prepare($query);
        $statement->execute($params);
        return $statement;
      } catch (PDOException $e) {
        die('ERROR: '.$e->getMessage());
      }
    }

    // método responsável por inserir dados no banco
    public function insert ($values = []){
      // dados da querry
      $fields = array_keys($values);
      $binds = array_pad([], count($fields), '?');

      // monta query
      $query = 'INSERT INTO '.$this->table.' ('.implode(',', $fields).') VALUES ('.implode(',',$binds).')';

      // executa o insert
      $this->execute($query, array_values($values));

      // retornar o id inserido
      return $this->connection->lastInsertId();
    }

    // método responsável por executar atualizações no banco
    public function update($where, $values){
      // dados da query
      $fields = array_keys($values);

      // monta query
      $query = 'UPDATE '.$this->table.' SET '.implode('=?', $fields).'=? WHERE '.$where;

      // executar a query
      $this->execute($query, array_values($fields));

      // retorna sucesso
      return true;
    }

    // método responsável por executar atualizações no banco
    public function delete($where){
      // monta query
      $query = 'DELETE FROM '.$this->table.' WHERE '.$where;

      // executar a query
      $this->execute($query);

      // retorna sucesso
      return true;
    }

    // método responsável por executar uma consulta no banco
    public function select($where = null, $order = null, $limit = null, $fields = '*'){
      // dados da query
      $where = strlen($where) ? 'WHERE '.$where : '';
      $limit = strlen($limit) ? 'LIMIT '.$limit : '';
      $order = strlen($order) ? 'ORDER BY '.$order : '';

      // montar query
      $query = 'SELECT '.$fields.' FROM '. $this->table.' '.$where.' '.$order.' '.$limit;

      // executa a query
      return $this->execute($query);
    }
  }
?>