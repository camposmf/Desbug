<?php
  require __DIR__ . './../vendor/autoload.php';
  use \App\Common\Environment;

  // carrega as variáveis de ambiente do projeto
  Environment::load(__DIR__.'/../');
?>