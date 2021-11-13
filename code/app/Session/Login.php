<?php
    namespace App\Session;

    class Login{

        // método responsável por iniciar a sessão
        private static function init(){
            // verificar se a sessão não está vázia
            if(session_status() != PHP_SESSION_ACTIVE){
                session_start();
            }
        }

        // método responsável por criar o login para o usuário
        public static function login ($objUser){
            
            // iniciar sessão
            self::init();

            // define a sessão do usuário
            $_SESSION['usuario'] = [
               'id_usuario'     => $objUser->id_usuario,
               'nm_nickname'    => $objUser->nm_nickname,
               'nm_usuairo'     => $objUser->nm_usuario,
               'ds_email'       => $objUser->ds_email,
               'ds_senha'       => $objUser->ds_senha, 
               'dt_nascimento'  => $objUser->dt_nascimento,
               'img_usuario'    => $objUser->img_usuario
            ];

            // sucesso
            return true;
        }

        // método responsável por verificar se o usuário está logado
        public static function isLogged(){
            // iniciar sessão
            self::init();

            // retornar verificação
            return isset($_SESSION['usuario']['id_usuario']);
        }

        // método responsável por deslogar do sistema
        public static function logout(){
            // iniciar sessão
            self::init();

            // desloga o usuário
            unset($_SESSION['usuario']);

            // sucesso
            return true;
        }
    }
?>