<?php
  require __DIR__ . './../vendor/autoload.php';

  use \App\Utils\View;
  use \App\Db\Database;
  use \App\Common\Environment;
  use \App\Http\Middleware\Queue as MiddlewareQueue;

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

  // define o mapeamento dos middlewares
  MiddlewareQueue::setMap([
    'maintenance'      => \App\Http\Middleware\Maintenance::class,
    'require-logout'   => \App\Http\Middleware\RequireLogout::class,
    'require-login'    => \App\Http\Middleware\RequireLogin::class,
    'api'              => \App\Http\Middleware\Api::class,
    'user-basic-auth'  => \App\Http\Middleware\UserBasicAuth::class
  ]);

  // define o mapeamento dos middlewares padrões (Executados em todas as rotas)
  MiddlewareQueue::setDefault([
    'maintenance'
  ]);
?>