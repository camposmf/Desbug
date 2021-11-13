<?php
  namespace App\Controller\Pages;

  use \App\Utils\View;
  use \App\Controller\Pages\Profile;
  use \App\Model\Entity\User as EntityUser;

  class User extends Page{

    // método responsável por retornar o conteúdo (view) da User
    public static function getUser(){

      // view da home
      $content = View::render('pages/user');

      // retornar a view da página
      return parent::getPage('Projeto Interdisciplinar | Desbug', $content);
    } 
    
    // método responsável por cadastrar usuários
    public static function insertUser($request){
      // dados vindos do post
      $postVars = $request->getPostVars();

      // nova instância de usuários para
      $objUser = new EntityUser();
      $objUser->nickname  = $postVars['nickname'];
      $objUser->username  = $postVars['username'];
      $objUser->email     = $postVars['email'];
      $objUser->password  = $postVars['password'];
      $objUser->birthDate = $postVars['birthDate'];
      $objUser->image     = $postVars['image'];

      // chamar método de inserção
      $objUser->insert();

      // retornar página de Perfil
      Profile::getProfile();
    }
  }
?>