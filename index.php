<?php
  require __DIR__ . '/vendor/autoload.php';

  use \App\Http\Router;
  use \App\Utils\View;

  // definir constante
  define('URL', 'http://localhost/fatec-dsm-pi-es2');

  // define valor padrão das variáveis
  View::init([
    'URL' => URL
  ]);

  // instância do objeto Router
  $objRouter = new Router(URL);

  // inclui as rotas das páginas
  include __DIR__.'/routes/pages.php';
  
  // Imprimir response das rotas
  $objRouter->run()->sendResponse();
?>