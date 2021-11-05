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

    // método responsável por renderizar o topo da página
    private static function getHeader(){
      return View::render('pages/header');
    }

    // método responsável por renderizar o rodapé da página
    private static function getFooter(){
      return View::render('pages/footer');
    }
  }
?>