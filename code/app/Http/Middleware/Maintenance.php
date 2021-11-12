<?php 
    namespace App\Http\Middleware;

    class Maintenance {

        // método responsável por executar o middleware
        public function handle($request, $next){
            // verifica estado de manutenção da página
            if(getenv('MAINTENANCE') == 'true'){
                throw new \Exception('Página em manutenção tente novamente mais tarde', 200);
            }
            
            // executa o próximo nível do middleware
            return $next($request);
        }
    }
?>