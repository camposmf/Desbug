<?php
  namespace App\Controller\Pages;
  use \App\Utils\View;

  class Feedback extends Page { 

    // método responsável por retornar o conteúdo (view) do feedback
    public static function getFeedback(){

      // view da Atividade
      $content = View::render('pages/feedback', [
        'header'  => self::getHeader(),
        'footer'  => self::getFooter()
      ]);

      // retornar a view da página
      return parent::getPage('Feedback | Desbug', $content);
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