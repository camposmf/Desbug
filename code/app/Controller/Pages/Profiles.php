<?php
  namespace App\Controller\Pages;
  use \App\Utils\View;

  class Profiles extends Page{

    // método responsável por retornar o conteúdo (view) da profile
    public static function getProfiles(){

      // view da profile
      $content = View::render('pages/profiles');

      // retornar a view da página
      return parent::getPage('Projeto Interdisciplinar | Desbug', $content);
    }    
  }
?>