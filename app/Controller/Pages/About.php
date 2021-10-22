<?php
  namespace App\Controller\Pages;
  use \App\Utils\View;
  use \App\Model\Entity\User;

  class About extends Page{

    // método responsável por retornar o conteúdo (view) da About
    public static function getAbout(){

      $objUser = new User;

      // view da home
      $content = View::render('pages/about', [
        'nickname'    => $objUser->nickname,
        'email'       => $objUser->email,
        'birthDate'   => $objUser->birthDate,
      ]);

      // retornar a view da página
      return parent::getPage('Projeto Interdisciplinar | Desbug', $content);
    }    
  }
?>
