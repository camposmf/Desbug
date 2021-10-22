<?php
  namespace App\Controller\Pages;
  use \App\Utils\View;
  use \App\Model\Entity\User;

  class Home extends Page{

    // método responsável por retornar o conteúdo (view) da Home
    public static function getHome(){

      $objUser = new User;

      // view da home
      $content = View::render('pages/home', [
        'username'    => $objUser->username,
        'nickname'    => $objUser->nickname,
        'email'       => $objUser->email,
        'password'    => $objUser->password,
        'birthDate'   => $objUser->birthDate,
        'image'       => $objUser->image
      ]);

      // retornar a view da página
      return parent::getPage('Projeto Interdisciplinar | Desbug', $content);
    }    
  }
?>