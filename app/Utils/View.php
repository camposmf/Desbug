<?php
  namespace App\Utils;

  // classe responsável por renderizar views
  class View {

    // método responsável por retornar o conteúdo renderizado de uma view
    public static function render($viewName, $vars = []){
      // conteúdo view
      $contentView = self::getContentView($viewName);

      // pegando chaves do array de variáveis
      $keys = array_keys($vars);
      $keys = array_map(function($item){
        return '{{'.$item.'}}';
      }, $keys);
      
      // retornar conteúdo renderizado
      return str_replace($keys, array_values($vars), $contentView);
    }

    // método responsável por retornar o conteúdo de uma view
    private static function getContentView($viewName){
      $file = __DIR__ . '/../../public/view/'.$viewName.'.html';
      return file_exists($file) ? file_get_contents($file) : '';
    }

  }
?>