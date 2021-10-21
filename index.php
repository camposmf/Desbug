<?php
  require __DIR__ . '/vendor/autoload.php';

  use \App\Http\Router;
  use \App\Http\Response;
  use \App\Controller\Pages\Home;

  define('URL', 'http://localhost/fatec-dsm-pi-es2');

  $objRouter = new Router(URL);

  // rota home
  $objRouter->get('/', [
    function(){
      return new Response(200, Home::getHome());
    }
  ]);

  // Imprimir response das rotas
  $objRouter->run()->sendResponse();
?>