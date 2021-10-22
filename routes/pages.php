<?php

  use \App\Http\Response;
  use \App\Controller\Pages;

  // home
  $objRouter->get('/', [
    function(){
      return new Response(200, Pages\Home::getHome());
    }
  ]);

  // sobre
  $objRouter->get('/sobre', [
    function(){
      return new Response(200, Pages\About::getAbout());
    }
  ]);

  // dinâmica
  $objRouter->get('/sobre/{idPagina}/{acao}', [
    function($idPagina, $acao){
      return new Response(200, 'Página '.$idPagina.' - '.$acao);
    }
  ]);
?>