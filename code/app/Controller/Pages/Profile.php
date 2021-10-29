<?php
  namespace App\Controller\Pages;
  use \App\Utils\View;

  class Profile extends Page{

    // método responsável por retornar o conteúdo (view) da profile
    public static function getProfile(){

      // view da profile
      $content = View::render('pages/profile');

      // retornar a view da página
      return parent::getPage('Projeto Interdisciplinar | Desbug', $content);
    }    
  }
?>