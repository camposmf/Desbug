<?php 
    namespace App\Http\Middleware;
    use \App\Model\Entity\User;

    class UserBasicAuth {

        // método repsonsável por retornar uma instância de um usuário autenticado
        private function getBasicAuthUser(){

            // verifica a existência dos dados de acesso
            if(!isset($_SERVER['PHP_AUTH_USER']) OR !isset($_SERVER['PHP_AUTH_PW'])){
                return false;
            }

            // busca o usuário por e-mail
            $objUser = User::getUserByEmail($_SERVER['PHP_AUTH_USER']);

            // verifica a instância do usuário
            if(!$objUser instanceof User){
                return false;
            }

            // valida a senha e retorna o usuário
            return password_verify($_SERVER['PHP_AUTH_PW'], $objUser->ds_senha) ? $objUser : false;
        }

        // método responsável por validar o acesso via basic auth
        private function basicAuth($request){

            // retornar uma instância de usuário logado
            if($objUser = $this->getBasicAuthUser()) {
                $request->user = $objUser;
                return true;
            }

            // emite o erro de acesso inválido
            throw new \Exception('Usuário ou senha inválidos', 403);
        }
        
        // método responsável por executar o middleware
        public function handle($request, $next){
            
            // realiza a validação do acesso via basic auth
            $this->basicAuth($request);

            // executa o próximo nível do middleware
            return $next($request);
        }

    }
?>