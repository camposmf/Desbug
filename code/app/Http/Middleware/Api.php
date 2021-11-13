<?php 
    namespace App\Http\Middleware;

    class Api {
        public function handle($request, $next){
            
            // altera o content type para json
            $request->getRouter()->setContentType('application/json');

            // executa o próximo nível do middleware
            return $next($request);
        }
    }
?>