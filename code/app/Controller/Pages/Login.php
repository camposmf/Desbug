<?php
  namespace App\Controller\Pages;
  use \App\Utils\View;
  use \App\Model\Entity\User;

  class Login extends Page{

    // método responsável por retornar o conteúdo (view) da Login
    public static function getLogin(){

      // view da home
      $content = View::render('pages/login');

      // retornar a view da página
      return parent::getPage('Projeto Interdisciplinar | Desbug', $content);
    }    
  }
?>