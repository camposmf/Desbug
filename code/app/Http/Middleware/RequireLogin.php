<?php 
    namespace App\Http\Middleware;
    use \App\Session\Login as SessionLogin;
          
    class RequireLogin{

        // método responsável por executar o middleware
        public function handle($request, $next){

            // verificar se o usuário está logado
            if(!SessionLogin::isLogged()){
                $request->getRouter()->redirect('/login');
            }

            // continua a execução 
            return $next($request);
        }
    }
?>