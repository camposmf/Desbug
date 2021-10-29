<?php
  namespace App\Common;

  class Environment {
    // método responsável por carregar as variáveis de ambiente do projeto
    public static function load($dir){

      // verifica se o arquivo .env existe
      if(!file_exists($dir.'/.env')){
        return false;
      }

      // define as variáveis de ambiente
      $lines = file($dir.'/.env');
      
      // limpar caracter especial
      foreach($lines as $line) { 
        putenv(trim($line));
      }
    }
  }
?>