<?php
  require __DIR__ . './../vendor/autoload.php';

  use \App\Utils\View;
  use \App\Common\Environment;
  use \App\Db\Database;
  
  // carrega as variáveis de ambiente do projeto
  Environment::load(__DIR__.'/../');

  // define as config de banco de dados
  Database::config(
    getenv('DB_HOST'),
    getenv('DB_NAME'),
    getenv('DB_USER'),
    getenv('DB_PASS'),
  );

  // definir constante
  define('URL', getenv('URL'));

  // define valor padrão das variáveis
  View::init([
    'URL' => URL
  ]);
?>