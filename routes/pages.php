<?php

  use \App\Http\Response;
  use \App\Controller\Pages;

  // rota login
  $objRouter->get('/', [
    function(){
      return new Response(200, Pages\Login::getLogin());
    }
  ]);

  // rota usuario (GET)
  $objRouter->get('/usuario', [
    function(){
      return new Response(200, Pages\User::getUser());
    }
  ]);

  // rota perfil
  $objRouter->get('/perfil', [
    function(){
      return new Response(200, Pages\Profile::getProfile());
    }
  ]);

  // rota perfil
  $objRouter->get('/home', [
    function(){
      return new Response(200, Pages\Home::getHome());
    }
  ]);
?>