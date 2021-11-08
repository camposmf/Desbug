<?php

  use \App\Http\Response;
  use \App\Controller\Pages;

  // rota login
  $objRouter->get('/login', [
    'middlewares' => [
      'require-logout'
    ],
    function($request){
      return new Response(200, Pages\Login::getLogin($request));
    }
  ]);
  
  // rota login (Create)
  $objRouter->post('/login', [
    'middlewares' => [
      'require-logout'
    ],
    function($request){
      return new Response(200, Pages\Login::setLogin($request));
    }
  ]);

  // rota logout
  $objRouter->get('/logout', [
    'middlewares' => [
      'require-login'
    ],
    function($request){
      return new Response(200, Pages\Login::setLogout($request));
    }
  ]);

  // rota usuario
  $objRouter->get('/usuario', [
    function($request){
      return new Response(200, Pages\User::getUser($request));
    }
  ]);

  // rota usuario
  $objRouter->post('/usuario', [
    function($request){
      return new Response(200, Pages\User::insertUser($request));;
    }
  ]);

  // rota home
  $objRouter->get('/home', [
    function($request){
      return new Response(200, Pages\Home::getHome($request));
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

  // rota atividade
  $objRouter->get('/atividade', [
    function($request){
      return new Response(200, Pages\Activity::getActivity($request));
    }
  ]);

  // rota feedback
  $objRouter->get('/feedback', [
      function($request){
        return new Response(200, Pages\Feedback::getFeedback($request));
      }
  ]);

  // rota desabafo
    $objRouter->get('/desabafo', [
      function($request){
        return new Response(200, Pages\Desabafo::getDesabafo($request));
      }
  ]);

  // rota centrais de ajuda
  $objRouter->get('/centrais', [
    function($request){
      return new Response(200, Pages\Centrais::getCentrais($request));
    }
  ]);
?>