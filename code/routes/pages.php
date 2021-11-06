<?php

  use \App\Http\Response;
  use \App\Controller\Pages;

  // rota login (Read)
  $objRouter->get('/login', [
    function($request){
      return new Response(200, Pages\Login::getLogin($request));
    }
  ]);

  // rota login (Create)
  $objRouter->post('/login', [
    function($request){
      return new Response(200, Pages\Login::setLogin($request));
    }
  ]);

  // rota usuario (Read)
  $objRouter->get('/usuario', [
    function($request){
      return new Response(200, Pages\User::getUser($request));
    }
  ]);

  // rota usuario (Create)
  $objRouter->post('/usuario', [
    function($request){
      return new Response(200, Pages\User::insertUser($request));;
    }
  ]);

  // rota perfil
  $objRouter->get('/perfil', [
    function($request){
      return new Response(200, Pages\Profile::getProfile($request));
    }
  ]);

  // rota perfil
  $objRouter->post('/perfil', [
    function($request){
      return new Response(200, Pages\Profile::getProfile($request));
    }
  ]);

  // rota perfil
  $objRouter->get('/home', [
    function($request){
      return new Response(200, Pages\Home::getHome($request));
    }
  ]);

  // rota atividade
  $objRouter->get('/atividade', [
    function($request){
      return new Response(200, Pages\Activity::getActivity($request));
    }
  ]);
?>