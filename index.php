<?php
  require __DIR__ . '/vendor/autoload.php';

  use \App\Controller\Pages\Home;
  use \App\Http\Request;
  use \App\Http\Response;

  $objResponse = new Response(200, 'Olá mundo!');
  $objResponse->sendResponse();

  echo Home::getHome();
?>