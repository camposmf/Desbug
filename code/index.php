<?php
  require __DIR__ . './includes/app.php';

  use \App\Http\Router;

  // instância do objeto Router
  $objRouter = new Router(URL);

  // inclui as rotas das páginas
  include __DIR__.'/routes/pages.php';

  // inclui as rotas da Api
  include __DIR__.'/routes/api.php';
  
  // Imprimir response das rotas
  $objRouter->runBarryRun()->sendResponse();
?>