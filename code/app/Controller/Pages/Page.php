<?php
  namespace App\Controller\Pages;
  use \App\Utils\View;

  class Page{

    // método responsável por retornar o conteúdo (view) da Página genérica
    public static function getPage($title, $content){
      return View::render('pages/page', [
        'title'   => $title,
        'content' => $content,
      ]);
    }    
  }
?>