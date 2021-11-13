<?php
  namespace App\Controller\Pages;
  use \App\Utils\View;

  class Index extends Page{

    // método responsável por retornar o conteúdo (view) da Home
<<<<<<< HEAD:code/app/Controller/Pages/Home.php
    public static function getHome($request){
=======
    public static function getIndex(){
>>>>>>> 737629d84f916b04e679b730bd5ad6ed039b4875:code/app/Controller/Pages/Index.php

      // view da home
      $content = View::render('pages/index', [
        'header'  => self::getHeader(),
        'footer'  => self::getFooter()
      ]);

      // retornar a view da página
      return parent::getPage('Home | Desbug', $content);
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