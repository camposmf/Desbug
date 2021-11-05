<?php
  namespace App\Controller\Pages;
  use \App\Utils\View;

  class User extends Page{

    // método responsável por retornar o conteúdo (view) da User
    public static function getUser(){

      // view da home
      $content = View::render('pages/create-user');

      // retornar a view da página
      return parent::getPage('Projeto Interdisciplinar | Desbug', $content);
    }
  }
?>