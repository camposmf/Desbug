<?php

  use \App\Http\Response;
  use \App\Controller\Pages;

  $objRouter->get('/', [
    function(){
      return new Response(200, Pages\Home::getHome());
    }
  ]);

  $objRouter->get('/sobre', [
    function(){
      return new Response(200, Pages\About::getAbout());
    }
  ]);

?>