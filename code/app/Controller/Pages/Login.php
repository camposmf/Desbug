<?php
  namespace App\Controller\Pages;

  use \App\Utils\View;
  use \App\Model\Entity\User;
  use \App\Session\Login as SessionLogin;

  class Login extends Page{

    // método responsável por retornar o conteúdo (view) da Login
    public static function getLogin($request, $errorMessage = null){
      // status
      $status = !is_null($errorMessage) ? View::render('pages/login/status', [
        'mensagem' => $errorMessage
      ]) : '';

      // view da home
      $content = View::render('pages/login', [
        'status' => $status
      ]);

      // retornar a view da página
      return parent::getPage('Login | Projeto Desbug', $content);
    }

    // método responsável por definir o login do usuário
    public static function setLogin($request){
      // receber variáveis do post
      $postVars = $request->getPostVars();

      // validar campos
      $email    = $postVars['email'] ?? '';
      $password = $postVars['password'] ?? '';

      // buscar usuário no banco de dados
      $objUser = User::getUserByEmail($email);

      // validar se existe algum valor na instância de usuário
      if(!$objUser instanceof User){
        return self::getLogin($request, 'E-mail inválido. E-mail não consta em nossa base de dados');
      }

      // verificar a senha do usuário
      if(!password_verify($password, $objUser->ds_senha)){
        return self::getLogin($request, 'Senha inválida. Tente novamente!');
      }
    
      // criar sessão de login
      SessionLogin::login($objUser);

      
      // redirecionar para tela de home
      $request->getRouter()->redirect('/home');
    }

    // método responsável por deslogar o usuário
    public static function setLogout($request){
      // destroi sessão de login
      SessionLogin::logout();

      // redirecionar para tela de login
      $request->getRouter()->redirect('/login');
    }
  }
?>